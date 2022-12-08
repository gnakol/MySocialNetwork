<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";
	
	//Test Connexion User.
	Demmarage_Session() ;
	$connecter = Session_User() ;
	
	//Redirection si non connecter.
	if(!$connecter) header('Location: Connexion.php');
	
	// Recuperation Id User.
	$id_user_cryptee = Get_Session_User() ;
		
	//Test Id Amies.
	$id_amies_cryptee="";
	if(isset($_GET['amies']))$id_amies_cryptee=Securiter($_GET['amies']);
	
	//Test Sujet.
	$sujet_post="";
	if( isset($_POST['sujet']))$sujet_post=Securiter($_POST['sujet']);
	
	//Test Message.
	$message_post="";
	if(isset($_POST['message']))$message_post=Securiter($_POST['message']);
	
	//Test Evoie Message.
	$message="";
	if($connecter&&$id_user_cryptee!=""&&$id_amies_cryptee!=""&&$sujet_post!=""&&$message_post!="")
	{
		$base=Connexion();
		$requette="insert into Message values(null,'$id_user_cryptee','$id_amies_cryptee','$sujet_post','$message_post')";
		$resultat_requette=mysqli_query($base,$requette);
		Deconnexion($base);
		
		if($resultat_requette)header('Location: Profil.php');
	}
	else $message="Les Formulaires sont Vide";
	
	//----------------------------------------------------------------------
		
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Envoie Message </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/EnvoieMessage.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	// Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
	
	// Titre.
	echo "<div class='titre_site'> My Social Network : Envoie Message </div>";
	
	// Formulaire Envoie Message.
	echo "<form action='EnvoieMessage.php?amies=".$id_amies_cryptee."' method='POST'>";
	echo "<div class='cadre_envoie_message'>";
	echo "<div class='cadre_message'>".$message."</div>";
	echo "<div class='cadre_formulaire_envoie_message'> ";
	echo "<input class='formulaire_envoie_message' name='sujet' type='text' placeholder='Sujet' />";
	echo "<br><textarea class='formulaire_envoie_message' name='message' type='text'> </textarea>";
	echo "</div>";
	echo "<input class='bouton_envoie_message' type='reset' value='Anuller' />";
	echo "<input class='bouton_envoie_message' type='submit' value='Envoyer' />";
	echo "</div>";
	echo "</form>";
	
	echo "</body>";
	echo "</html>";
	
?>