<?php

/*
	@author : Herrenschmidt Félix
*/
namespace App\Model;

use Core\Model\Model;

class TopicModel extends Model
{
    public static $table = 'POSTS';
    private $_idName = 'id_post';

    /*
    Affichage du  temps écoulé en fonction de la date du post. ($date_post en format sql classique 2017-02-08 06:07:09)
    */
    public static function display_date($date_post)
    {
        $data1 = $date_post;//On récupère la date
        list($date, $time) = explode(" ", $data1);//On la sépare en 2

        //On place dans les bonnes variables chaque attributs
        list($annee, $mois, $jour) = explode("-", $date);
        list($heure, $minute, $seconde) = explode(":", $time);

        date_default_timezone_set('CET'); //Changement du fusiau horaire
        $timestamp = mktime($heure, $minute, $seconde, $mois, $jour, $annee);
        $time = time() - $timestamp;

        $seconde = floor($time);
        $minute = floor($seconde / 60);
        $heure = floor($minute / 60);
        $jour = floor($heure / 24);
        $mois = floor($jour / 31);
        $annee = floor($jour / 365.25);

        //Affiche une phrase différente selon la date du post (gére l'orthographe)
        if ($seconde < 59) {
            if ($seconde == 1) echo "Il y a " . $seconde . " seconde";
            else echo "Il y a " . $seconde . " secondes";
        } elseif ($minute < 59) {
            if ($minute == 1) echo "Il y a " . $minute . " minute";
            else echo "Il y a " . $minute . " minutes";
        } elseif ($heure < 23) {
            if ($heure == 1) echo "Il y a " . $heure . " heure";
            else echo "Il y a " . $heure . " heures";
        } elseif ($jour < 30) {
            if ($jour == 1) echo "Il y a " . $jour . " jour";
            else echo "Il y a " . $jour . " jours";
        } elseif ($mois < 12) {
            if ($mois == 1) echo "Il y a " . $mois . " mois";
            else echo "Il y a " . $mois . " mois";
        } else {
            if ($annee == 1) echo "Il y a " . $annee . " an";
            else echo "Il y a " . $annee . " ans";
        }
    }

    public function display_proms_all()
    {
        $sql = "SELECT * FROM PROMS
        ORDER BY id_class ASC";
        $result = $this->executeReq($sql);
        return $result;
    }

    public function display_subjects_all()
    {
        $sql = "SELECT * FROM SUBJECTS
        ORDER BY id_subject ASC";
        $result = $this->executeReq($sql);
        return $result;
    }

    /*Affiche en premier le plus récent*/
    public function display_topic_live()
    {
        $sql = "SELECT * FROM POSTS 
        INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        INNER JOIN USERS on USERS.id_user = POSTS.id_user
        WHERE type_post = 1 
        ORDER BY date_post DESC";
        $result = $this->executeReq($sql);
        return $result;
    }

    public function display_topic_teachers()
    {
        $sql = "SELECT * FROM teach 
        INNER JOIN USERS on USERS.id_user = teach.id_user
        ORDER BY USERS.name_user ASC";
        $result = $this->executeReq($sql);
        return $result;
    }

    public function display_topic_chapter()
    {
        $sql = "SELECT * FROM CHAPTER 
        ORDER BY name_chapter ASC";
        $result = $this->executeReq($sql);
        return $result;
    }

    public function display_topic_id($id_topic)
    {
        $sql = "SELECT * FROM POSTS 
        INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        INNER JOIN USERS on USERS.id_user = POSTS.id_user
        WHERE POSTS.id_post = ?";
        $result = $this->executeReq($sql, [$id_topic], 1);
        return $result;
    }

    /*Entrée : type: chaine de caractère : Nom de la promo*/
    public function display_topic_class($class)
    {
        $a = [
            'class' => $class,
        ];
        $sql = "SELECT * FROM POSTS 
        INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        INNER JOIN USERS on USERS.id_user = POSTS.id_user
        WHERE type_post = 1 AND name_class = :class
        ORDER BY date_post DESC";
        $result = $this->executeReq($sql, $a);
        return $result;
    }

    public function display_topic_filtres($id_class,$id_subject,$id_teach,$id_style,$id_chapter,$limit = 20)
    public function display_topic_filtres($id_class, $id_subject, $id_teach, $id_style, $id_chapter, $data ='')
    {

        $sql = "SELECT * FROM POSTS 
        INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        INNER JOIN USERS on USERS.id_user = POSTS.id_user
        WHERE type_post = 1 and is_online=1 ";
        if($data != '')
        {
            $sql = $sql . 'AND ( title LIKE \'%' . $data.'%\' OR \'%' . strtolower ($data).'%\') ';
        }
        if ($id_class != '') {
            $a = explode(",", $id_class);
            foreach ($a as $id => $value) {
                if ($id == 0) {
                    $sql = $sql . "AND ( POSTS.id_class = '$value' ";
                } else {
                    $sql = $sql . "OR POSTS.id_class = '$value' ";
                }
            }
            $sql = $sql . " ) ";
        }

        if ($id_subject != '') {
            $b = explode(",", $id_subject);
            foreach ($b as $id => $value2) {
                if ($id == 0) {
                    $sql = $sql . "AND ( POSTS.id_subject = '$value2' ";
                } else {
                    $sql = $sql . "OR POSTS.id_subject = '$value2' ";
                }
            }
            $sql = $sql . " ) ";
        }

        if ($id_teach != '') {
            $c = explode(",", $id_teach);
            foreach ($c as $id => $value3) {
                if ($id == 0) {
                    $sql = $sql . "AND ( POSTS.id_user_teacher = '$value3' ";
                } else {
                    $sql = $sql . "OR POSTS.id_user_teacher = '$value3' ";
                }
            }
            $sql = $sql . " ) ";
        }

        if ($id_style != '') {
            $d = explode(",", $id_style);
            foreach ($d as $id => $value4) {
                if ($id == 0) {
                    $sql = $sql . "AND ( POSTS.style_post = '$value4' ";
                } else {
                    $sql = $sql . "OR POSTS.style_post = '$value4' ";
                }
            }
            $sql = $sql . " ) ";
        }

        if ($id_chapter != '') {
            $e = explode(",", $id_chapter);
            foreach ($e as $id => $value5) {
                if ($id == 0) {
                    $sql = $sql . "AND ( POSTS.id_chapter = '$value5' ";
                } else {
                    $sql = $sql . "OR POSTS.id_chapter = '$value5' ";
                }
            }
            $sql = $sql . " ) ";
        }

        $sql = $sql . "ORDER BY date_post DESC
                       LIMIT $limit ";
        // die($sql);
        $result = $this->executeReq($sql);

        return $result;
    }

    /*Entrée: type: chaine de caractère: Titre du topic*/
    public function display_topic_title($title)
    {

        $a = [
            'title' => $title,
        ];
        $sql = "SELECT * FROM POSTS 
        INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        INNER JOIN USERS on USERS.id_user = POSTS.id_user
        WHERE type_post = 1 AND title = :title";
        $result = $this->executeReq($sql, $a);
        return $result;
    }

    /*Entrée: type: chaine de caractère sous forme de type date : Date du post*/
    public function display_topic_date_post($date_post)
    {

        $a = [
            'date_post' => $date_post,
        ];
        $sql = "SELECT * FROM POSTS
        INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject 
        INNER JOIN USERS on USERS.id_user = POSTS.id_user
        WHERE type_post = 1 AND date_post = :date_post
        ORDER BY date_post DESC";
        $result = $this->executeReq($sql, $a);
        return $result;
    }

    /*Update pour la modification de chaques éléments du topic*/
    public function update_url_file($id_topic, $new_url_file)
    {

        $a = [
            'url' => $new_url_file,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET url_file = :url WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function update_title($id_topic, $new_title)
    {
        $a = [
            'title_topic' => $new_title,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET title = :title_topic WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function update_description($id_topic, $new_description)
    {

        $a = [
            'description_topic' => $new_description,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET description = :description_topic WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function update_date_correction($id_topic, $date_correction)
    {

        $a = [
            'date_topic' => $date_correction,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET date_correction = :date_topic WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function update_subject($id_topic, $id_subject)
    {

        $a = [
            'id_subject' => $id_subject,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET id_subject = :id_subject WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function update_chapter($id_topic, $id_chapter)
    {
        $a = [
            'chapter' => $id_chapter,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET id_chapter = :chapter WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function update_prof($id_topic, $id_user_prof)
    {
        $a = [
            'id_prof' => $id_user_prof,
            'id_topic' => $id_topic,
        ];
        $sql = "UPDATE POSTS SET id_user_USERS = :id_prof WHERE id_post = :id_topic";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    public function getAllByUserId($user_id)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id_user=$user_id AND type_post=1 ORDER BY date_post DESC";
        return $this->executeReq($sql, null, 2);
    }

    public function delete_post($id_post)
    {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE id_post = :id_post';
        $posts = $this->executeReq($sql, array('id_post' => $id_post), 2);

        foreach($posts as $post) {
            if ($post['url_file'] != NULL) {
                unlink($post['url_file']);
            }
            if ($post['url_file_secondary'] != NULL) {
                unlink($post['url_file_secondary']);
            }
            if ($post['url_correction'] != NULL) {
                unlink($post['url_correction']);
            }
        }

        $sql = 'DELETE FROM ' . static::$table . ' WHERE id_post = :id_post';
        $this->executeReq($sql, array('id_post' => $id_post));
    }

    public function change_view($id_post, $online)
    {
        $param = [
            'is_online' => $online,
            'id_post' => $id_post,
        ];
        $sql = 'UPDATE ' . static::$table . ' SET is_online = :is_online WHERE id_post = :id_post';
        $this->executeReq($sql, $param, 0);
    }

    public function addCorrection($id_topic, $correction)
    {
        $date = date('y-m-d H:i:s');

        $a = [
            'date_correction' => $date,
            'id_post' => $id_topic,
            'url_correction' => $correction
        ];
        $sql = "UPDATE " . static::$table . " SET date_correction=:date_correction, url_correction=:url_correction WHERE id_post = :id_post";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
    }

    /**
     * @return string
     */
    public function getIdName()
    {
        return $this->_idName;
    }
}