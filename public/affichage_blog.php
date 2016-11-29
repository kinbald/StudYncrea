<?php 
	include "../App/database.php";
    include "../App/Autoload.php";
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Blog</title>
    </head>
    <body>
	<?php
	//Simulation d'affichage des blogs : 
	$Blog = new Blog;

	echo "<br><br>Tout les blogs:<br>";
	$BlogALL = $Blog->display_blog_all();
	foreach ($BlogALL as $blog) {
		echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
	}

	echo "<br><br>Par classe:<br>";
	$BlogALL = $Blog->display_blog_class("CIR2");	
	foreach ($BlogALL as $blog) {
		echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
	}

	echo "<br><br>Par Date du blog:<br>";
	$BlogALL = $Blog->display_blog_date_post("1997-06-03 14:30:00");	
	foreach ($BlogALL as $blog) {
		echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
	}

	echo "<br><br>Par titre:<br>";
	$BlogALL = $Blog->display_blog_title("Comment trouver ceci ?");//Peutetre que les espaces dans le titre pose problème
	//Si c'est le cas, il faut les remplacer par des underscores 
	foreach ($BlogALL as $blog) {
		echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
	}

	echo "<br><br>Par matière:<br>";
	$BlogALL = $Blog->display_blog_subject("Math");	
	foreach ($BlogALL as $blog) {
		echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
	}

	//Test INSERT:
	/*
	$description = "Et prima post Osdroenam quam, ut dictum est, ab hac descriptione discrevimus,
					Commagena, nunc Euphratensis, clementer adsurgit, Hierapoli, 
					vetere Nino et Samosata civitatibus amplis inlustris.";

	$Blog->write_blog("Test INSERT",$description,"2016-11-29 10:30:00",2,1,1,1,1);
	*/	
	
	//Test UPDATE:
	//$Blog->update_url_file(19,"http/test");
	//$Blog->update_title(19,"Test UPDATE");
	//$Blog->update_description(19,"Descritpion Update");
	//$Blog->update_date_correction(19,"1997-06-03 00:00:00");
	//$Blog->update_subject(19,1);
	?>
    </body>
</html>