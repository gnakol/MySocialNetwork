<?php

	//Include.
	include"Fonction/Base.php";
	include"Fonction/Session.php";
	include"Fonction/Securiter.php";
	
	// Test Connexion User.	
	Demmarage_Session();
	$connecter=Session_User();
	
	// Recuperation Id User.
	$id_cryptee_user=Get_Session_User();
	
	//Test Id Menbre.
	$id_cryptee_menbre="";
	if(isset($_GET['menbre']))$id_cryptee_menbre=Securiter($_GET['menbre']);
	
	//Test Id Post.
	$id_cryptee_post="";
	if(isset($_GET['post']))$id_cryptee_post=Securiter($_GET['post']);
	
	//Test Option.
	$num_option=0 ; 
	if(isset($_GET['option']))$num_option=Securiter($_GET['option']);
	
	//Test Commentaire.
	$commentaire_post=""; 
	if(isset($_POST['commentaire']))$commentaire_post=Securiter($_POST['commentaire']);
	
	//Redirection.
	if($id_cryptee_menbre=="")header('Location: Menbre.php');
	
	//Liens.
	$amies="";
	
	//Connexion Base;
	$base=Connexion();
		
	//Test Deja Amies.
	if($connecter)
	{
		$requette="select * from demmande_amies where User='$id_cryptee_user' and Amies='$id_cryptee_menbre'";
		$resultat_requette=Requette($base, $requette);
		$donnee_resultat=Traitement($resultat_requette);
		if($donnee_resultat)$amies="public";
		
		$requette="select * from amies where User='$id_cryptee_user' and Amies='$id_cryptee_menbre'";
		$resultat_requette=Requette($base, $requette);
		$donnee_resultat=Traitement($resultat_requette);
		if($donnee_resultat)$amies=$donnee_resultat[3];
	}
	
	//Test Demmande Amies.
	if($connecter&&$amies==""&&$num_option==1&&$id_cryptee_user!=""&&$id_cryptee_menbre!="")
	{
		$requette="INSERT INTO demmande_amies VALUES(null,'$id_cryptee_user','$id_cryptee_menbre')";
		$resultat_requette=Requette($base, $requette);
				
		if($resultat_requette)$amies="public";
	}
	
	//Test Likee.
	if($connecter&&$num_option==2&&$id_cryptee_user!=""&&$id_cryptee_post!="")
	{
		$requette="select * from likee where id_post='$id_cryptee_post' and id_user='$id_cryptee_user'";
		$resultat_requette=Requette($base,$requette);
		$donnee_requette=Traitement($resultat_requette);
				
		if(! $donnee_requette)
		{
			$requette="UPDATE post SET Nb_Likee=Nb_Likee+1 WHERE sha1(id_post)='$id_cryptee_post'";
			$resultat_requette=Requette($base,$requette);
			
			$requette="insert into Likee values(null,'$id_cryptee_post','$id_cryptee_user')";
			$resultat_requette=Requette($base,$requette);
		}	
	}
	
	//Test Commentaire.
	if($connecter&&$num_option==3&&$id_cryptee_post!=""&&$id_cryptee_user!=""&&$commentaire_post!="")
	{		
		$requette="insert into Commentaire values(null,'$id_cryptee_post','$id_cryptee_user','$commentaire_post')";
		$resultat_requette=Requette($base, $requette);
	}
	
	//Donnee Menbre.
	$requette="select * from Renseignement where id_user='$id_cryptee_menbre'";
	$donnee_menbre=Requette($base, $requette);
	$tab_donnee_menbre=Traitement($donnee_menbre);
	
	$liens_Photo=$tab_donnee_menbre[2];
	$nom=$tab_donnee_menbre[3];
	$prenom=$tab_donnee_menbre[4];
	$age=$tab_donnee_menbre[5];
	$telephone=$tab_donnee_menbre[6];
	$eMail=$tab_donnee_menbre[7];
	$twitter=$tab_donnee_menbre[8];
 
	if($liens_Photo=="")$liens_Photo="../DATA/SITE/Image/Photo_Profile.png";
	if($nom=="")$nom="Non Renseigner";
	if($prenom=="")$prenom="Non Renseigner";
	if($age=="")$age="Non Renseigner";
	if($telephone=="")$telephone="Non Renseigner";
	if($eMail=="")$eMail="Non Renseigner";
	if($twitter=="")$twitter="Non Renseigner";
		
	//Liste Post.
	$requette="select * from post where id_user='$id_cryptee_menbre' order by Id_Post desc";
	$liste_post=Requette($base, $requette);
		
	//--------------------------------------------------------------------------

	//HTML.
	echo"<!DOCTYPE html>";
	echo"<head>";
	echo"<title> Profil Menbre </title>";
	echo"<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo"<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo"<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo"<link rel='stylesheet' media='screen' href='../CSS/ProfilMenbre.css' type='text/css' />";
	echo"</head>";
	echo"<body>";
	
	//Navigation.
	echo"<div class='navigation_site'>";
	echo"<a href='Menbre.php'><div class='bouton_navigation'> Menbre </div></a>";
	if(! $connecter)echo"<a href='Inscription.php'><div class='bouton_navigation'> Inscription </div></a>";
	if(! $connecter)echo"<a href='Connexion.php'><div class='bouton_navigation'> Connexion </div></a>";
	if($connecter)echo"<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo"</div>";
	
	// Titre.
	echo"<div class='titre_site'> My Social Network </div>";
		
	//Renseignement Profil.
	echo"<div class='cadre_entete_menbre'>";
	echo"<div class='donnee_profile_menbre'>";
	echo"<div class=''> nom :".$nom."</div> <br>";
	echo"<div class=''> prenom :".$prenom."</div> <br>";
	echo"<div class=''> age :".$age."</div>";
	echo"</div>";
	echo"<img src='".$liens_Photo."' class='photo_profile_menbre'/>";
	echo"<div class='donnee_profile_menbre'>";
	echo"<div class=''> Telephone :".$telephone."</div> <br>";
	echo"<div class=''> EMail :".$eMail."</div> <br>";
	echo"<div class=''> Twitter :".$twitter."</div>";
	echo"</div>";
	echo"</div>";
	
	//Test Place Bouton Demmande Amies.
	if($connecter&&$amies=="")
	{
		echo"<form action='ProfilMenbre.php?menbre=".$id_cryptee_menbre."&&option=1' method='post'>";
		echo"<div class='cadre_demmande_amies'>";
		echo"<input class='bouton_demmande_amies' type='submit' value='Etre Amies' />";
		echo"</div>";
		echo"</form>";
	}
	
	//Traitement Liste Post
	$donnee_post=Traitement($liste_post);
	if($donnee_post=="")echo"<div class='cadre_message'> Aucun Post </div>";
	else
	{
		//Liste Poste.
		echo"<div class='cadre_contenue'>";
		do
		{
			$id_post=sha1($donnee_post[0]);
			$id_menbre=$donnee_post[1];
			$titre=$donnee_post[2];
			$liens_Photo=$donnee_post[3];
			$commentaire=$donnee_post[4];
			$partage=$donnee_post[5];
			$nb_Like=$donnee_post[6];
					
			if($partage==$amies||$partage=="public")
			{
				echo"<div class='cadre_post'>";
				echo"<div class='cadre_titre_post'>";
				echo"<div class='titre_post'>".$titre."</div>";
				echo"</div>";
				echo"<div class='cadre_post_photo'>";
				echo"<img src='".$liens_Photo."' class='taille_post_photo'/>";
				echo"</div>";
				echo"<div class='cadre_post_commentaire'>";
				echo"<div class='post_commentaire'>".$commentaire."</div>";
			
				$requette="select * from Commentaire where id_post='$id_cryptee_post' order by Id_Post desc";
				$liste_commentaire=Requette($base, $requette);
				
				while($donnee_commentaire=Traitement($liste_commentaire))
				{
					$commentaire=$donnee_commentaire[3];
					echo"<div class='post_commentaire'>".$commentaire."</div>";
				}
				echo"</div><br>";
				
				if($connecter)
				{
					echo"<div class='cadre_like'>";
					echo"<form action='ProfilMenbre.php?menbre=".$id_menbre."&&post=".$id_post."&&option=2' method='post'>";
					echo"<input class='bouton_like' type='submit' value='Like' />";
					echo"<div class='nombre_like'>".$nb_Like." Like </div>";
					echo"</form>";
					echo"</div>";
					
					echo"<div class='cadre_ajoutee_commentaire'>";
					echo"<form action='ProfilMenbre.php?menbre=".$id_menbre."&&post=".$id_post."&&option=3' method='post'>";
					echo"<input class='formualire_ajoutee_commentaire' name='commentaire' type='text' value='' placeholder='Commentaire' />";
					echo"<input class='bouton_ajoutee_commentaire' type='submit' value='Ajouter' />";
					echo"</form>";
					echo"</div>";
				}
				
				echo"</div>";
			}
		}
		while($donnee_post=Traitement($liste_post));
		echo"</div>";
	}
	Deconnexion($base);
	
	echo"</body>";
	echo"</html>";
	
?>			