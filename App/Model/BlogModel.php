<?php

/*
	@author : Herrenschmidt Félix
*/
namespace App\Model;

use Core\Model\Model;

class BlogModel extends Model
{
    public static $table = 'POSTS';
    private $_idName = 'id_post';


	/*Affiche en premier le plus récent*/
	public function display_blog_live()
	{
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 
				ORDER BY date_post DESC";
		$result = $this->executeReq($sql);
		return $result;
	}
	public function display_blog_all()
	{
		$sql = "SELECT * FROM " . static::$table ." 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0";
        $result = $this->executeReq($sql);
		return $result;
	}
	/*Entrée : type: chaine de caractère : Nom de la promo*/
	public function display_blog_class($class)
	{
		$param = [
		'class'     => $class,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND name_class = :class";
        $result = $this->executeReq($sql, $param);
		return $result;
	}
		/*Entrée : type: numérique : id de la classe 
		  Descriptif : (Variante qui affiche la classe demandé et celles inférieures, par rapport à l'id.
		  SSI on a classé les classes par ordre croissant au niveau de l'id.*/
	public function display_blog_classbyid($id_class)
	{
		$param = [
		'id'     => $id_class,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND PROMS.id_class <= :id ORDER BY PROMS.id_class DESC";
        $result = $this->executeReq($sql, $param);
		return $result;
	}
	/*Entrée: type: chaine de caractère: Titre du blog*/
	public function display_blog_title($title)
	{
		$param = [
		'title'     => $title,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND title = :title";
        $result = $this->executeReq($sql, $param);
        return $result;
	}
	/*Entrée: type: chaine de caractère sous forme de type date : Date du post*/
	public function display_blog_date_post($date_post)
	{
		$param = [
		'date_post'     => $date_post,
		];
		$sql = "SELECT * FROM " . static::$table ." 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject 
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND date_post = :date_post";
        $result = $this->executeReq($sql, $param);
        return $result;
	}
	/*Entrée: type: chaine de caractère: nom de la matière*/
	public function display_blog_subject($subject_name)
	{
		$param = [
		'subject'     => $subject_name,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND name_subject = :subject";
        $result = $this->executeReq($sql, $param);
        return $result;
	}

    /**
     * Fonction qui permet d'ajouter un post ou une annale dans la base de données
     * @param $id_user int
     * @param $id_class int
     * @param $id_chapter int
     * @param $id_subject int
     * @param $id_teacher int
     * @param $title string
     * @param $data string
     * @param $url_picture string
     * @param $type_post int
     */
    public function add_post($id_user, $id_class, $id_chapter, $id_subject, $id_teacher, $title, $data, $url_picture, $type_post)
    {
        $id_post = $this->lastInsertId($this->getIdName());
        $id_post = $id_post === FALSE ? 1 : $id_post+1;

        $date = date('d.m.y h:i');
        $sql = "INSERT INTO " . static::$table . "(id_user, id_class, id_chapter, id_subject, id_user_teacher, title, description, id_post, url_file, type_post, date_post) VALUES (:id_user, :id_class, :id_chapter, :id_subject, :id_teacher, :title, :description, :id_post, :url_picture, :type_post, :date_post)";
        $param = [
            ':id_user' => $id_user,
            ':id_class' => $id_class,
            ':date_post' => $date,
            ':id_chapter' => $id_chapter,
            ':url_picture' => $url_picture,
            ':id_subject' => $id_subject,
            ':id_teacher' => $id_teacher,
            ':title' => $title,
            ':description' => $data,
            ':id_post' => $id_post,
            ':type_post' => $type_post
        ];
        $this->executeReq($sql,$param, 0);
    }

    /**
     * Fonction qui permet de mettre à jour un post ou une annale dans la base de données
     * @param $id_post int
     * @param $title string
     * @param $description string
     * @param $url_file string
     * @param $type_post int
     * @param $id_subject int
     * @param $id_class int
     * @param $id_chapter int
     * @param $id_user_teacher int
     * @return \PDOStatement
     */
    public function update($id_post, $title, $description, $url_file, $type_post, $id_subject, $id_class, $id_chapter, $id_user_teacher)
    {
        $date_post = date('Y-m-d G:i:s');
        $param = [
            ':id_post' => $id_post,
            ':title' => $title,
            ':description' => $description,
            ':date_post' => $date_post,
            ':url_file' => $url_file,
            ':type_post' => $type_post,
            ':id_subject' => $id_subject,
            ':id_class' => $id_class,
            ':id_chapter' => $id_chapter,
            ':id_user_teacher' => $id_user_teacher,
        ];
        $sql = "UPDATE " . static::$table . " SET title = :title, description = :description, date_post = :date_post, url_file = :url_file,
        type_post = :type_post, id_subject = :id_subject, id_class =:id_class, id_chapter = :id_chapter,
        id_user_teacher = :id_user_teacher
        WHERE id_post = :id_post";
        $result = $this->executeReq($sql, $param, 0);
        return $result;
    }

    /**
     * Fonction qui permet de mettre à jour la correction d'une annale
     * @param $id_post int
     * @param $url_correction string
     * @return \PDOStatement
     */
    public function  updateCorrection($id_post, $url_correction)
    {
        $date_correction = date('Y-m-d G:i:s');
        $param = [
            ':id_post' => $id_post,
            ':date_correction' => $date_correction,
            ':url_correction' => $url_correction,
        ];
        $sql = "UPDATE " . static::$table . " SET date_correction = :date_correction, url_correction = :url_correction 
        WHERE id_post = :id_post";
        $result = $this->executeReq($sql, $param, 0);
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