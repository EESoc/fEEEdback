<?php


$db = new mysqli('localhost', '', '', '');

($db->connect_error) ? die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error) : null;

define("LOCAL", false); // In case we do anything special because we can't do it locally, but only locally.
?>