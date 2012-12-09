<?php
	
	$user = '';
	$pass = '';
	$database = '';

	$db = new mysqli('localhost', $user, $pass, $db);

	if ($db->connect_error)
	{
	    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	define("LOCAL", false); // In case we do anything special because we can't do it locally, but only locally.

	error_reporting(0); //Set to E_ALL for development. 

?>