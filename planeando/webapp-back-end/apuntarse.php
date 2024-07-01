<?php
$planId=$_POST['planId'];
$sessionId=$_POST['sessionId'];
$yaApuntado=false;

//CADENA DE CONEXION
$hostname="localhost";
$username="root";
$pass="";
$bdname="travel-match";
$tabla="usuario";

$conexion = mysqli_connect($hostname, $username, $pass, $bdname);

if(!$conexion){
	die("Error al conectar" .mysql_connect_error());	
}

//OBTENEMOS TODAS LAS FILAS EXISTENTES DE LA TABLA USUARIOS-PLANES (APUNTARSE):
$consultaApuntarse = "SELECT `usuario`, `plan` FROM `apuntarse_usu-pla`";
$selectApuntados = mysqli_query($conexion,$consultaApuntarse);

while($fila = mysqli_fetch_assoc($selectApuntados)){
	
	//Si el usuario ya está apuntado en ese plan en la base de datos, lo indicamos.
	if($fila['usuario'] == $sessionId && $fila['plan'] == $planId){
		$yaApuntado=true;
		echo "<script>alert('Ya está apuntado al plan');window.location='../webapp-front-end/search-plan.php'</script>";
	}
}

//Si el usuario no está apuntado ya a ese plan, creamos la relación
if(!$yaApuntado){
	$consulta = "INSERT INTO `apuntarse_usu-pla` VALUES ('$sessionId', '$planId')";
	if(mysqli_query($conexion,$consulta)){
		echo "Datos ingresados correctamente";
		header ("location: ../webapp-front-end/search-plan.php");
	}else{
		die("Algo salió mal, pero no te preocupes, no es culpa tuya");
	}
}
?>