<?php

/* Code and Design created and managed by Dario Magliocchetti & Thomas Lim
 * Do not replicate, use or host any part of this code without prior permission.
 *
 * Project for GTA feedback within the department. To be used by EE1 and EE2.
 *
 * File: index.php
 * Use:
 *      Controller
 *
*/

define('currentpage', 'index');

include('core.php');

$twig->addGlobal('user', $user);

$gtapage = new feedback($db);

if ($gtas = $gtapage->getgta($user->usergroup))
{
	//Check POST;
	if (!empty($_POST))
	{
		foreach($gtas as $gta)
		{
			// For each GTA with a score, let's validate and save
			if (isset($_POST[$gta['id'].'_score']) && $_POST[$gta['id'].'_score'] != -1) {
				if (!(ctype_digit($_POST[$gta['id'].'_score']) && $_POST[$gta['id'].'_score'] <= 5 && $_POST[$gta['id'].'_score'] >= 1)) {
					$error = 'Scores must be integers between 1 and 5';
					break;
				}

				$save[] = array(
					'gtaid' => $gta['id'],
					'uname' => $user->user,
					'vote' => (isset($_POST[$gta['id'].'_na'])) ? '0' : $db->escape_string($_POST[$gta['id'].'_score']),
					'comment' => $db->escape_string($_POST[$gta['id'].'_comments'])
				);
			}

		}

		if (!isset($error) && isset($save))
		{
			if ($gtapage->insert_results($save))
            {
				header("Location: index.php?do=thanks");
			}
			else
            {
				$error = $gtapage->error;
			}
		}
	}

	$content = $twig->render('survey_start');
	foreach ($gtas as $key=>$gta)
	{
		$result = $db->query("SELECT * FROM gta_chem_feedback WHERE gtaid = '" . $gta['id'] . "' AND uname = '" . $user->user . "'");
        if(!$result->num_rows)
		{
			$content .= $twig->render('survey_middle', array(
				'gta' => $gta,
				'count' => $key
			));
		}
	}
	$content .= $twig->render('survey_end', array('error' => @$error));
}
else
{
	$content = $gtapage->error;
}

$thanks = (@$_GET['do'] == 'thanks') ? true : false;
echo $twig->render('index', array(
	'content' => $content,
	'thanks' => $thanks
));