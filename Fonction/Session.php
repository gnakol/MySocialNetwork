<?php

	function Demmarage_Session()
	{
		session_start() ;
	}
		
	function Destruction_Session()
	{
		session_unset() ;
		session_destroy() ;
	}
	
	// ---------------------------------------------------------------------
	
	function Session_User()
	{
		if( isset( $_SESSION[ 'User' ] ) ) return true ;
		else return false ;
	}
		
	function Get_Session_User()
	{
		if( isset( $_SESSION[ 'User' ] ) ) return $_SESSION[ 'User' ] ;
		else return "" ;
	}
		
	function Set_Session_User( $valeur )
	{
		$_SESSION[ 'User' ] = $valeur ;
	}
	
	// ---------------------------------------------------------------------

	function Session_Login()
	{
		if( isset( $_SESSION[ 'Login' ] ) ) return true ;
		else return false ;
	}
		
	function Get_Session_Login()
	{
		if( isset( $_SESSION[ 'Login' ] ) ) return $_SESSION[ 'Login' ] ;
		else return "" ;
	}
		
	function Set_Session_Login( $valeur )
	{
		$_SESSION[ 'Login' ] = $valeur ;
	}
	
?>