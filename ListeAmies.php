<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";

	//Test Connexion User.	
	Demmarage_Session();
	$connecter=Session_User();
	if(!$connecter)header('Location: Connexion.php');
		
	//Recuperation Id User.
	$id_user_cryptee=Get_Session_User();
	
	//Test Id Amies.
	$id_amies_cryptee="";
	if(isset($_GET['amies']))$id_amies_cryptee=Securiter($_GET['amies']);
	
	//Test Option.
	$option=0;
	if(isset($_GET['option']))$option=Securiter($_GET['option']);
	
	//----------------------------------------------------------------------
	
	//Connexion Base.
	$base=Connexion();
	
	//Test Mettre Amies Public.
	if($connecter&&$option==1&&$id_user_cryptee!=""&&$id_amies_cryptee!="")
	{
		$requette="UPDATE amies SET Liens='public' WHERE User='$id_amies_cryptee' and Amies='$id_user_cryptee'";
		$resultat_requette=Requette($base,$requette) ;
	}
	
	//Test Mettre Amies Amies.
	if($connecter&&$option==2&&$id_user_cryptee!=""&&$id_amies_cryptee!="")
	{
		$requette="UPDATE amies SET Liens='amies' WHERE User='$id_amies_cryptee' and Amies='$id_user_cryptee'";
		$resultat_requette=Requette($base,$requette) ;
	}
	
	//Test Mettre Amies Famille.
	if($connecter&&$option==3&&$id_user_cryptee!=""&&$id_amies_cryptee!="")
	{
		$requette="UPDATE amies SET Liens='famille' WHERE User='$id_amies_cryptee' and Amies='$id_user_cryptee'";
		$resultat_requette=Requette($base,$requette) ;
	}
	
	//Test Mettre Amies Priver.
	if($connecter&&$option==4&&$id_user_cryptee!=""&&$id_amies_cryptee!="")
	{
		$requette="UPDATE amies SET Liens='priver' WHERE User='$id_amies_cryptee' and Amies='$id_user_cryptee'";
		$resultat_requette=Requette($base,$requette) ;
	}
		
	//Test Retirer Amies.
	if($connecter&&$option==5&&$id_user_cryptee!=""&&$id_amies_cryptee!="")
	{
		$requette="DELETE FROM amies WHERE User='$id_user_cryptee' and Amies='$id_amies_cryptee'";
		$resultat_requette=Requette($base,$requette);
		
		$requette="DELETE FROM amies WHERE User='$id_amies_cryptee' and Amies='$id_user_cryptee'";
		$resultat_requette=Requette($base,$requette);
	}
	
	//Liste Amies.
	$requette="select Amies from Amies where user='$id_user_cryptee' order by Id_Amies desc";
	$liste_amies=Requette($base,$requette);

	//----------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Liste Amies </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/ListeAmies.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	// Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
	
	// Titre.
	echo "<div class='titre_site'> My Social Network : Liste Amies </div>";
	
	//Traitement Liste Menbre.
	$donnee_liste=Traitement($liste_amies);
	if($donnee_liste=="")echo "<div class='cadre_message'> Aucun Amies </div>" ;
	else
	{
		//Liste Amies.
		echo "<div class='cadre_des_amies'>";
		do
		{
			$id_cryptee_amies=$donnee_liste[0];
						
			$requette="select liens_Photo,nom from renseignement where id_user='$id_cryptee_amies'";
			$resultat_amies=Requette($base,$requette);
			$donnee_amies=Traitement($resultat_amies);
			
			$liens_Photo=$donnee_amies[0];
			$nom=$donnee_amies[1];
			
			if($liens_Photo=="")$liens_Photo="../DATA/SITE/Image/Photo_Profile.png";
			if($nom=="")$nom="Non Renseigner";
			
			echo "<div class='cadre_amies'>";
			echo "<div class='nom_amies'>".$nom."</div>";
			echo "<div class='photo_amies'>";
			echo "<img src='".$liens_Photo."' class='taille_photo_amies'/>";
			echo "</div>";
			echo "<form action='ProfilMenbre.php?menbre=".$id_cryptee_amies."' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Profil Amies' />";
			echo "</form>";
			echo "<form action='EnvoieMessage.php?amies=".$id_cryptee_amies."' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Envoyer un Message' />";
			echo "</form>";
			echo "<form action='ListeAmies.php?amies=".$id_cryptee_amies."&&option=1' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Mettre en Public' />";
			echo "</form>";
			echo "<form action='ListeAmies.php?amies=".$id_cryptee_amies."&&option=2' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Mettre en Amies' />";
			echo "</form>";
			echo "<form action='ListeAmies.php?amies=".$id_cryptee_amies."&&option=3' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Mettre en Famille' />";
			echo "</form>";
			echo "<form action='ListeAmies.php?amies=".$id_cryptee_amies."&&option=4' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Mettre en Privée' />";
			echo "</form>";
			echo "<form action='ListeAmies.php?amies=".$id_cryptee_amies."&&option=5' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Retirée cette Amies' />";
			echo "</form>";
			echo "</div>";
		}
		while($donnee_liste=Traitement($liste_amies));
		echo "</div>";
	}
	Deconnexion($base);
	
	echo "</body>";
	echo "</html>";
	
?> 