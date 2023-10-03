<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "3117";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
	
	die("failed to connect!");
}
