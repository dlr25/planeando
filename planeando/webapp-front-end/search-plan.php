<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscar Planes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="index.css" />

  <!-- Añado "FontAwesome" para usar el icono del ojo en la funcionalidad de mostrar la conraseña -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    .plan-container {
        padding: 20px;
        border: 1px solid lightgray;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        border-bottom: 1px solid lightgray;
				background-color: #e1e9f0;
				
    }
    .plan-image {
        flex: 0 0 200px; /* fija el tamaño de la imagen y evita que crezca o se encoja */
        margin-right: 30px;
    }
		
    .plan-image img {
			width: 200px;
			height: 200px;
			border: 1px solid #cfcfcf;
			margin-bottom: 10px;
			margin-top: 10px;
			margin-left: 5px;
			display: flex;
			align-items: center;
			justify-content: center;
    }
		
    .plan-details {
        flex: 1;
    }
    .plan-title {
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .plan-categories {
        margin-top: 10px; /* separa las categorías del resto del contenido */
    }
    .plan-action {
      flex: 1;
    }
		
		#etiqueta{
			margin-right: 5px;
		}
		
		#prueba{
			width: 300px;
		}
		
		#elementoInicial{
			margin-right: 20px;
		}
		
		.plan-sin-imagen {
			width: 200px;
			height: 200px;
			border: 1px solid #cfcfcf;
			margin-bottom: 10px;
			margin-top: 10px;
			margin-left: 5px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 20px;
			color: #b5b5b5;
			background-color: #f7fafd;
    }
		
  </style>

</head>
<body>

	<?php
		session_start(); // Comenzamos la sesión (si existe un usuario logueado)

		if (empty($_SESSION['usuario'])) {
			include 'header-notloggedin.php';	//Si no hay un usuario logueado, mostramos el header correspondiente.
		}else{
			include 'header-loggedin.php';		//Si hay un usuario logueado, mostramos el otro header.
			$idSession = $_SESSION['usuario']['id']; //Almacenamos el ID del usuario	para compararlo con el ID del plan y no permitir al usuario apuntarse.
		}
		
		//Nos conectamos a la base de datos
		$hostname="localhost";
		$username="root";
		$pass="";
		$bdname="travel-match";

		$conexion = mysqli_connect($hostname, $username, $pass, $bdname);

		if(!$conexion){
			die("Error al conectar" .mysql_connect_error());	
		}
		
		//Obtenemos todos los planes con una 'select'
		$getPlanes = "SELECT `id`, `localizacion`, `fecha`, `hora`, `precio`, `requisitos`, `descripcion`, `titulo`, `descripcion-breve`, `plazas`, `imagen`, `fk_plan_ciudad`, `fk_plan_usuario` FROM `plan`";
		$selectPlanes = mysqli_query($conexion,$getPlanes);
		
		$getIdCiudad = "SELECT `fk_plan_ciudad` FROM `plan`";
		$selectIdCiudad = mysqli_query($conexion,$getIdCiudad);
		
		$getNombreCiudades = "SELECT `id`, `nombre` FROM `ciudad` ORDER BY `nombre`";
		$selectCiudades = mysqli_query($conexion,$getNombreCiudades);
		
		//Obtenemos todos los planes
		$getCategorias = "SELECT `id`, `nombre` FROM `categoria` ORDER BY `nombre`";
		$selectCategorias = mysqli_query($conexion,$getCategorias);
		
		//Obtenemos todos los planes (otra vez, porque los necesitaré en dos ocasiones y no me fío de reestablecer el puntero de fetch_assoc)
		//$getPlanesCat = "SELECT `id`, `nombre` FROM `categoria` ORDER BY `nombre`";
		//$selectPlanesCat = mysqli_query($conexion,$getCategorias);
		
		$getPlanesCat = "SELECT `categoria`, `plan` FROM `pertenece_pla-cat`";
		$selectPlanesCat = mysqli_query($conexion,$getPlanesCat);
		
		//****FALTA COMPROBAR QUE LA CONSULTA ES CORRECTA******
		
		$getApuntados = "SELECT `usuario`, `plan` FROM `apuntarse_usu-pla`";
		$selectApuntados = mysqli_query($conexion,$getApuntados);
	?>


  <section class="section">
    <div class="container">
			<!-- Buscador y filtro -->
				<form class="field is-grouped" action="" method="get" id="prueba">
					<div class="control" id="elementoInicial">
							<div class="select is-fullwidth">
									<select name="ciudadFiltro" id="prueba">
										<option selected="selected" value="ninguna">Cualquier ciudad</option>
										<?php while ($ciudadx = $selectCiudades->fetch_assoc()): ?>
												
												<option value="<?php echo htmlspecialchars($ciudadx['id']); ?>">
														<?php echo htmlspecialchars($ciudadx['nombre']); ?>
												</option>
										<?php endwhile; ?>
									</select>
							</div>
					</div>
					<div class="control" id="elementoInicial">
							<div class="select is-fullwidth">
									<select name="categoriaFiltro" id="prueba">
										<option selected="selected" value="ningunaCat">Cualquier categoría</option>
										<?php while ($categoriax = $selectCategorias->fetch_assoc()): ?>
												
												<option value="<?php echo htmlspecialchars($categoriax['id']); ?>">
														<?php echo htmlspecialchars($categoriax['nombre']); ?>
												</option>
										<?php endwhile; ?>
									</select>
							</div>
					</div>
					<div class="control">
							<button type="submit" class="button is-info">Buscar</button>
					</div>
				</form>

      <!-- LISTADO DE PLANES -->
			<?php 
				//while($filaCat = $selectPlanesCat->fetch_assoc()):

				//endwhile;
			
				if(isset($_GET['ciudadFiltro'])) {
						$ciud = $_GET['ciudadFiltro'];
					}else{
						$ciud = 'ninguna';
				}
				
				if(isset($_GET['categoriaFiltro'])) {
					$cat = $_GET['categoriaFiltro'];
				}else{
					$cat = 'ningunaCat';
				}
				
				//Metemos todos los planes en un array porque con el puntero fetch_assoc solo funcionaría en la primera iteración (y no soy fan de mover el puntero)
				$categoriasPlanes = [];
				while($filaCatPlan = $selectPlanesCat->fetch_assoc()) {
						$categoriasPlanes[] = $filaCatPlan;
				}
				
				//Metemos todos los planes de la tabla "apuntados" en un array
				$apuntados = [];
				while($filaApuntados = $selectApuntados->fetch_assoc()){
					$apuntados[] = $filaApuntados['plan'];
				}
				
				//Bucle principal donde cada plan se muestra por pantalla, además de los cálculos correspondientes
				while($fila = $selectPlanes->fetch_assoc()):
				
					$cantidadApuntados = 0;
					$flagFiltroCategorias = false;
					 
					if($cat != 'ningunaCat'){
						foreach ($categoriasPlanes as $filaCatPlan) {
							if(($cat == $filaCatPlan['categoria']) && ($fila['id'] == $filaCatPlan['plan'])){
									$flagFiltroCategorias = true;
							}
						}
					}	

					foreach($apuntados as $filaApuntados){
						if($fila['id'] == $filaApuntados && $cantidadApuntados < $fila['plazas']){
							$cantidadApuntados++;
						}
					}
			?>
			
			<?php if(($ciud == 'ninguna' || $ciud == $fila['fk_plan_ciudad']) && ($cat == 'ningunaCat' || $flagFiltroCategorias == true)):  ?>
			
			<?php

				//OBTENEMOS EL NOMBRE DE LA CIUDAD A RAÍZ DE SU ID (fk_plan_ciudad es el ID)
				$idCiudad = $fila['fk_plan_ciudad'];
				
				$getCiudad = "SELECT `nombre`, `id_pais` FROM `ciudad` WHERE `id` = '$idCiudad'";
				$selectNombCiu = mysqli_query($conexion,$getCiudad);

				if($filaCi = mysqli_fetch_assoc($selectNombCiu)){
					$ciudad = $filaCi['nombre'];
					$idPais = $filaCi['id_pais'];
				}else{
					die("La ciudad no es válida");
				}

				mysqli_free_result($selectNombCiu);
				
				//A CONTINUACIÓN, OBTENEMOS EL NOMBRE DEL PAÍS A RAÍZ DE SU ID (idPais)
				$getPais = "SELECT `nombre` FROM `pais` WHERE `id` = '$idPais'";
				$selectNombPais = mysqli_query($conexion,$getPais);

				if($filaPa = mysqli_fetch_assoc($selectNombPais)){
					$pais = $filaPa['nombre'];
				}else{
					die("El país no es válido");
				}
				
				mysqli_free_result($selectNombPais);
				
				//LUEGO, OBTENEMOS EL NOMBRE Y LOS APELLIDOS DEL USUARIO A RAÍZ DE SU ID (fk_plan_usuario)
				$idUsuario = $fila['fk_plan_usuario'];
				
				$getUsuario = "SELECT `nombre`, `apellidos` FROM `usuario` WHERE `id` = '$idUsuario'";
				$selectNombUsuario = mysqli_query($conexion,$getUsuario);

				if($filaUs = mysqli_fetch_assoc($selectNombUsuario)){
					$usuario = $filaUs['nombre'] . ' ' . $filaUs['apellidos'];
				}else{
					die("El usuario no es válido");
				}
				
				mysqli_free_result($selectNombUsuario);
				
				//POR ÚLTIMO, OBTENEMOS OBTENEMOS LAS CATEGORÍAS RELACIONADAS CON CADA PLAN
				$idPlan = $fila['id'];

				// Preparar la consulta
				$stmt = $conexion->prepare("SELECT c.nombre AS categoria_nombre FROM plan p JOIN `pertenece_pla-cat` cp ON p.id = cp.plan JOIN categoria c ON cp.categoria = c.id WHERE p.id = '$idPlan'");
				//$stmt->bind_param("i", $idPlan);
				$stmt->execute();
				$resultado = $stmt->get_result();

				// Asumiendo que cada plan solo se muestra una vez y sus categorías juntas
				$categorias = [];
				while ($categ = $resultado->fetch_assoc()) {
						$categorias[] = $categ['categoria_nombre'];
				}
				?>
			
      <div>
        <div class="plan-container">
          <div class="plan-image">
            <?php if (isset($fila['imagen'])): ?>
							<img src="<?php echo htmlspecialchars($fila['imagen']);?>">
						<?php else: ?>
							<div class="plan-sin-imagen" >Sin imagen</div>
						<?php endif; ?>
          </div>
          <div class="plan-details">
            <div class="plan-title"> <?php echo htmlspecialchars($fila['titulo']); ?> </div>
              <p>Fecha y hora: <strong><?php echo htmlspecialchars($fila['fecha']); echo htmlspecialchars(' | ' . $fila['hora']); ?></strong></p>
              <p>Localización: <strong><?php echo htmlspecialchars($ciudad); echo htmlspecialchars(', ' . $pais); ?></strong></p>
              <p>Asistentes: <strong><?php echo htmlspecialchars($cantidadApuntados); echo htmlspecialchars(' / ' . $fila['plazas']); ?></strong></p>
              <p>Creador del plan: <strong><?php echo htmlspecialchars($usuario); ?></strong></p>
              <p>Descripción: <strong><?php echo htmlspecialchars($fila['descripcion']); ?></strong></p>
              <div class="plan-price">Precio por persona: <strong><?php echo htmlspecialchars($fila['precio'] . ' €'); ?></strong></div>
                <div class="plan-categories">
									<?php
										foreach ($categorias as $categoria) {
												echo "<strong> <span id=etiqueta class=tag is-primary>" . htmlspecialchars($categoria) . "</span> </strong>";
										}
									?>
                </div>
              </div>
							<?php if($idUsuario != $idSession && $cantidadApuntados < $fila['plazas']): ?>
								<form action="../webapp-back-end/apuntarse.php" method="post">
									<input type="hidden" name="planId" value="<?php echo $fila['id']; ?>">
									<input type="hidden" name="sessionId" value="<?php echo $idSession; ?>">
									<div class="plan-button">
										<button type="submit" class="button is-info is-focused">Apuntarse</button>
									</div>
								</form>
							<?php endif; ?>
            </div>
          </div>
					<?php endif; ?>
					<?php endwhile; ?>
        </div>
      </div>
    </div>
  </section>

</body>
</html>