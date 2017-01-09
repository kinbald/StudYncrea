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
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 
				ORDER BY date_post DESC";
		$result = $this->executeReq($sql);
//		$req = $db->prepare($sql);
//		$req->execute();
		return $result;
	}
	public function display_blog_all()
	{
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0";
//		$req = $db->prepare($sql);
//		$req->execute();
        $result = $this->executeReq($sql);
		return $result;
	}
	/*Entrée : type: chaine de caractère : Nom de la promo*/
	public function display_blog_class($class)
	{
		$a = [
		'class'     => $class,
		];
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				INNER JOIN USERS on USERS.id_user = POSTS.id_user
				WHERE type_post = 0 AND name_class = :class";
//		$req = $db->prepare($sql);
//		$req->execute($a);
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
		$sql = "SELECT * FROM POSTS 
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
		$sql = "SELECT * FROM POSTS 
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
		$sql = "SELECT * FROM POSTS
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
		$sql = "SELECT * FROM POSTS 
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
        
        $sql = "INSERT INTO POSTS (id_post, title,description,date_post,type_post,id_subject,id_class,id_user,id_chapter,id_user_teacher,url_file) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
//        $req =$db->prepare($sql);
//        $req->bindParam(1,$title);
//        $req->bindParam(2,$description);
//        $req->bindParam(3,$date_post);
//        $req->bindValue(4,$type_post);
//        $req->bindValue(5,$id_subject);
//        $req->bindValue(6,$id_class);
//        $req->bindValue(7,$id_user);
//        $req->bindValue(8,$id_chapter);
//        $req->bindValue(9,$id_prof);
//        $req->bindParam(10,$nothing);
//        $success = $req->execute();
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
		$sql = "UPDATE POSTS SET url_file = :url WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_title($id_blog,$new_title)
    {
		$a = [
		'title_blog' => $new_title,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET title = :title_blog WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_description($id_blog,$new_description)
	{

		$a = [
		'description_blog' => $new_description,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET description = :description_blog WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_date_correction($id_blog,$date_correction)
	{

		$a = [
		'date_blog' => $date_correction,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET date_correction = :date_blog WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_subject($id_blog,$id_subject)
	{

		$a = [
		'id_subject' => $id_subject,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET id_subject = :id_subject WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function  update_chapter($id_blog,$id_chapter)
    {
		$a = [
		'chapter' => $id_chapter,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET id_chapter = :chapter WHERE id_post = :id_blog";
        $result = $this->executeReq($sql, $a, 0);
        return $result;
	}
	public function update_prof($id_blog,$id_user_prof)
	{
		$a = [
		'id_prof' => $id_user_prof,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET id_user_USERS = :id_prof WHERE id_post = :id_blog";
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