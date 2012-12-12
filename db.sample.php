<?php

/* Code and Design created and managed by Dario Magliocchetti & Thomas Lim
 * Do not replicate, use or host any part of this code without prior permission.
 *
 * Project for GTA feedback within the department. To be used by EE1 and EE2.
 *
 * File: db.sample.php
 * Use:
 *      Sample database connection
 *
*/

$db = new mysqli('localhost', '', '', '');

($db->connect_error) ? die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error) : null;

define("LOCAL", false); // In case we do anything special because we can't do it locally, but only locally.
?>