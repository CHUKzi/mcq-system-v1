<?php 
/*	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'mcq'; */

	$connection = mysqli_connect('localhost', 'root', '', 'mcq');

	// Checking the connection
	if (mysqli_connect_errno()) {
		die('Database connection failed ' . mysqli_connect_error());
	} /*else {
		echo "succses";
	}*/
?>