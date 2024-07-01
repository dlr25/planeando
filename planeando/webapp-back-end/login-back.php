<?php
require_once('conexion.php');

$tabla="usuario";

$correo=$_POST['correo'];
$pass=$_POST['pass'];

$consulta = "SELECT * FROM `usuario` WHERE `email` = '$correo'";

$query = mysqli_query($conexion,$consulta); //password_verify?

$nr = mysqli_num_rows($query);

//Si existe ese usuario (la consulta de número de filas ha dado 1)
if($nr == 1 && $usuario = mysqli_fetch_assoc($query)){
	
	//Si el usuario se creó antes de hashear las contraseñas (mala mía)
	if($pass == $usuario['contrasenya']){
		// Almacenar los datos del usuario en $_SESSION
		$_SESSION['usuario'] = $usuario;
		$nombre = $_SESSION['usuario']['nombre'];
		echo "<script>alert('Bienvenido, $nombre');window.location='../webapp-front-end/index.php'</script>";		
	}
	
	//Si el usuario tiene una contraseña hasheada
	else if(password_verify($pass,$usuario['contrasenya'])){
		// Almacenar los datos del usuario en $_SESSION
		$_SESSION['usuario'] = $usuario;
		$nombre = $_SESSION['usuario']['nombre'];
		echo "<script>alert('Bienvenido, $nombre');window.location='../webapp-front-end/index.php'</script>";
	}
	
	else{
		echo "<script>alert('La contraseña no es correcta');window.location='../webapp-front-end/login.php'</script>";
	}

}else if($nr == 0){
	echo "<script>alert('El correo no está registrado');window.location='../webapp-front-end/login.php'</script>";
}

/*
$nom=$_POST['nombre'];
$ape=$_POST['apellidos'];
$eda=$_POST['edad'];
$cor=$_POST['correo'];
$con=$_POST['pass'];
$con2=$_POST['pass2'];
$gen=$_POST['genero'];
$red=$_POST['rrss'];
$nombreCiudad=$_POST['ciudad'];
*/
?>
