<?php 

	/*
		conex de la base de datos

		by Jx5
		________________________
	*/

	// $host = "bs6qky2w2qtwb750goke-mysql.services.clever-cloud.com";
	// $database = "bs6qky2w2qtwb750goke";
	// $username = "uep2azywn1e2asqk";
	// $password = "6WGjJ2iVirjH7X3lTwTS";

	$host = "localhost";
	$database = "formtest_db";
	$username = "root";
	$password = "";

	// Cestablecer conexion
	$conn = mysqli_connect($host, $username, $password, $database);


	// comprobar conexion
	if (!$conn) {

	    die("Connection failed: " . mysqli_connect_error());
	}

?>