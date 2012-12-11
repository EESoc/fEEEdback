<?php

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
			//Check that all data has been pushed properly & is valid
			if (!isset($_POST[$gta['id'].'_score'])) {
				$error = "Missing data from submission - please complete score for all GTAs.";
				break;
			}
			elseif (!(ctype_digit($_POST[$gta['id'].'_score']) && $_POST[$gta['id'].'_score'] <= 5 && $_POST[$gta['id'].'_score'] >= 1)) {
				$error = 'Scores much be integers!';
				break;
			}

			$save[] = array(
				'gtaid' => $gta['id'],
				'uname' => $user->user,
				'vote' => (isset($_POST[$gta['id'].'_na'])) ? '0' : $db->escape_string($_POST[$gta['id'].'_score']),
				'comment' => $db->escape_string($_POST[$gta['id'].'_comments'])
			);
			
		}

		if (!isset($error))
		{
			if ($gtapage->insert_results($save))
            {
				$user->completed_survey();
				header("Location: success.php");
			} else
            {
				$error = $gtapage->error;
			}
		}
	}

	$content = $twig->render('survey_start');
	foreach ($gtas as $key=>$gta)
	{
		$content .= $twig->render('survey_middle', array(
			'gta' => $gta,
			'count' => $key
		));
	}
	$content .= $twig->render('survey_end', array('error' => @$error));
}
else
{
	$content = $gtapage->error;
}


echo $twig->render('index', array(
	'content' => $content
));