<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";

	//Test Connexion User.
	Demmarage_Session() ;
	$connecter = Session_User() ;
	
	//Redirection si non connecter
	if(!$connecter)header('Location: Connexion.php');
		
	//Recuperation Id User.
	$id_user_cryptee=Get_Session_User();
		
	//Test Id Menbre.
	$id_cryptee_menbre="";
	if(isset($_GET['menbre']))$id_cryptee_menbre=Securiter($_GET['menbre']);
	
	//Test Id Option.
	$option="";
	if( isset($_GET['option']))$option=Securiter($_GET['option']);
	
	
	//Connexion Base.
	$base = Connexion();
		
	//Acceptee Amies.
	if($connecter&&$option==1&&$id_user_cryptee!=""&&$id_cryptee_menbre!="")
	{
		$requette="DELETE FROM demmande_amies WHERE User='$id_cryptee_menbre' and Amies='$id_user_cryptee'";
		$liste_demmande=Requette($base,$requette);
	
		$requette="INSERT INTO amies VALUES(null,'$id_user_cryptee','$id_cryptee_menbre','public')";
		$liste_demmande = Requette( $base, $requette );
		
		$requette="INSERT INTO amies VALUES(null,'$id_cryptee_menbre','$id_user_cryptee','public')";
		$liste_demmande=Requette($base,$requette);
	}
	
	//Refuser Amies.
	if($connecter&&$option==2&&$id_user_cryptee!=""&&$id_cryptee_menbre!="")
	{
		$requette="DELETE FROM demmande_amies WHERE User='$id_cryptee_menbre' and Amies='$id_user_cryptee'";
		$liste_demmande=Requette($base,$requette);
	}
	
	//Liste Demmande Amies.
	$requette="select User from demmande_amies where Amies='$id_user_cryptee' order by Id_Demmande_Amies desc";
	$liste_demmande=Requette($base,$requette);
	
	//----------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Liste Demmande Amies </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/DemmandeAmies.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	//Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
	
	//Titre.
	echo "<div class='titre_site'> My Social Network : Liste Demmande Amies </div>";
	
	//Traitement Liste Demmande Amies.
	$donnee_amies=Traitement($liste_demmande);
	if($donnee_amies=="") echo "<div class='cadre_message'> Aucune Demmande D'Amies </div>";
	else
	{
		//Liste Amies.
		echo "<div class='cadre_des_amies'>";
		do
		{
			$id_amies=$donnee_amies[0];
		
			$requette = "select liens_Photo,nom from renseignement where Id_User='$id_amies'";
			$resultat_requette=Requette($base,$requette);
			$donnee_amies=Traitement($resultat_requette);
		
			$liens_Photo=$donnee_amies[0];
			$nom=$donnee_amies[1];
			
			if($liens_Photo=="")$liens_Photo="../DATA/SITE/Image/Photo_Profile.png";
			if($nom=="")$nom="Non Renseigner";
			
			echo "<div class='cadre_amies'>";
			echo "<div class='nom_amies'>".$nom."</div>";
			echo "<div class='photo_amies'>";
			echo "<img src='".$liens_Photo."' class='taille_photo_amies'/>";
			echo "</div>";
			echo "<form action='ProfilMenbre.php?menbre=".$id_amies."' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Voir Profile' />";
			echo "</form>";
			echo "<form action='DemmandeAmies.php?menbre=".$id_amies."&&option=1' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Acceptee' />";
			echo "</form>";
			echo "<form action='DemmandeAmies.php?menbre=".$id_amies."&&option=2' method='post'>";
			echo "<input class='bouton_selection_amies' type='submit' value='Refusee' />";
			echo "</form>";
			
			echo "</div>";
		}
		while($donnee_amies=Traitement($liste_demmande));
		echo "</div>";
	}
	Deconnexion($base);
	
	echo "</body>";
	echo "</html>";
?>