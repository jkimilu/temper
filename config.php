<?php


$host="localhost";
$db="temper";
$user="root";
$password="";

$connection=mysql_pconnect($host,$user,$password) or die("Error Connecting");
mysql_select_db($db,$connection) or die("Error connecting to database $db");



?>