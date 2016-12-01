<?php 
/*
	@author : Herrenschmidt Félix
*/
class Blog
{
	public function display_blog_all()
	{
		global $db;
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				WHERE type_post = 0";
		$req = $db->prepare($sql);
		$req->execute();
		return $req->fetchAll();
	}
	/*Entrée : type: chaine de caractère : Nom de la promo*/
	public function display_blog_class($class)
	{
		global $db;
		$a = [
		'class'     => $class,
		];
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				WHERE type_post = 0 AND name_class = :class";
		$req = $db->prepare($sql);
		$req->execute($a);
		return $req->fetchAll();
	}
		/*Entrée : type: numérique : id de la classe 
		  Descriptif : (Variante qui affiche la classe demandé et celles inférieures, par rapport à l'id.
		  SSI on a classé les classes par ordre croissant au niveau de l'id.*/
	public function display_blog_classbyid($id_class)
	{
		global $db;
		$a = [
		'id'     => $id_class,
		];
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				WHERE type_post = 0 AND PROMS.id_class <= :id ORDER BY PROMS.id_class DESC";
		$req = $db->prepare($sql);
		$req->execute($a);
		return $req->fetchAll();
	}
	/*Entrée: type: chaine de caractère: Titre du blog*/
	public function display_blog_title($title)
	{
		global $db;
		$a = [
		'title'     => $title,
		];
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				WHERE type_post = 0 AND title = :title";
		$req = $db->prepare($sql);
		$req->execute($a);
		return $req->fetchAll();
	}
	/*Entrée: type: chaine de caractère sous forme de type date : Date du post*/
	public function display_blog_date_post($date_post)
	{
		global $db;
		$a = [
		'date_post'     => $date_post,
		];
		$sql = "SELECT * FROM POSTS
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject 
				WHERE type_post = 0 AND date_post = :date_post";
		$req = $db->prepare($sql);
		$req->execute($a);
		return $req->fetchAll();
	}
	/*Entrée: type: chaine de caractère: nom de la matière*/
	public function display_blog_subject($subject_name)
	{
		global $db;
		$a = [
		'subject'     => $subject_name,
		];
		$sql = "SELECT * FROM POSTS 
				INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
				INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
				WHERE type_post = 0 AND name_subject = :subject";
		$req = $db->prepare($sql);
		$req->execute($a);
		return $req->fetchAll();
	}
	/*Il faut bien penser à respecter tout les type des variables*/
	public function write_blog($title,$description,$date_post,$id_subject,$id_class,$id_user,$id_chapter,$id_prof)
	{
        global $db;
        $type_post = 0;
        $nothing = '';
        
        $sql = "INSERT INTO POSTS (title,description,date_post,type_post,id_subject,id_class,id_user,id_chapter,id_user_USERS,url_file) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $req =$db->prepare($sql);
        $req->bindParam(1,$title);
        $req->bindParam(2,$description);
        $req->bindParam(3,$date_post);    
        $req->bindValue(4,$type_post);
        $req->bindValue(5,$id_subject);
        $req->bindValue(6,$id_class);
        $req->bindValue(7,$id_user);
        $req->bindValue(8,$id_chapter);
        $req->bindValue(9,$id_prof);
        $req->bindParam(10,$nothing);
        $success = $req->execute();
		if ($success === FALSE) {
		die("<p>ERREUR : L'ajout a retourné une erreur.</p>");
		} else {
		echo("<p>INSERT OK</p>");
		}
	}
	/*Update pour la modification de chaques éléments du blog*/
	public function update_url_file($id_blog,$new_url_file)
	{	
		global $db;
		$a = [
		'url'     => $new_url_file,
		'id_blog' => $id_blog,
		];
		$sql = "UPDATE POSTS SET url_file = :url WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a);      
	}
	public function update_title($id_blog,$new_title)
	{
		global $db;
		$a = [
		'title_blog' => $new_title,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET title = :title_blog WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a);  
	}
	public function update_description($id_blog,$new_description)
	{
		global $db;
		$a = [
		'description_blog' => $new_description,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET description = :description_blog WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a);  	
	}
	public function update_date_correction($id_blog,$date_correction)
	{
		global $db;
		$a = [
		'date_blog' => $date_correction,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET date_correction = :date_blog WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a);  	
	}
	public function update_subject($id_blog,$id_subject)
	{
		global $db;
		$a = [
		'id_subject' => $id_subject,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET id_subject = :id_subject WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a); 
	}
	public function  update_chapter($id_blog,$id_chapter)
	{
		global $db;
		$a = [
		'chapter' => $id_chapter,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET id_chapter = :chapter WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a); 
	}
	public function update_prof($id_blog,$id_user_prof)
	{
		global $db;
		$a = [
		'id_prof' => $id_user_prof,
		'id_blog'    => $id_blog,
		];
		$sql = "UPDATE POSTS SET id_user_USERS = :id_prof WHERE id_post = :id_blog";
		$req = $db->prepare($sql);
		$req->execute($a); 
	}
}