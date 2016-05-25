<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "security_exam";

$oDb = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);

 ?>