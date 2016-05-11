<?php
session_start();

$servername = "localhost";
$username = "admin";
$password = "";
$dbname = "security_exam";

$oDb = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);

 ?>