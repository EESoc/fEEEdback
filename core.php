<?php

session_start();

include('class/user.class.php');

require_once 'db.php';

require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array() );

//session:user saves the username
//we then create the user class from that username

if (!@$_SESSION['user'])
{
	if (!empty($_POST))
	{
		//check login.
		$user = new user;

		if ($user->login($_POST['username'], $_POST['password']) === true)
		{
			$error = 'good';
		}
		else {
			$error = 'Invalid username or password';
		}
	}

	echo $twig->render('web_login', array(
		'title' => 'EE GTA Feedback',
		'error' => @$error
		));

	exit();
}

$user = new user($_SESSION['user']);

