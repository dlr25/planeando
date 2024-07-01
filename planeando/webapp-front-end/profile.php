<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="index.css" />
    <style>
        .registration-form {
            margin: 20px;
        }
        .registration-form .columns {
            margin-top: 10px;
        }
        .input {
            width: 300px;
        }

        #boton-subir-foto{
          margin-left: 25px;
          width: 250px;
        }

        
        .profile-picture {
            width: 250px;
            height: 250px;
            border: 1px solid #cfcfcf;
            margin-bottom: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #b5b5b5;
            background-color: #f7fafd;
        }
        .checkbox {
            margin-right: 5px;
        }
        .interests-section {
            margin-top: 20px;
        }
				
				.plan-container {
					border: 1px solid #ddd;
					padding: 10px;
					margin-bottom: 10px;
					border-radius: 5px;
					background-color: #f7fafd;
        }

        .plan-title {
					font-weight: bold;
					margin-bottom: 5px;
        }

        .plan-price {
            color: #228B22;
            font-weight: bold;
        }
				
				.pp-name {
					display: flex;
					flex-direction: column;
					align-items: center;
					text-align: center;
					margin-right: 50px;
				}
    </style>
</head>
<body>

	<?php
		session_start(); // Comenzamos la sesión (si existe un usuario logueado)

		if (empty($_SESSION['usuario'])) {
			include 'header-notloggedin.php';	//Si no hay un usuario logueado, mostramos el header correspondiente.
			header('index.php');							//y lo mandamos a la página principal
			exit();
		}else{
			include 'header-loggedin.php';		//Si hay un usuario logueado, mostramos el otro header.
			
			//Y guardamos todas las variables
			$id = $_SESSION['usuario']['id'];	
			$nombre = $_SESSION['usuario']['nombre'];	
			$apellidos = $_SESSION['usuario']['apellidos'];
			$edad = $_SESSION['usuario']['edad'];
			$mail = $_SESSION['usuario']['email'];
			$genero = $_SESSION['usuario']['genero'];
			$rrss = $_SESSION['usuario']['redes_sociales'];
			$imagen = $_SESSION['usuario']['imagen'];
			
			//AQUÍ COMIENZA LA EXTRACCION DE LA CIUDAD Y EL PAIS
			//CADENA DE CONEXION
			$hostname="localhost";
			$username="root";
			$pass="";
			$bdname="travel-match";

			$conexion = mysqli_connect($hostname, $username, $pass, $bdname);

			if(!$conexion){
				die("Error al conectar" .mysql_connect_error());	
			}

			$fk_usu_ciu = $_SESSION['usuario']['fk_usuario_ciudad'];

			//OBTENEMOS EL NOMBRE DE LA CIUDAD A RAÍZ DE SU ID (fk_usuario_ciudad es el ID)
			$getCiudad = "SELECT `nombre`, `id_pais` FROM `ciudad` WHERE `id` = '$fk_usu_ciu'";
			$selectNombCiu = mysqli_query($conexion,$getCiudad);

			if($fila = mysqli_fetch_assoc($selectNombCiu)){
				$ciudad = $fila['nombre'];
				$idPais = $fila['id_pais'];
			}else{
				die("La ciudad no es válida");
			}

			mysqli_free_result($selectNombCiu);
			
			//AHORA OBTENEMOS EL NOMBRE DEL PAÍS A RAÍZ DE SU ID 
			$getPais = "SELECT `nombre` FROM `pais` WHERE `id` = '$idPais'";
			$selectNombPais = mysqli_query($conexion,$getPais);

			if($fila = mysqli_fetch_assoc($selectNombPais)){
				$pais = $fila['nombre'];
			}else{
				die("El país no es válido");
			}

			mysqli_free_result($selectNombPais);	
			
			//OBTENEMOS LOS PLANES DE LA TABLA "APUNTARSE"
			$getApuntados = "SELECT ap.`usuario`, ap.`plan`, p.`titulo`, p.`descripcion-breve`, p.`fecha`, p.`hora`, p.`precio` FROM `apuntarse_usu-pla` ap JOIN `plan` p ON ap.`plan` = p.`id`";
			$selectApuntados = mysqli_query($conexion,$getApuntados);

			//CALCULAMOS A CUÁNTOS PLANES SE HA APUNTADO EL USUARIO Y RECOGEMOS A CUÁLES
			$apuntado = 0;
			$planesApuntado = [];
			while($filaApuntados = $selectApuntados->fetch_assoc()){
				if($id == $filaApuntados['usuario']){
					$apuntado++;
					$planesApuntado[] = $filaApuntados;
				}
			}
			
			$getCreados = "SELECT `id`, `localizacion`, `fecha`, `hora`, `precio`, `requisitos`, `descripcion`, `titulo`, `descripcion-breve`, `plazas`, `imagen`, `fk_plan_ciudad`, `fk_plan_usuario` FROM `plan` WHERE fk_plan_usuario = $id";
			$selectCreados = mysqli_query($conexion,$getCreados);
			
			//CALCULAMOS CUÁNTOS PLANES HA CREADO EL USUARIO Y RECOGEMOS CUÁLES
			$creados = 0;
			$planesCreados = [];
			while($filaCreados = $selectCreados->fetch_assoc()){
				$creados++;
				$planesCreados[] = $filaCreados;
			}			

			//A CONTINUACIÓN, OBTENDREMOS TODAS LAS CATEGORÍAS EN LAS QUE EL USUARIO TIENE INTERÉS
			//$getCategorias = "SELECT `categoria` FROM `interes_usu-cat` WHERE `usuario` = '$id'";
			//$selectNombPais = mysqli_query($conexion,$getCategorias);

			
			// Preparar la consulta SQL para ejecutar
			$stmt = $conexion->prepare("SELECT c.nombre FROM categoria c JOIN `interes_usu-cat` uc ON c.id = uc.categoria WHERE uc.usuario = ?");
			$stmt->bind_param("i", $id); // 'i' indica que la variable es de tipo entero

			// Ejecutamos la consulta
			$stmt->execute();

			// Obtenemos los resultados
			$resultado = $stmt->get_result();

			// Añadimos las categorías a un array que luego usaremos para imprimirlas por pantalla
			$categorias = [];
			while ($fila = $resultado->fetch_assoc()) {
				$categorias[] = $fila['nombre'];
			}

			// Cerramos la sentencia y la conexión
			$stmt->close();
			$conexion->close();	
		}
	?>


    <section class="section">
      <div class="container">
          <div class="columns">
						<!-- Columna Izquierda: Nombre y Foto de Perfil -->
						<div class="column is-one-third">
							<div class="pp-name">
								<h1 class="title"><?php echo htmlspecialchars($nombre . ' ' . $apellidos) ?></h1>
								
								<?php if (isset($imagen)): ?>
									<img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de perfil" class="profile-picture">
								<?php else: ?>
									 <div class="profile-picture">Sin foto de perfil</div>
								<?php endif; ?>
								
								<!-- Redes Sociales -->
								<div class="content">
										<h2>Redes Sociales</h2>
										<p style="text-align: left"><?php echo htmlspecialchars($rrss) ?></p>
								</div>

								<!--
								<figure class="image is-128x128">
										<img class="is-rounded" src="ruta/a/la/foto_de_perfil.jpg" alt="Foto de perfil">
								</figure>
								-->
							</div>
						</div>

						<!-- Columna Derecha: Datos del Usuario -->
						<div class="column">
							<p style="background-color: rgba(240,244,248,0.7);"><strong>País:</strong><?php echo htmlspecialchars(' ' . $pais) ?></p>
							<br>
							<p style="background-color: rgba(240,244,248,0.7);"><strong>Ciudad:</strong><?php echo htmlspecialchars(' ' . $ciudad) ?></p>
							<br>
							<p style="background-color: rgba(240,244,248,0.7);"><strong>Email:</strong><?php echo htmlspecialchars(' ' . $mail) ?></p>
							<br>
							<p style="background-color: rgba(240,244,248,0.7);"><strong>Edad:</strong><?php echo htmlspecialchars(' ' . $edad) ?></p>
							<br>
							<p style="background-color: rgba(240,244,248,0.7);"><strong>Género:</strong><?php echo htmlspecialchars(' ' . $genero) ?></p>
							<br>
							<p style="background-color: rgba(240,244,248,0.7);"><strong>Cantidad de planes a los que se ha apuntado:</strong> <?php echo htmlspecialchars(' ' . $apuntado) ?></p>
							<br>
							<p style="background-color: rgba(240,244,248,0.7);"><strong>Cantidad de planes realizados:</strong> <?php echo htmlspecialchars(' ' . $creados) ?></p>
							<br>
							<p><strong>Intereses:</strong></p>
							<ul class="puntos">
								<?php foreach ($categorias as $categoria): ?>
									<li><?php echo htmlspecialchars('- ' . $categoria); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						
						<!-- Columna Derecha: Planes Creados y Apuntados -->
						<div class="column">
							<h2 class="title">Planes Creados</h2>
							<?php foreach ($planesCreados as $plan): ?>
								<div class="plan-container">
									<h3 class="plan-title"><?php echo htmlspecialchars($plan['titulo']); ?></h3>
									<p><?php echo htmlspecialchars($plan['fecha'] . ' ' . $plan['hora']); ?></p>
									<p><?php echo htmlspecialchars($plan['descripcion-breve']); ?></p>
								</div>
							<?php endforeach; ?>
							
							<br>
							<br>

							<h2 class="title">Planes Apuntado</h2>
							<?php foreach ($planesApuntado as $plan): ?>
								<div class="plan-container">
									<h3 class="plan-title"><?php echo htmlspecialchars($plan['titulo']); ?></h3>
									<p><?php echo htmlspecialchars($plan['fecha'] . ' ' . $plan['hora']); ?></p>
									<p class="plan-price">Precio: <?php echo htmlspecialchars($plan['precio']) . ' €'; ?></p>
									<p><?php echo htmlspecialchars($plan['descripcion-breve']); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
          </div>
  

      </div>
  </section>
  
</body>
</html>