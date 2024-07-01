<?php
	require_once('conexion.php');

	session_start();
	$_SESSION["user_id"] = "";
	session_destroy();

	header("Location: ../webapp-front-end/index.php");
?>