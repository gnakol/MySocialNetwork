<?php

	//Include.
	include "Fonction/Session.php";
	
	//Deconnxion.	
	Demmarage_Session();
	Destruction_Session();
		
	//----------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Deconnexion </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";	
	echo "</head>";
	echo "<body>";
	
	//Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Menbre.php'><div class='bouton_navigation'> Menbre </div></a>";
	echo "<a href='Inscription.php'><div class='bouton_navigation'> Inscription </div></a>";
	echo "<a href='Connexion.php'><div class='bouton_navigation'> Connexion </div></a>";
	echo "</div>";
	
	//Titre.
	echo "<div class='titre_site'> My Social Network : Deconnexion </div>";
	
	echo "</body>";
	echo "</html>";

?>