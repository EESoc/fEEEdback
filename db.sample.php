<?php
	
	$user = ''
	$pass = ''
	$database = ''

	$db = new mysqli('localhost', $user, $pass, $db);

	if ($db->connect_error)
	{
	    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	define("LOCAL", false);
?>