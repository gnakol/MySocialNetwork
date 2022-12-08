<?php

	function Connexion()
	{
		$base = mysqli_connect( "localhost", "root", "noumko009", "networkphp" ) ;
		
		if( $base ) return $base ;
		else return -1 ;
	}
	
	function Deconnexion( $base )
	{
		mysqli_close( $base ) ;
	}
	
	function Requette($base,$requette)
	{
		if( $base ) return mysqli_query($base,$requette);
		else return "";
	}
	
	function Traitement( $donnee )
	{
		return mysqli_fetch_array($donnee);
	}
