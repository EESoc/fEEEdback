<?php

include('core.php');
$twig->addGlobal('user', $user);

echo $twig->render('core', array('content' => 'success'));