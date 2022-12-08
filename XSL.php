<?php

	//Include.
	include "Fonction/Base.php";
	include "Fonction/Session.php";
	include "Fonction/Securiter.php";

	//Test Connexion User.
	Demmarage_Session();
	$connecter=Session_User();
	if(!$connecter)header('Location: Profil.php');
	
	//Recuperation Id User.
	$id_user_cryptee=Get_Session_User();
	
	//Connexion Base.
	$base=Connexion();
	
	//Liste Demmande Amies.
	$requette="select Amies from amies where User='$id_user_cryptee' order by Id_Amies desc";
	$liste_amies=Requette($base,$requette);

	//Creation Chemin Fichier.
	$chemin="../DATA/USER/".$id_user_cryptee."/mysocialnetwork.dtd";
	$xml="";
	
	//Creation Fichier XML.
	if(touch($chemin))
	{
		$xml.="<?xml version='1.0' encoding='UTF-9' standalone='yes' ?>\n";
		$xml.="<liste_amies>\n";
		
		//Traitement Liste Amies.
		$donnee_liste=Traitement($liste_amies); 
		if($donnee_liste!="")
		{
			do
			{
				$id=$donnee_liste[0];
				
				//Donnee User.
				$requette="select * from Renseignement where id_user='$id'";
				$donnee_user=Requette($base,$requette);
				$tab_donnee_user=Traitement($donnee_user);
				
				$nom=$tab_donnee_user[3];
				$prenom=$tab_donnee_user[4];
				$age=$tab_donnee_user[5];
				$telephone=$tab_donnee_user[6];
				$eMail=$tab_donnee_user[7];
				$twitter=$tab_donnee_user[8];
			 
				if($nom=="")$nom="Non Renseigner";
				if($prenom=="")$prenom="Non Renseigner";
				if($age=="")$age="Non Renseigner";
				if($telephone=="")$telephone="Non Renseigner";
				if($eMail=="")$eMail="Non Renseigner";
				if($twitter=="")$twitter="Non Renseigner";
				
				$xml.="<amies>\n";
				$xml.="<nom>".$nom."</nom>\n";
				$xml.="<prenom>".$prenom."</prenom>\n";
				$xml.="<age>".$age."</age>\n";
				$xml.="<telephone>".$telephone."</telephone>\n";
				$xml.="<email>".$eMail."</email>\n";
				$xml.="<twitter>".$twitter."</twitter>\n";
				$xml.="</amies>\n";				
			}
			while($donnee_liste=Traitement($liste_amies));
		}
		$xml.="</liste_amies>\n";
		
		$file=fopen($chemin,"w");
		fputs($file,$xml);
		fclose($file);
	}
		
	//Deconnexion Base.
	Deconnexion($base);
	
	//--------------------------------------------------------------------------
	
	//HTML.
	echo "<!DOCTYPE html>";
	echo "<head>";
	echo "<title> Profil </title>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Titre.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/Navigation.css' type='text/css' />";
	echo "<link rel='stylesheet' media='screen' href='../CSS/XSL.css' type='text/css' />";
	echo "</head>";
	echo "<body>";
	
	//Navigation.
	echo "<div class='navigation_site'>";
	echo "<a href='Profil.php'><div class='bouton_navigation'> Profil </div></a>";
	echo "</div>";
		
	//Titre.
	echo "<div class='titre_site'> My Social Network : XSL </div>";
	
	//Option.
	echo "<div class='cadre_option'>";
	echo "<a href=''><div class='bouton_option'> Style 1 </div></a>";
	echo "<a href=''><div class='bouton_option'> Style 2 </div></a>";
	echo "</div>";
	
	echo "</body>";
	echo "</html>";
	
	/*
	echo"<?xml version='1.0' ?>";
	echo"<xsl:stylesheet version='1.0' xmlns:xsl=''>";
	echo"<xsl:template match='$chemin'>";
	echo"<html><body>";
	//echo"<xsl:apply-templates select='amies' />";
	
	echo"<xsl:templates match='amies' />";
	echo"</xsl:value-of select='nom'>";
	echo"</xsl:template>";
	
	echo"</body></html>";
	echo"</xsl:template>";
	echo"</xsl:stylesheet>";
	*/
	
?>
