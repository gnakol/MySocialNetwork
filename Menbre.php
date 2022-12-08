<?php
	
	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";

	//Test Connexion User.	
	Demmarage_Session();
	$connecter=Session_User();
	$id_user_cryptee=Get_Session_User();
	
	//Test Recherche Profil.
	$recherche_profile="";
	if(isset($_POST['recherche_profile']))
	{
		$recherche_profile=Securiter($_POST['recherche_profile']);
		if(!Test_Login($recherche_profile))$recherche_profile="";
	}
	
	//Recherche Liste Menbre.
	$base=Connexion();
	$requette="select id_user from Utilisateur";	
	$liste_user=Requette($base,$requette);

	//----------------------------------------------------------------------

	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Menbre </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Menbre.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	//Navigation.
	echo "<div class='navigation_site'>";
	if(!$connecter) echo "<a href='Inscription.php'><div class='bouton_navigation'> Inscription </div></a>";
	if(!$connecter) echo "<a href='Connexion.php'><div class='bouton_navigation'> Connexion </div></a>";
	if($connecter) echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
	
	//Titre.
	echo "<div class='titre_site'> My Social Network : Liste Menbre </div>";
	
	//Traitement Liste Menbre.
	$donnee_user=Traitement($liste_user);
	if($donnee_user=="") echo "<div class='cadre_message'> Aucun Menbre Inscript </div>" ;
	else
	{
		//Recherche.
		echo "<form action='Menbre.php' method='post'>";
		echo "<div class='cadre_recherche_menbre'>";
		echo "<input class='formulaire_recherche_menbre' name='recherche_profile' type='search' placeholder='Recherche Menbre' value='" . $recherche_profile . "'/> ";
		echo "<input class='bouton_recherche_menbre' type='submit' value='Recherche' />";
		echo "</div>";
		echo "</form>";
		
		//Liste Menbre.
		echo "<div class='cadre_des_menbres'>";
		do
		{
			$id_user=sha1($donnee_user[0]);
		
			$requette="select liens_photo,nom from renseignement WHERE id_user='$id_user'";	
			$renseignement=Requette($base,$requette);
			$renseignement_user=Traitement($renseignement);
			
			$liens_photo=$renseignement_user[0];
			$nom=$renseignement_user[1];
			
			if($nom=="")$nom="Anonyme";
			if($liens_photo=="")$liens_photo="../DATA/SITE/Image/Photo_Profile.png";
				
			$indice="0";
			if( $recherche_profile != "")$indice=strpos($nom,$recherche_profile )."";
			else $indice="1";
					
			if($indice!=""&&$id_user!=$id_user_cryptee)
			{
				echo "<div class='cadre_menbre'>";
				echo "<div class='nom_menbre'>".$nom."</div>";
				echo "<div class='photo_menbre'>";
				echo "<img src='".$liens_photo."' class='taille_photo_menbre'/>";
				echo "</div>";
				echo "<form action='ProfilMenbre.php?menbre=".$id_user."' method='post'>";
				echo "<input class='bouton_selection_menbre' type='submit' value='Visitée Menbre' />";
				echo "</form>";
				echo "</div>";
			}
		}
		while($donnee_user=Traitement($liste_user));
		echo "</div>";
	}
	Deconnexion($base);
	
	echo "</body>";
	echo "</html>";
?>