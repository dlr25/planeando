<?php
$nom=$_POST['nombre'];
$ape=$_POST['apellidos'];
$eda=$_POST['edad'];
$cor=$_POST['correo'];
$con1=$_POST['pass'];
$con2=$_POST['pass2'];
$gen=$_POST['genero'];
$red=$_POST['rrss'];
$img = NULL;
$nombreCiudad=$_POST['ciudad'];
$registrado=false;

//CADENA DE CONEXION
$hostname="localhost";
$username="root";
$pass="";
$bdname="travel-match";
$tabla="usuario";

$conexion = mysqli_connect($hostname, $username, $pass, $bdname);

if(!$conexion){
	die("Error al conectar" .mysql_connect_error());	
}elseif($con1 != $con2){
	echo "<script>alert('Ambas contraseñas deben ser iguales');window.location='../webapp-front-end/register.php'</script>";
}

$con = password_hash($con1, PASSWORD_DEFAULT);

//CAMBIAR EL NOMBRE DE LA CIUDAD POR SU ID (RESTRICCIÓN CLAVE AJENA)
$consultaPrevia = "SELECT `id` FROM `ciudad` WHERE `nombre` = '$nombreCiudad'";
$selectIdCiudad = mysqli_query($conexion,$consultaPrevia);

if($fila = mysqli_fetch_assoc($selectIdCiudad)){
	$ciu = $fila['id'];
}else{
	die("La ciudad no es válida");
}

mysqli_free_result($selectIdCiudad);

//Ahora toca todo el back sobre subir la imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Comprobar que el archivo es una imagen
    $fileTmpPath = $_FILES['imagen']['tmp_name'];
    $fileName = $_FILES['imagen']['name'];
    $fileSize = $_FILES['imagen']['size'];
    $fileType = $_FILES['imagen']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    //Extensiones de archivo permitidas
    $allowedfileExtensions = array('jpg', 'png', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions) && $fileSize < 5000000) { // Límite de 5MB
        // Directorio donde se guardarán las img
        $uploadFileDir = '../webapp-front-end/Imagenes/ImagenesPerfil/';
				
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            echo 'Archivo subido con éxito.';
						$img = $dest_path;

        } else {
            echo 'Error al mover el archivo al directorio de destino.';
        }
    } else {
        echo 'Subida fallida, posibles razones: tipo de archivo no permitido o el archivo es demasiado grande.';
    }
} else {
    echo 'Error en la subida del archivo: ', $_FILES['imagen']['error'];
}


//INSERTAR DATOS (CREAR USUARIO EN LA BD)
/*
$consulta="INSERT INTO `usuario`(`nombre`, `apellidos`, `edad`, `email`, `contrasenya`, `genero`, `redes_sociales`, `imagen`, `fk_usuario_ciudad`) VALUES ('$nom','$ape','$eda','$cor','$con','$gen','$red', '$img', '$ciu')";
if(mysqli_query($conexion,$consulta)){
	echo "Datos ingresados correctamente";
	$registrado=true;
}else{
	die("Algo salió mal, pero no te preocupes, no es culpa tuya");
}*/

$con = password_hash($con1, PASSWORD_DEFAULT);
//INSERTAR DATOS (EVITANDO INYECCIONES SQL Y CON LA CONTRASEÑA HASHEADA)
$consulta="INSERT INTO `usuario`(`nombre`, `apellidos`, `edad`, `email`, `contrasenya`, `genero`, 
																	`redes_sociales`, `imagen`, `fk_usuario_ciudad`) VALUES (?,?,?,?,?,?,?,?,?)";
if ($stmt = $conexion->prepare($consulta)) {
    $stmt->bind_param("ssisssssi", $nom, $ape, $eda, $cor, $con, $gen, $red, $img, $ciu);
    if ($stmt->execute()) {
        echo "Datos ingresados correctamente";
        $registrado = true;
    } else {
        die("Error al crear el usuario: " . $stmt->error);
    }
    $stmt->close();
} else {
    die("Ha ocurrido un error al crear el usuario, pero no te preocupes, no es tu culpa. " . $conexion->error);
}

//CREAR LA RELACIÓN USUARO-CATEGORÍA POR CADA CATEGORÍA ELEGIDA
//Primero, haremos un 'select' sobre el Id del usuario 
$consultaIdUSU = "SELECT `id` FROM `usuario` WHERE `nombre` = '$nom'";
$selectIdUSU = mysqli_query($conexion,$consultaIdUSU);

if($filaUsu = mysqli_fetch_assoc($selectIdUSU)){
	$idUsu = $filaUsu['id'];
}else{
	die("El usuario no es válido");
}

//A continuación, iteraremos sobre cada una de las categorías elegidas por el usuario
if (!empty($_POST['categorias'])) {		
	$stmt = $conexion->prepare("INSERT INTO `interes_USU-CAT` (`categoria`, `usuario`) VALUES (?, ?)");
	foreach ($_POST['categorias'] as $idCat) {
			$stmt->bind_param("ii", $idCat, $idUsu);
			$stmt->execute();
	}
}

	//	foreach ($_POST['categorias'] as $idCat) {
	//			$idCat = $conexion->real_escape_string($idCat);
	//			$sql = "INSERT INTO `interes_USU-CAT` (`categoria`, `usuario`) VALUES ('$idUsu', '$idCat')";
	//			$conexion->query($sql);
	//	}

	if($registrado==true){
		echo "<script>alert('Bienvenido, a continuación inicie sesión');window.location='../webapp-front-end/index.php'</script>";
	}
	header ("location: ../webapp-front-end/index.php");
?>