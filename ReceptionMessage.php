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
		
	//Test Message.
	$id_cryptee_message="";
	if(isset($_GET['message']))$id_cryptee_message=Securiter($_GET['message']);
	
	//Test Option.
	$option="";
	if(isset($_GET['option']))$option=Securiter($_GET['option']);
	
	//Connexion Base.
	$base=Connexion();

	//Test Suppression Message.
	if($connecter&&$option==1&&$id_cryptee_message)
	{	
		$requette="DELETE FROM message WHERE sha1(Id_Message)='$id_cryptee_message'";
		$resultat_requette=Requette($base,$requette);
	}
	
	//Liste Message.
	$requette="select * from message where id_amies='$id_user_cryptee' order by id_message desc";
	$liste_message=Requette($base,$requette);
	
	//----------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Reception Message </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/ReceptionMessage.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	// Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
	
	//Titre.
	echo "<div class='titre_site'> My Social Network : Reception Message </div>";
	
	//Traitement Liste Post.
	 $donnee_message=Traitement($liste_message);
	if($donnee_message=="")echo "<div class='cadre_message1'> Aucun Message </div>";
	else
	{
		//Liste Message.
		echo "<div class='cadre_liste_message'>";
		do
		{
			$id_message=sha1($donnee_message[0]);
			$id_user=$donnee_message[1];
			$sujet=$donnee_message[3];
			$message=$donnee_message[4];
			
			$requette="select nom,prenom from renseignement where id_user='$id_user'";
			$resultat_renseignement=Requette($base,$requette);
			$donnee_amies=Traitement($resultat_renseignement);
			
			$nom=$donnee_amies[0];
			$prenom=$donnee_amies[1];
		
			if($nom=="")$nom="Non Renseigner";
			if($prenom=="")$prenom="Non Renseigner";
			
			//Message.
			echo "<div class='cadre_message'>";
			
			echo "<form action='ReceptionMessage.php?message=".$id_message."&&option=1' method='POST'>";
			echo "<div class='cadre_sujet_message'>";
			echo "<div class='sujet_message'>".$sujet."</div>";
			echo "<input class='suppresion_message' type='submit' value='X' />";
			echo "</div>";
			echo "</form>";
			echo "<a href='ProfilMenbre.php?menbre=".$id_user."'>";
			echo "<div class='donnee_amies'>".$nom." ".$prenom."</div>";
			echo "</a>";
			echo "<div class='donnee_message'>".$message."</div>";
			echo "</div>";
		}
		while($donnee_message=Traitement($liste_message));
		echo "</div>";
	}
	Deconnexion($base);	
	
	echo "</body>";
	echo "</html>";
	
?>
