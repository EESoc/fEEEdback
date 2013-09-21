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
$tutorpage = new feedback_tutors($db);
if ($gtas = $gtapage->getgta($user->usergroup))
{
	$tutors = $tutorpage->getgta($user->tutorgroup);
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
		foreach($tutors as $tutor)
		{
			// For each GTA with a score, let's validate and save
			if (isset($_POST[$tutor['id'].'_tut_score']) && $_POST[$tutor['id'].'_tut_score'] != -1) {
				if (!(ctype_digit($_POST[$tutor['id'].'_tut_score']) && $_POST[$tutor['id'].'_tut_score'] <= 5 && $_POST[$tutor['id'].'_tut_score'] >= 1)) {
					$error = 'Scores must be integers between 1 and 5';
					break;
				}

				$save_tut[] = array(
					'gtaid' => $tutor['id'],
					'uname' => $user->user,
					'vote' => (isset($_POST[$tutor['id'].'_tut_na'])) ? '0' : $db->escape_string($_POST[$tutor['id'].'_tut_score']),
					'comment' => $db->escape_string($_POST[$tutor['id'].'_tut_comments'])
				);
			}

		}

		if (!isset($error) && (isset($save) || isset($save_tut)))
		{
			if ($gtapage->insert_results(@$save) && $tutorpage->insert_results($save_tut))
            {
				header("Location: index.php?do=thanks");
			}
			else
            {
				$error = $tutorpage->error;
			}
		}
	}

	$content = $twig->render('survey_start');
	$i = 0;
	foreach ($gtas as $gta)
	{
		$result = $db->query("SELECT * FROM gta_chem_feedback WHERE gtaid = '" . $gta['id'] . "' AND uname = '" . $user->user . "'");
        if(!$result->num_rows)
		{
			$content .= $twig->render('survey_middle', array(
				'gta' => $gta,
				'type' => 'gta',
				'count' => $i++
			));
		}
	}
	foreach ($tutors as $key2=>$tutor)
	{
		$result = $db->query("SELECT * FROM gta_chem_tutor_feedback WHERE gtaid = '" . $tutor['id'] . "' AND uname = '" . $user->user . "'");
        if(!$result->num_rows)
		{
			$content .= $twig->render('survey_middle', array(
				'gta' => $tutor,
				'type' => 'tutor',
				'count' => $i++
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