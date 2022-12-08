<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";
	
	//Test Connexion User.
	Demmarage_Session();
	$connecter=Session_User();
	if(! $connecter)header('Location: Connexion.php');
	
	//Recuperation Id User.
	$id_user_cryptee=Get_Session_User();
	
	//Connexion Base.
	$base=Connexion();

	//Message.
	$message="";
	
	//Test Photo
	if(isset($_FILES["post_photo_profil"]))
	{	
		$nom=basename($_FILES["post_photo_profil"]["name"]);
		$taille=basename($_FILES["post_photo_profil"]["size"]);
		$extention=pathinfo($nom,PATHINFO_EXTENSION);
		$chemin="../DATA/USER/".$id_user_cryptee."/Photo_Profil.".$extention;
		
		if(move_uploaded_file($_FILES["post_photo_profil"]["tmp_name"],$chemin))
		{
			$requette="UPDATE renseignement SET Liens_Photo='$chemin' WHERE Id_User='$id_user_cryptee'";
			$resultat=Requette($base,$requette);
		} 
		else $message="Photo non telecharger";
	}
		
	//Test Nom
	$post_nom="";
	if(isset($_POST['post_nom']))
	{
		$post_nom=Securiter($_POST['post_nom']);
		if(!Test_Login($post_nom))
		{
			$post_nom="";
			$message="Le Nom est pas Bon";
		}
	}
	
	//Test Prenom
	$post_prenom="";
	if(isset($_POST['post_prenom']))
	{
		$post_prenom=Securiter($_POST['post_prenom']);
		if(!Test_Login($post_prenom))
		{
			$post_prenom="";
			$message="Le Prenom est pas Bon";
		}
	}
	
	//Test Age.
	$post_age="";
	if(isset($_POST['post_age']))
	{
		$post_age=Securiter($_POST['post_age']);
		if(!Test_Age($post_age))
		{
			$post_age="";
			$message="L'Age est pas Bon";
		}
	}
	
	//Test Telephone.
	$post_telephone="";
	if(isset($_POST['post_telephone']))
	{
		$post_telephone=Securiter($_POST['post_telephone']);
		if(!Test_Telephone($post_telephone))
		{
			$post_telephone="";
			$message="Le Telephone est pas Bon";
		}
	}
	
	//Test Email.
	$post_email="";
	if(isset($_POST['post_email']))
	{
		$post_email=Securiter($_POST['post_email']);
		if(!Test_Email($post_email))
		{
			$post_email="";
			$message="Le EMail est pas Bon";
		}
	}
	
	//Test Twitter.
	$post_twitter="";
	if(isset($_POST['post_twitter']))
	{
		$post_twitter=Securiter($_POST['post_twitter']);
		if(!Test_Login($post_twitter))
		{
			$post_twitter="";
			$message="Le Twitter est pas Bon";
		} else
			$post_twitter="";
	}
	
	//Requette Renseignement.
	if($post_nom!=""&&$post_prenom!=""&&$post_age!=""&&$post_telephone!=""&&$post_email!="")
	{
		$requette="UPDATE renseignement SET Nom='$post_nom',Prenom='$post_prenom',Age='$post_age',Telephone='$post_telephone',EMail='$post_email',Twitter='$post_twitter' WHERE id_user='$id_user_cryptee'";
		$resultat=Requette($base,$requette);
		
		if($resultat)
		{
			Deconnexion($base);
			header('Location: Profil.php');
		}
	}
	
	// Donnee User.
	$requette="select * from Renseignement where id_user='$id_user_cryptee'";	
	$resultat=Requette($base,$requette);
	$resultat=Traitement($resultat);
	Deconnexion($base);
	
	$liens_Photo=$resultat[2];
	$nom=$resultat[3];
	$prenom=$resultat[4];
	$age=$resultat[5];
	$telephone=$resultat[6];
	$eMail=$resultat[7];
	$twitter=$resultat[8];
 
	if($liens_Photo=="")$liens_Photo="../DATA/SITE/Image/Photo_Profile.png";
	
	//--------------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Renseignement </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Renseignement.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	// Navigation
	echo "<div class='navigation_site'>";
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
		
	// Titre
	echo "<div class='titre_site'> My Social Network </div>";
		
	// Formulaire Renseignement
	echo "<form action='Renseignement.php' method='post' enctype='multipart/form-data'>";
	echo "<div class='cadre_renseignement'> ";
	echo "<div class='cadre_message'>".$message."</div>";
	echo "<div class='cadre_post_photo'>  ";
	echo "<br><img src='".$liens_Photo."' class='taille_post_photo'/>";
	echo "<br><input name='post_photo_profil' type='file' />";
	echo "</div>";
	echo "<div class='cadre_formulaire_renseignement'> ";
	echo "<br><input class='formulaire_renseignement' name='post_nom' type='text' placeholder='Nom' value='".$nom."' />";
	echo "<br><input class='formulaire_renseignement' name='post_prenom' type='text' placeholder='Prenom' value='".$prenom."' />";
	echo "<br><input class='formulaire_renseignement' name='post_age' type='text' placeholder='Age' value='".$age."' />";
	echo "<br><input class='formulaire_renseignement' name='post_telephone' type='text' placeholder='Telephone' value='".$telephone."' />";
	echo "<br><input class='formulaire_renseignement' name='post_email' type='text' placeholder='Email' value='".$eMail."' />";
	echo "<br><input class='formulaire_renseignement' name='post_twitter' type='text' placeholder='Twitter' value='".$twitter."' />";
	echo "</div>";
	echo "<input class='bouton_renseignement' type='submit' value='Modification' />";
	echo "</div>";
	echo "</form>";
	
	echo "</body>";
	echo "</html>";
?>