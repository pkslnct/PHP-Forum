<?php
//connect.php
$server = 'localhost';
$username   = '1224410';
$password   = 'myPassWord';
$database   = '1224410';
 
if(!mysql_connect($server, $username,  $password))

{
    exit('Error: could not establish database connection');
}

if(!mysql_select_db($database))

{
    exit('Error: could not select the database');
}

?>