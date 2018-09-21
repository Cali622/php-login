<?php

$servername = 'localhost';
$username = 'root';
$password = 'Cali_1022';
$dbname = 'testapp';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
	echo 'Connection Error '.mysqli_connect_error();
}

?>