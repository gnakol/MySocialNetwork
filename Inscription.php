<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";
	
	// Test Connexion User.	
	Demmarage_Session();
	$connecter=Session_User();
	if($connecter)header('Location: Profil.php');
	
	// Message.
	$message="";
	
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
		if(!Test_MotsPasse($motspasse))
		{
			$motspasse="";
			$message="Le Mots de Passe est pas Bon";
		}
	}
	else $message="Le Mots de Passe est Vide.";
		
	//Inscription.
	if(Test_Login($login)&&Test_MotsPasse($motspasse))
	{		
		$login_crytee=sha1($login);
		$motspasse_crytee=sha1($motspasse);
		
		$base=Connexion();
		$requette="select * from Utilisateur where login='$login_crytee'";	
		$resultat=Requette($base,$requette);
		$resultat=Traitement($resultat);

		if($resultat!=null) $message="Login deja Utilisee";
		else
		{
			$requette="insert into Utilisateur values(null,'$login_crytee','$motspasse_crytee')";	
			$resultat=Requette($base,$requette);
			
			$requette="select Id_User from Utilisateur where login='$login_crytee' and motspasse='$motspasse_crytee'";	
			$resultat=Requette($base,$requette);
			$resultat=Traitement($resultat);
			
			$id_crytee=sha1($resultat[0]);
			
			if($resultat!=null)
			{
				$requette="insert into Renseignement values(null,'$id_crytee','','','','','','','')";	
				$resultat=Requette($base,$requette);
				mkdir("../DATA/USER/".$id_crytee);
			}
			
			Deconnexion($base);
			if($resultat!=null)header('Location: Connexion.php');
		}
		Deconnexion($base);
	}
	
	//----------------------------------------------------------------------
		
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Inscription </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Inscription.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	// Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Menbre.php'><div class='bouton_navigation'> Menbre </div></a>";
	echo "<a href='Connexion.php'><div class='bouton_navigation'> Connexion </div></a>";
	echo "</div>";
	
	// Titre.
	echo "<div class='titre_site'> My Social Network : Inscription </div>";
	
	// Inscription.
	echo "<form action='Inscription.php' method='post'>";
	echo "<div class='cadre_inscription'>";
	echo "<div class='cadre_message'>".$message."</div>";
	echo "<div class='cadre_formulaire_inscription'>";
	echo "<input class='formulaire_inscription' name='login' type='text' placeholder='Login' />";
	echo "<input class='formulaire_inscription' name='motspasse' type='password' placeholder='Mots de Passe' />";
	echo "</div>";
	echo "<input class='bouton_inscription' type='reset' value='Anuller' />";
	echo "<input class='bouton_inscription' type='submit' value='Inscription' />";
	echo "</div>";
	echo "</form>";
	
	echo "</body>";
	echo "</html>";

?>