<?php

include('core.php');
$twig->addGlobal('user', $user);

$survey = $twig->render('survey_start');


echo $twig->render('index');