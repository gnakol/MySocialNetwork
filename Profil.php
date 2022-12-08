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
	
	//Test Id Post.
	$id_cryptee_post="";
	if(isset($_GET['post']))$id_cryptee_post=Securiter($_GET['post']);
	
	//Test Id Commentaire.
	$id_cryptee_commentaire="";
	if(isset($_GET['commentaire']))$id_cryptee_commentaire=Securiter($_GET['commentaire']);
	
	//Test Option.
	$option="";
	if(isset($_GET['option']))$option=Securiter($_GET['option']);
	
	//Test Commentaire.
	$commentaire="";
	if(isset($_POST['post_commentaire']))$commentaire=Securiter($_POST['post_commentaire']);
		
	//Connexion Base.
	$base=Connexion();
	
	//Test Suppression Post.
	if($option== 1&&$id_cryptee_post!="")
	{
		$requette="select liens_Photo from post where sha1(id_post)='$id_cryptee_post'";
		$donnee_post=Requette($base,$requette);
		$tab_donnee_post=Traitement($donnee_post);
		
		$liens_Photo=$tab_donnee_post[0];
	
		if(unlink($liens_Photo))
		{
			$requette="delete from post where sha1(id_post)='$id_cryptee_post'";
			$resultat_requette=Requette($base,$requette);
			
			$requette="delete from likee where id_post='$id_cryptee_post'";
			$resultat_requette=Requette($base,$requette);
			
			$requette="delete from Commentaire where id_post='$id_cryptee_post'";
			$resultat_requette=Requette($base,$requette);
		}
	}
	
	//Test Suppression Commentaire.
	if($option== 1&&$id_cryptee_commentaire!="")
	{
		$requette="DELETE FROM commentaire WHERE sha1(Id_Commentaire)='$id_cryptee_commentaire'";
		$resultat_requette=Requette($base,$requette);
	}
	
	// Test Insection Commentaire.
	if($option== 2&&$commentaire!=""&&$id_cryptee_post!="")
	{
		$requette="insert into Commentaire values(null,'$id_cryptee_post','$id_user_cryptee','$commentaire')";
		$resultat_requette=Requette($base,$requette);
	}
	
	//Donnee User.
	$requette="select * from Renseignement where id_user='$id_user_cryptee'";
	$donnee_user=Requette($base,$requette);
	$tab_donnee_user=Traitement($donnee_user);
	
	$liens_Photo=$tab_donnee_user[2];
	$nom=$tab_donnee_user[3];
	$prenom=$tab_donnee_user[4];
	$age=$tab_donnee_user[5];
	$telephone=$tab_donnee_user[6];
	$eMail=$tab_donnee_user[7];
	$twitter=$tab_donnee_user[8];
 
	if($liens_Photo=="")$liens_Photo="../DATA/SITE/Image/Photo_Profile.png";
	if($nom=="")$nom="Non Renseigner";
	if($prenom=="")$prenom="Non Renseigner";
	if($age=="")$age="Non Renseigner";
	if($telephone=="")$telephone="Non Renseigner";
	if($eMail=="")$eMail="Non Renseigner";
	if($twitter=="")$twitter="Non Renseigner";
	
	//Liste Post.
	$requette="select * from post where id_user='$id_user_cryptee' order by Id_Post desc";
	$liste_post=Requette($base,$requette);
	
	//--------------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Profil </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Profil.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	// Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Menbre.php'><div class='bouton_navigation'> Menbre </div></a>";
	echo "<a href='Deconnexion.php'><div class='bouton_navigation'> Deconnexion </div></a>";
	echo "</div>";
		
	// Titre.
	echo "<div class='titre_site'> My Social Network : Profil </div>";
	
	// Option.
	echo "<div class='cadre_option'>";
	echo "<a href='XSL.php'><div class='bouton_option'> XSL </div></a>";
	echo "<a href='Renseignement.php'><div class='bouton_option'> Renseignement </div></a>";
	echo "<a href='DemmandeAmies.php'><div class='bouton_option'> Demmande Amies </div></a>";
	echo "<a href='ListeAmies.php'><div class='bouton_option'> Liste Amies </div></a>";
	echo "<a href='ListeAmies.php'><div class='bouton_option'> Envoyer Message </div></a>";
	echo "<a href='ReceptionMessage.php'><div class='bouton_option'> Reception Message </div></a>";
	echo "<a href='Post.php'><div class='bouton_option'> Post </div></a>";
	echo "</div>";
	
	//Renseignement.
	echo "<div class='cadre_entete_utilisateur'>";
	echo "<div class='donnee_profile_utilisateur'>";
	echo "<div class=''> Nom : ".$nom." </div> <br>";
	echo "<div class=''> Prenom : ".$prenom." </div> <br>";
	echo "<div class=''> Age : ".$age." </div>  ";
	echo "</div>";
	echo "<img src='".$liens_Photo."' class='photo_profile_utilisateur'/>";
	echo "<div class='donnee_profile_utilisateur'>";
	echo "<div class=''> Telephone : ".$telephone." </div> <br>";
	echo "<div class=''> EMail : ".$eMail." </div> <br>";
	echo "<div class=''> Twitter : ".$twitter." </div>  ";
	echo "</div>";
	echo "</div>";

	//Traitement Liste Post.
	$donnee_post=Traitement($liste_post);
	if($donnee_post=="")echo "<div class='cadre_message'> Aucun Post </div>" ;
	else
	{
		// Liste Post.
		echo "<div class='cadre_contenue'>";
		do
		{
			$id_Post=sha1($donnee_post[0]);
			$id_User=$donnee_post[1];
			$titre=$donnee_post[2];
			$liens_Photo=$donnee_post[3];
			$commentaire=$donnee_post[4];
			$partage=$donnee_post[5];
			$nb_Like=$donnee_post[6];
			
			//Post.
			echo "<div class='cadre_post'>";
			echo "<form action='Profil.php?post=".$id_Post."&&option=1' method='post'>";
			echo "<div class='cadre_titre_post'>";
			echo "<div class='titre_post'>".$titre."</div>";
			echo "<input class='suppresion_post' type='submit' value='X' />";
			echo "</div>";
			echo "</form>";
			echo "<div class='cadre_nombre_like'> Nombre de Like : ".$nb_Like."</div>";
			echo "<div class='cadre_post_photo'> ";
			echo "<img src='".$liens_Photo."' class='taille_post_photo'/>";
			echo "</div>";
			echo "<div class='cadre_post_commentaire'>";
			echo "<div class='post_commentaire'>".$commentaire."</div>";
			echo "</div>";
			
			$requette="select * from Commentaire where id_post='$id_Post' order by Id_Commentaire desc";
			$liste_commentaire=Requette($base,$requette);
			
			while($donnee_commentaire=Traitement($liste_commentaire))
			{
				$id_Commentaire=sha1($donnee_commentaire[0]);
				$id_Post=$donnee_commentaire[1];
				$id_User=$donnee_commentaire[2];
				$commentaire=$donnee_commentaire[3];
				
				echo "<form action='Profil.php?commentaire=".$id_Commentaire."&&option=1' method='post'>";
				echo "<div class='cadre_post_commentaire'>";
				echo "<input class='suppresion_commentaire' type='submit' value='X' />";
				echo "<div class='post_commentaire'> ".$commentaire." </div><br>";
				echo "</div>";
				echo "</form>";	
			}
			
			echo "<div class='cadre_ajoutee_commentaire'>";
			echo "<form action='Profil.php?post=".$id_Post."&&option=2' method='post'>";
			echo "<input class='formualire_ajoutee_commentaire' name='post_commentaire' type='text' value='' placeholder='Commentaire' />";
			echo "<input class='bouton_ajoutee_commentaire' type='submit' value='Ajouter' />";
			echo "</form>";
			echo "</div>";
			echo "</div>";
		}
		while($donnee_post=Traitement($liste_post));
		echo "</div>";
	}
	Deconnexion($base);
	 
	echo "</body>";
	echo "</html>";
	
?>