<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";
	
	//Test Connexion User.
	Demmarage_Session() ;
	$connecter = Session_User() ;
	if($connecter)header('Location: Profil.php');
	
	//Test Login.
	$login="";
	if(isset($_POST['login'])) 
	{
		$login=Securiter($_POST['login']);
		if(!Test_Login($login))
		{
			$login="";
			$message="Le Login est pas Bon";
		}
	}
	else $message="Le Login est Vide.";
	
	//Test Mots Passe.
	$motspasse="";
	if(isset($_POST['motspasse'])) 
	{
		$motspasse=Securiter($_POST['motspasse']);
		if(!Test_Login($motspasse))
		{
			$motspasse="";
			$message = "Le Mots de Passe est pas Bon";
		}
	}
	else $message="Le Mots de Passe est Vide.";
		
	//Connexion.
	if(Test_Login($login)&&Test_MotsPasse($motspasse))
	{		
		$login_crytee=sha1(Securiter($login));
		$motspasse_crytee=sha1(Securiter($motspasse));
		
		$base=Connexion();
		$requette="select * from Utilisateur where login='$login_crytee' and motspasse='$motspasse_crytee'";	
		$resultat_reqette=Requette($base,$requette);
		$donnee=Traitement($resultat_reqette);
		Deconnexion($base) ;
		
		if($donnee!=null)
		{
			 Set_Session_User(sha1($donnee[0]));
			 //Set_Session_Login($login_crytee);
			 header('Location: Profil.php');
		}
		else $message = "Compte non trouver";		
	}
	
	//----------------------------------------------------------------------
			
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Connexion </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Connexion.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	//Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Menbre.php'><div class='bouton_navigation'> Menbre </div></a>";
	echo "<a href='Inscription.php'><div class='bouton_navigation'> Inscription </div></a>";
	echo "</div>";
	
	//Titre.
	echo "<div class='titre_site'> My Social Network : Connexion </div>";
	
	//Connexion.
	echo "<form action='Connexion.php' method='post'>";
	echo "<div class='cadre_connexion'>";
	echo "<div class='cadre_message'>".$message."</div>";
	echo "<div class='cadre_formulaire_connexion'>";
	echo "<input class='formulaire_connexion' name='login' type='text' placeholder='Login'/>";
	echo "<input class='formulaire_connexion' name='motspasse' type='password' placeholder='Mots de Passe'/>";
	echo "</div>";
	echo "<input class='bouton_connexion' type='reset' value='Anuller' />";
	echo "<input class='bouton_connexion' type='submit' value='Connexion' />";
	echo "</div>";
	echo "</form>";
	
	echo "</body>";
	echo "</html>";

?>