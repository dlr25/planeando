<?php
	  if(!isset($_SESSION)) { 
        session_start(); // Comenzamos la sesión (si existe un usuario logueado) 
    } 
//CADENA DE CONEXION
$hostname="localhost";
$username="root";
$pass="";
$bdname="travel-match";

$conexion = mysqli_connect($hostname, $username, $pass, $bdname);

if(!$conexion){
	die("Error al conectar" .mysql_connect_error());	
}
?>