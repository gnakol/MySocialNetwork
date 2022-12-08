<?php

	function Securiter( $texte )
	{
		$texte = trim( $texte ) ;
		$texte = stripslashes( $texte ) ;
		$texte = htmlentities( $texte ) ;
		$texte = htmlspecialchars( $texte ) ;
		
		return $texte ;	
	}
	// mot de passe de 4 lettres au moins
	function Test_Login( $login )
	{
		if( preg_match("#^[a-zA-Z0-9]{3,20}$#", $login ) ) return true ;
		else return false ;
	}
	// 3 a 20 lettres minuscule maj et des chiffre
	function Test_MotsPasse( $motspasse )
	{
		if( preg_match("#^[a-zA-Z0-9]{3,20}$#", $motspasse ) ) return true ;
		else return false ;
	}
		//chiffre 0-99
	function Test_Age( $age )
	{
		if( preg_match("#^[0-9]{1,2}$#", $age ) ) return true ;
		else return false ;
	}
	//chiffre 6-10
	function Test_Telephone( $telephone )
	{
		if( preg_match("#^[0-9]{6,10}$#", $telephone ) ) return true ;
		else return false ;
	}

	//plusieurs lettres et chiffre@letttres ou chiffres.lettres ou chifre
	function Test_Email( $email )
	{
		if( preg_match("#^[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-zA-Z]+$#", $email ) ) return true ;
		else return false ;
	}
	
?>