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

		/*
		Affichage du  temps écoulé en fonction de la date du post. ($date_post en format sql classique 2017-02-08 06:07:09)
		*/
		public static function display_date($date_post)
		{
            $data1 = $date_post;//On récupère la date 
            list($date,$time) = explode(" ",$data1);//On la sépare en 2

            //On place dans les bonnes variables chaque attributs
            list($annee, $mois, $jour) = explode("-", $date);
            list($heure, $minute, $seconde) = explode(":", $time);

            date_default_timezone_set('CET'); //Changement du fusiau horaire
            $timestamp = mktime($heure, $minute, $seconde, $mois, $jour, $annee);
            $time = time() - $timestamp;

            $seconde = floor($time);
            $minute = floor($seconde/60);
            $heure = floor($minute/60);
            $jour = floor($heure/24);
            $mois = floor($jour/31);
            $annee = floor($jour/365.25);

            //Affiche une phrase différente selon la date du post (gére l'orthographe)
            if ($seconde < 59){
            	if ($seconde == 1) echo "Il y a ".$seconde." seconde";
            	else echo "Il y a ".$seconde." secondes";
            }elseif ($minute < 59){
            	if ($minute == 1) echo "Il y a ".$minute." minute";
            	else echo "Il y a ".$minute." minutes";
            }elseif ($heure < 23) {
            	if ($heure == 1) echo "Il y a ".$heure." heure";
            	else echo "Il y a ".$heure." heures";
            }elseif ($jour < 30) {
            	if ($jour == 1) echo "Il y a ".$jour." jour";
            	else echo "Il y a ".$jour." jours";
            }elseif ($mois < 12) {
            	if ($mois == 1) echo "Il y a ".$mois." mois";
            	else echo "Il y a ".$mois." mois";
            }else{
            	if ($annee == 1) echo "Il y a ".$annee." an";
            	else echo "Il y a ".$annee." ans";
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
        public function display_blog_filtres($id_class,$id_subject,$cas)
        {
        	$nul = 0;
        	if ($cas == 'subject')
        	{
        		if ($id_subject == '') 
        		{
        			$result = $this->display_blog_live();
        			$nul = 1;
        		}
        	}
        	if ($cas == 'class') 
        	{
        		if ($id_class == '') 
        		{
        			$result = $this->display_blog_live();
        			$nul = 1;
        		}
        	}
        	if ($nul != 1)
        	{
        		$sql = "SELECT * FROM POSTS 
        		INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        		INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        		INNER JOIN USERS on USERS.id_user = POSTS.id_user
        		WHERE type_post = 0 ";

        		if ($id_class != '')
        		{	
        			$a = explode(",", $id_class);
        			foreach($a as $id => $value)
        			{
        				if ($id == 0){
        					$sql = $sql . "AND ( POSTS.id_class = '$value' ";
        				}
        				else{
        					$sql = $sql . "OR POSTS.id_class = '$value' ";
        				}
        			}
        			$sql = $sql . " ) ";
        		}

        		if ($id_subject != '')
        		{
        			$b = explode(",", $id_subject);
        			foreach($b as $id => $value2)
        			{
        				if ($id == 0){
        					$sql = $sql . "AND ( POSTS.id_subject = '$value2' ";
        				}
        				else{
        					$sql = $sql . "OR POSTS.id_subject = '$value2' ";
        				}
        			}
        			$sql = $sql . " ) ";	
        		}

        		$sql = $sql . "ORDER BY date_post DESC";
				// die($sql);
        		$result = $this->executeReq($sql);
        	}

        	return $result;
        }
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
        	return $result;
        }

        public function display_blog_id($id_blog)
        {
        	$sql = "SELECT * FROM POSTS 
        	INNER JOIN PROMS on PROMS.id_class = POSTS.id_class
        	INNER JOIN SUBJECTS on SUBJECTS.id_subject = POSTS.id_subject
        	INNER JOIN USERS on USERS.id_user = POSTS.id_user
        	WHERE POSTS.id_post = ?";
        	$result = $this->executeReq($sql, [$id_blog], 1);
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
        	WHERE type_post = 0 AND name_class = :class
        	ORDER BY date_post DESC";
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
        	WHERE type_post = 0 AND date_post = :date_post
        	ORDER BY date_post DESC";
        	$result = $this->executeReq($sql, $a);
        	return $result;
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