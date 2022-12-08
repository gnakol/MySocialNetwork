<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";
	
	//Test Connexion User.	
	Demmarage_Session();
	$connecter=Session_User();
	if(!$connecter)header('Location: Connexion.php');
		
	//Message.
	$message="";
	
	//Recuperation Id User.
	$id_user_cryptee=Get_Session_User();
	
	//Test Titre Post.
	$titre_post="";
	if(isset($_POST['titre_post']))$titre_post=Securiter($_POST['titre_post']);
	
	//Test Commentaire Post.
	$commentaire_post="";
	if(isset($_POST['commentaire_post']))$commentaire_post=Securiter($_POST['commentaire_post']);
	
	//Test Partage Post.
	$partage_post="";	
	if(isset($_POST['partage']))$partage_post=Securiter($_POST['partage']);
	
	//Creation Photo.
	if($titre_post!=""&&$commentaire_post!=""&&isset($_FILES["photo_post"]))
	{	
		$nom=basename($_FILES["photo_post"]["name"]);
		$taille=basename($_FILES["photo_post"]["size"]);
		$extention=pathinfo($nom,PATHINFO_EXTENSION);
		
		$indice=1;
		$chemin="../DATA/USER/".$id_user_cryptee."/Photo_Post_".$indice.".".$extention ;
		
		while(file_exists($chemin))
		{
			$indice++;
			$chemin="../DATA/USER/".$id_user_cryptee."/Photo_Post_".$indice.".".$extention;
		}
		
		if(move_uploaded_file($_FILES["photo_post"]["tmp_name"],$chemin)) 
		{
			$base=Connexion();
			$requette="insert into Post values(null,'$id_user_cryptee','$titre_post','$chemin','$commentaire_post','$partage_post',0 );" ;
			$resultat=mysqli_query($base,$requette);
			Deconnexion($base);
						
			if($resultat)header('Location: Profil.php');
		} 
		else $message="Erreur Formulaire Photo" ;
	}
	else $message="Les Formulaires sont Vide" ;
	
	//---------------------------------------------------------------------- 

	//HTML.
	echo "<!DOCTYPE html>" ;
	echo "<head>" ;
	echo "<title> Poste Photo </title>" ;
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />" ;
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />" ;
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />" ;
	echo "<link rel='stylesheet' media='screen' href='../CSS/Post.css' type='text/css' />" ;
	echo "</head>" ;
	echo "<body>" ;
	
	// Navigation.
	echo "<div class='navigation_site'>" ;
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>" ;
	echo "</div>" ;
	
	// Titre.
	echo "<div class='titre_site'> My Social Network </div>" ;
		
	// Post.
	echo "<form action='Post.php' method='post' enctype='multipart/form-data'>" ;
	echo "<div class='cadre_poste_photo'>" ;
	echo "<div class='cadre_message'>".$message."</div>" ;
	echo "<div class='cadre_formulaire_poste_photo'>" ;
	echo "<br><input class='formulaire_poste_photo' name='titre_post' type='text' placeholder='Titre Poste'/>" ;
	echo "</div>" ;
	echo "<div class='cadre_post_photo'>" ;
	echo "<br><input name='photo_post' type='file'' />" ;
	echo "</div>" ;
	echo "<div class='cadre_formulaire_poste_photo'>" ;
	echo "<br><input class='formulaire_poste_photo' name='commentaire_post' type='text' placeholder='Commentaire'/>" ;
	echo "<br><select class='formulaire_poste_photo' name='partage'><option value='public' selected> Public </option><option value='amies'> Amies </option><option value='famille'> Famille </option><option value='priver'> Priver </option></select>" ;
	echo "</div>" ;
	echo "<input class='bouton_poste_photo' type='submit' value='Poster' />" ;
	echo "</div>" ;
	echo "</form>" ;
	
	echo "</body>" ;
	echo "</html>" ;
	
?>