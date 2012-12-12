<?php

/* Code and Design created and managed by Dario Magliocchetti & Thomas Lim
 * Do not replicate, use or host any part of this code without prior permission.
 *
 * Project for GTA feedback within the department. To be used by EE1 and EE2.
 *
 * File: success.php
 * Use:
 *      Logs user out after showing the success page
 *
*/


include('core.php');
$twig->addGlobal('user', $user);

echo $twig->render('core', array('content' => $twig->render('success')));

session_destroy();