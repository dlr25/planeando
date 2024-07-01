<?php
$nomb=$_POST['nomusu'];
$correo=$_POST['correousu'];
$password=$_POST['passusu'];

//CADENA DE CONEXION
$hostname="localhost";
$username="root";
$pass="";
$bdname="tfg";
$tabla="usuarios-prueba";

$conexion = mysqli_connect($hostname, $username, $pass, $bdname);

if(!$conexion){
	die("Error al conectar" .mysql_connect_error());	
}

echo "Conectado correctamente";


//INSERTAR DATOS
$consulta="INSERT INTO `usuarios-prueba`(`nombre`, `contrasenya`, `email`) VALUES ('$nomb','$password','$correo')";
if(mysqli_query($conexion,$consulta)){
	echo "Datos ingresados correctamente";
	header ("location: PRUEBA-BD.html");
}

?>