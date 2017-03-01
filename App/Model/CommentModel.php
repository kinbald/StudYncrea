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

    public function add_comment_bdd($id_post, $id_type, $id_user, $url_picture, $data, $id_comment, $id_comment_father)
    {
        $date = date('Y-m-d G:i:s');

        if ($url_picture != null) {
            if ($id_comment_father != 'null') {
                $sql = "
                INSERT INTO comments(content, date_comment, url_photo_comment, id_user, id_type, id_post, id_comment, id_comment_father) 
                VALUES(:content, :date_comment, :url_picture, :id_user, :id_type, :id_post, :id_comment, :id_comment_father)
                ";
                $param = [
                'content' => $data,
                'id_type' => $id_type,
                'date_comment' => $date,
                'id_user' => $id_user,
                'url_picture' => $url_picture,
                'id_post' => $id_post,
                'id_comment' => $id_comment,
                'id_comment_father' => $id_comment_father
                ];
                $res = $this->executeReq($sql, $param, 0);
            } else {
                $sql = "
                INSERT INTO comments(content, date_comment, url_photo_comment, id_user, id_type, id_post, id_comment) 
                VALUES(:content, :date_comment, :url_picture, :id_user, :id_type, :id_post, :id_comment)
                ";
                $param = [
                'content' => $data,
                'id_type' => $id_type,
                'date_comment' => $date,
                'id_user' => $id_user,
                'url_picture' => $url_picture,
                'id_post' => $id_post,
                'id_comment' => $id_comment
                ];
                $res = $this->executeReq($sql, $param, 0);
            }
        } else {
            if ($id_comment_father != 'null') {
                $sql = "
                INSERT INTO comments(content, date_comment, id_user, id_type, id_post, id_comment, id_comment_father) 
                VALUES(:content, :date_comment, :id_user, :id_type, :id_post, :id_comment, :id_comment_father)
                ";
                $param = [
                'content' => $data,
                'id_type' => $id_type,
                'date_comment' => $date,
                'id_user' => $id_user,
                'id_post' => $id_post,
                'id_comment' => $id_comment,
                'id_comment_father' => $id_comment_father
                ];
                $res = $this->executeReq($sql, $param, 0);
            } else {
                $sql = "
                INSERT INTO comments(content, date_comment, id_user, id_type, id_post, id_comment) 
                VALUES(:content, :date_comment, :id_user, :id_type, :id_post, :id_comment)
                ";
                $param = [
                'content' => $data,
                'id_type' => $id_type,
                'date_comment' => $date,
                'id_user' => $id_user,
                'id_post' => $id_post,
                'id_comment' => $id_comment
                ];
                $res = $this->executeReq($sql, $param, 0);
            }
        }
        return 0;
    }

    public function number_comment_post($id_post)
    {
        $sql = "SELECT count(*) as response_number FROM COMMENTS WHERE id_post = ?";
        $result = $this->executeReq($sql, [$id_post], 1);
        return $result;
    }
    public function display_comment($id_post, $type)
    {
        $param1 = [
        'id_post' => $id_post
        ];
        $req1 = $this->executeReq('SELECT * FROM COMMENTS WHERE id_post = :id_post AND id_comment_father IS NULL ORDER BY id_comment', $param1, 2);

        foreach ($req1 as $data1) {
            ?>

            <div class="row">
                <div class="col s12 card-panel">
                    <p> <?php echo $data1['content']; ?>
                        <?php if ($data1['url_photo_comment'] != null) {
                            ?> <img <img class="materialboxed"  width="200" src="<?php echo $data1['url_photo_comment']; ?>"></p>
                            <?php
                        }
                        $param2 = [
                        'id_post' => $id_post,
                        'id_comment_father' => $data1['id_comment']
                        ];
                        $req2 = $this->executeReq('SELECT * FROM COMMENTS WHERE id_post = :id_post AND id_comment_father = :id_comment_father ORDER BY id_comment', $param2, 2);

                        $count = count($req2);
                        if ($count) {
                            foreach ($req2 as $data2) {
                                ?>
                            </div>
                            <div class="col s11 offset-s1 card-panel">
                                <p><?php echo $data2['content']; ?>
                                    <?php if ($data2['url_photo_comment'] != null) {
                                        ?> <img class="materialboxed" width="200" src="<?php echo $data2['url_photo_comment']; ?>"></p>
                                        <?php
                                    }
                                }
                                $this->display_form_comment($data1, $type);
                                echo "</div></div>";
                            }
                            if(!$count)
                            {
                                $this->display_form_comment($data1, $type);
                                echo "</div></div>";
                            }
                        }
                    }

                    public function display_form_comment($data1, $type)
                    {
                        if(!empty($data1['id_comment']))
                        {
                            $value = $data1['id_comment'];
                        }
                        else
                        {
                            $value = null;
                        }

                        echo "
                        <p>
                            <form id=\"comments\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">
                                <div class=\"input-field\">
                                    <input type=\"text\" id=\"comment\" name=\"comment\" class=\"validate\"/>
                                    <label for=\"comment\">Votre commentaire</label>
                                </div>
                                <div class=\"file-field  input-field\">
                                    <div class=\"btn\">
                                        <span>Une photo</span>
                                        <input type=\"file\" name=\"url_picture\">
                                    </div>
                                    <div class=\"file-path-wrapper\">
                                        <input class=\"file-path validate\" type=\"text\">
                                    </div>
                                </div>            
                                <input type=\"hidden\" name=\"id_type\" value=\"$type\"/>
                                <input type=\"hidden\" name=\"id_post\" value=\"". $data1['id_post'] ."\"/>
                                <input type=\"hidden\" name=\"id_comment_father\" value=\"$value\"/>

                                <div class=\"input-field\">
                                    <input class=\"btn waves-effect waves-light\" type=\"submit\" value=\"Envoyer\" >
                                </div>
                            </form>
                        </p>        
                        ";
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
