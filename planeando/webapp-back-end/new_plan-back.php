<?php
$tit=$_POST['titulo'];
$nombreCiudad=$_POST['ciudad'];
$bdesc=$_POST['breve-descripcion'];
$pla=$_POST['plazas'];
$loc=$_POST['localizacion'];
$fec=$_POST['fecha'];
$hor=$_POST['hora'];
$req=$_POST['requisitos'];
$pre=$_POST['precio'];
$desc=$_POST['descripcion'];
$img = NULL;

//Establecemos la conexion
require_once('conexion.php');

//RESCATAMOS EL ID DEL USUARIO QUE CREA EL PLAN (RESTRICCIÓN CLAVE AJENA 1)
$usu = $_SESSION['usuario']['id'];	

//RESCATAMOS EL ID DE LA CIUDAD DONDE SERÁ EL PLAN (RESTRICCIÓN CLAVE AJENA 2)
$consultaPrevia = "SELECT `id` FROM `ciudad` WHERE `nombre` = '$nombreCiudad'";
$selectId = mysqli_query($conexion,$consultaPrevia);

if($fila = mysqli_fetch_assoc($selectId)){
	$ciu = $fila['id'];
}else{
	die("La ciudad no es válida");
}

mysqli_free_result($selectId);

//Ahora toca todo el back sobre subir la imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Comprobar que el archivo es una imagen
    $fileTmpPath = $_FILES['imagen']['tmp_name'];
    $fileName = $_FILES['imagen']['name'];
    $fileSize = $_FILES['imagen']['size'];
    $fileType = $_FILES['imagen']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Extensiones de archivo permitidas
    $allowedfileExtensions = array('jpg', 'png', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions) && $fileSize < 5000000) { // Límite de 5MB
        // Directorio donde se guardarán las imágenes
        $uploadFileDir = '../webapp-front-end/Imagenes/ImagenesPlan/';
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


//INSERTAR DATOS
$consulta="INSERT INTO `plan`(`localizacion`, `fecha`, `hora`, `precio`, `requisitos`, `descripcion`, `titulo`, `descripcion-breve`, `plazas`, `imagen`, `fk_plan_ciudad`, `fk_plan_usuario`) VALUES ('$loc','$fec','$hor','$pre','$req','$desc','$tit','$bdesc','$pla','$img','$ciu','$usu')";
if(mysqli_query($conexion,$consulta)){
	echo "Datos ingresados correctamente";
}

//CREAR LA RELACIÓN PLAN-CATEGORÍA POR CADA CATEGORÍA ELEGIDA
//Primero, haremos un 'select' sobre el Id del plan 
$consultaIdPLAN = "SELECT `id` FROM `plan` WHERE `titulo` = '$tit'";
$selectIdPLAN = mysqli_query($conexion,$consultaIdPLAN);

if($filaPlan = mysqli_fetch_assoc($selectIdPLAN)){
	$idPlan = $filaPlan['id'];
}else{
	die("El plan no es válido");
}

//A continuación, iteraremos sobre cada una de las categorías elegidas que se relacionan con el plan
if (!empty($_POST['categorias'])) {		
	$stmt = $conexion->prepare("INSERT INTO `pertenece_PLA-CAT` (`plan`, `categoria`) VALUES (?, ?)");
	foreach ($_POST['categorias'] as $idCat) {
			$stmt->bind_param("ii", $idPlan, $idCat);
			$stmt->execute();
	}
}

header ("location: ../webapp-front-end/index.php");

?>

