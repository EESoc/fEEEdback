<?php

session_start();
require_once 'db.php';

include('class/user.class.php');
include('class/feedback.class.php');


require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array() );

//session:user saves the username
//we then create the user class from that username

if (@$_GET['do'] == 'logout')
{
	session_destroy();
	header('Location: ' . $_SERVER['SCRIPT_NAME']);
}

if (!@$_SESSION['user'])
{
	if (!empty($_POST))
	{
		//check login.
		$user = new user($db);

		if ($user->login($_POST['username'], $_POST['password']) === true)
		{
			header('Location: ' . $_SERVER['REQUEST_URI']);
			$_SESSION['user'] = $_POST['username'];
			//header();
		}
		else 
		{
			$error = $user->login_error;
		}
	}

	echo $twig->render('web_login', array(
		'title' => 'EE GTA Feedback',
		'error' => @$error
		));

	exit();
}

$user = new user($db, $_SESSION['user']);



