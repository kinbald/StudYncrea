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
		$a = [
		'class'     => $class,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND name_class = :class";
        $result = $this->executeReq($sql, $a);
		return $result;
	}
		/*Entrée : type: numérique : id de la classe 
		  Descriptif : (Variante qui affiche la classe demandé et celles inférieures, par rapport à l'id.
		  SSI on a classé les classes par ordre croissant au niveau de l'id.*/
	public function display_blog_classbyid($id_class)
	{

		$a = [
		'id'     => $id_class,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND PROMS.id_class <= :id ORDER BY PROMS.id_class DESC";
        $result = $this->executeReq($sql, $a);
		return $result;
	}
	/*Entrée: type: chaine de caractère: Titre du blog*/
	public function display_blog_title($title)
	{

		$a = [
		'title'     => $title,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND title = :title";
        $result = $this->executeReq($sql, $a);
        return $result;
	}
	/*Entrée: type: chaine de caractère sous forme de type date : Date du post*/
	public function display_blog_date_post($date_post)
	{

		$a = [
		'date_post'     => $date_post,
		];
		$sql = "SELECT * FROM " . static::$table ." 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject 
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND date_post = :date_post";
        $result = $this->executeReq($sql, $a);
        return $result;
	}
	/*Entrée: type: chaine de caractère: nom de la matière*/
	public function display_blog_subject($subject_name)
	{

		$a = [
		'subject'     => $subject_name,
		];
		$sql = "SELECT * FROM " . static::$table ."  
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND name_subject = :subject";
        $result = $this->executeReq($sql, $a);
        return $result;
	}
	/*Il faut bien penser à respecter tout les type des variables*/
	public function write_blog($title,$description,$date_post,$id_subject,$id_class,$id_user,$id_chapter,$id_prof)
	{

        $type_post = 0;
        $nothing = '';

        $id = $this->lastInsertId($this->getIdName());
        $id = $id === FALSE ? 1 : $id+1;

        $a =
            [
                $id,
                $title,
                $description,
                $date_post,
                $type_post,
                $id_subject,
                $id_class,
                $id_user,
                $id_chapter,
                $id_prof,
                $nothing
            ];
        
        $sql = "INSERT INTO POSTS (id_post, title,description,date_post,type_post,id_subject,id_class,id_user,id_chapter,id_user_teacher,url_file) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?)
                ";
        $success = $this->executeReq($sql, $a, 0);
		if ($success === FALSE) {
		die("<p>ERREUR : L'ajout a retourné une erreur.</p>");
		} else {
		echo("<p>INSERT OK</p>");
		}
	}
	/*Update pour la modification de chaques éléments du blog*/
	public function update_url_file($id_blog,$new_url_file)
	{	

		$a = [
		'url'     => $new_url_file,
		'id_blog' => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET url_file = :url WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_title($id_blog,$new_title)
    {
		$a = [
		'title_blog' => $new_title,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET title = :title_blog WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_description($id_blog,$new_description)
	{

		$a = [
		'description_blog' => $new_description,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET description = :description_blog WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_date_correction($id_blog,$date_correction)
	{

		$a = [
		'date_blog' => $date_correction,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET date_correction = :date_blog WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_subject($id_blog,$id_subject)
	{

		$a = [
		'id_subject' => $id_subject,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET id_subject = :id_subject WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function  update_chapter($id_blog,$id_chapter)
    {
		$a = [
		'chapter' => $id_chapter,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET id_chapter = :chapter WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_prof($id_blog,$id_user_prof)
	{
		$a = [
		'id_prof' => $id_user_prof,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE " . static::$table ."  SET id_user_USERS = :id_prof WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}

    public function add_post($id_user, $id_class, $id_chapter, $id_subject, $id_teacher, $title, $data, $id_post, $url_picture, $type_post)
    {
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
     * @return string
     */
    public function getIdName()
    {
        return $this->_idName;
    }
}