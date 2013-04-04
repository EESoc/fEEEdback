<?php

/* Code and Design created and managed by Dario Magliocchetti & Thomas Lim
 * Do not replicate, use or host any part of this code without prior permission.
 *
 * Project for GTA feedback within the department. To be used by EE1 and EE2.
 *
 * File: core.php
 * Use:
 *      Initialises classes, databases and session. Handles login and logout.
 *
*/

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

if(currentpage != 'admin')
{
	if(time()>1367621999)  //This automatically closes the survey if beyond the finishing time, unless it's the admin page.
	{
		echo $twig->render('closed');
		exit();
	}
}

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
			header('Location: index.php');
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



