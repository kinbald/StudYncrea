<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 09/01/17
 * Time: 16:28
 */

namespace App\Model;


use Core\Model\Model;

class CommentModel extends Model
{
    public static $table = 'COMMENTS';
    private $_idName = 'id_comment';

    public function checkParentExist($idParent)
    {
        $sql = 'SELECT id_comment, depth FROM ' . static::$table . ' WHERE id_comment = ?';
        return $this->executeReq($sql, [$idParent], 1);
    }

    public function add_comment_bdd($id_post, $id_type, $id_user, $url_picture, $data, $id_comment, $id_comment_father)
    {
        $depth = 0;
        $date = date('Y-m-d G:i:s');

        if ($id_comment_father != 0) {
            $comment = $this->checkParentExist($id_comment_father);
            if ($comment == false) {
                throw new Exception('Ce parent n\'existe pas');
            }
            $depth = $comment['depth'] + 1;
        }

        if ($depth >= 2) {
            return -1;
        } else {
            if ($url_picture != null) {

                $sql = "
                    INSERT INTO " . static::$table . "(content, date_comment, url_photo_comment, id_user, id_type, id_post, id_comment, id_comment_father, depth) 
                    VALUES(:content, :date_comment, :url_picture, :id_user, :id_type, :id_post, :id_comment, :id_comment_father, :depth)
                    ";
                $param = [
                    'content' => $data,
                    'id_type' => $id_type,
                    'date_comment' => $date,
                    'id_user' => $id_user,
                    'url_picture' => $url_picture,
                    'id_post' => $id_post,
                    'id_comment' => $id_comment,
                    'id_comment_father' => $id_comment_father,
                    'depth' => $depth
                ];
                $res = $this->executeReq($sql, $param, 0);
            } else {
                $sql = "
                  INSERT INTO " . static::$table . "(content, date_comment, id_user, id_type, id_post, id_comment, id_comment_father, depth) 
                  VALUES(:content, :date_comment, :id_user, :id_type, :id_post, :id_comment, :id_comment_father, :depth)
                  ";
                $param = [
                    'content' => $data,
                    'id_type' => $id_type,
                    'date_comment' => $date,
                    'id_user' => $id_user,
                    'id_post' => $id_post,
                    'id_comment' => $id_comment,
                    'id_comment_father' => $id_comment_father,
                    'depth' => $depth
                ];
                $res = $this->executeReq($sql, $param, 0);
            }
        }
        return 0;
    }

    /**
     * Récupère tous les commentaire organisé par ID
     * @param $post_id
     * @return array
     */
    public function findAllById($post_id)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id_post = ? AND is_online=1";
        $comments = $this->executeReq($sql, [$post_id], 4);
        $comments_by_id = [];
        foreach ($comments as $comment) {
            $comments_by_id[$comment->id_comment] = $comment;
        }
        return $comments_by_id;
    }

    /**
     * Permet de récupérer les commentaires avec les enfants
     * @param $post_id
     * @param bool $unset_children Doit-t-on supprimer les commentaires qui sont des enfants des résultats ?
     * @return array
     */
    public function findAllWithChildren($post_id, $unset_children = true)
    {
        // On a besoin de 2 variables
        // comments_by_id ne sera jamais modifié alors que comments
        $comments = $commentsById = $this->findAllById($post_id);
        foreach ($comments as $id => $comment) {
            if ($comment->id_comment_father != NULL) {
                $commentsById[$comment->id_comment_father]->children[] = $comment;
                if ($unset_children) {
                    unset($comments[$id]);
                }
            }
        }
        return $comments;
    }

    /**
     * Permet de supprimer un commentaire et ces enfants
     * @param $id_comment
     * @return int
     */
    public function deleteWithChildren($id_comment)
    {
        // On récupère le commentaire à supprimer
        $comment = $this->findBy('id_comment', [$id_comment], 3);
        $comments = $this->findAllWithChildren($comment->id_post, false);
        if(isset($comments[$comment->id_comment]->children))
        {
            $ids = $this->getChildrenIds($comments[$comment->id_comment]);
            $ids[] = $comment->id_comment;
        }
        else
        {
            $ids[] = $id_comment;
        }

        // On supprime le commentaire et ses enfants
        $sql = 'UPDATE '. static::$table .' SET is_online=0 WHERE ' . $this->getIdName() . ' IN (' . implode(',', $ids) . ')';
        $this->executeReq($sql, null, -1);
        return $ids;
    }

    public function number_comment_post($id_post)
    {
        $sql = "SELECT count(*) as response_number FROM " . static::$table . " WHERE id_post=? AND is_online=1";
        $result = $this->executeReq($sql, [$id_post], 1);
        return $result;
    }
    
    /**
     * Get all chidren ids of a comment
     * @param $comment
     * @return array
     */
    private function getChildrenIds($comment)
    {
        $ids = [];
        foreach ($comment->children as $child) {
            $ids[] = $child->id_comment;
            if (isset($child->children)) {
                $ids = array_merge($ids, $this->getChildrenIds($child));
            }
        }
        return $ids;
    }

    /**
     * @return string
     */
    public
    function getIdName()
    {
        return $this->_idName;
    }
}
