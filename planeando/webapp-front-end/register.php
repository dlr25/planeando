<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
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
            margin-bottom: 10px;
            margin-left: 25px;
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
        .rrss {
          padding-right: 200px;
          margin-bottom: 10px;
        }
    </style>
</head>
<body>

	<?php
	  if(!isset($_SESSION)) { 
        session_start(); // Comenzamos la sesión (si existe un usuario logueado) 
    } 

		if (empty($_SESSION['usuario'])) {
			include 'header-notloggedin.php';	//Si no hay un usuario logueado, mostramos el header correspondiente.
		}else{
			include 'header-loggedin.php';		//Si hay un usuario logueado, mostramos el otro header.
		}
	?>


    <section class="section">
      <div class="container">
          <div class="registration-form">
              <h1 class="title">REGISTRO</h1>

              

              
							<form action="../webapp-back-end/registro-back.php" method="post" enctype="multipart/form-data">
								<!-- Zona para subir y mostrar foto de perfil -->
								<div class="profile-picture">Foto de perfil</div>
								<input type="file" name="imagen" id="imagen" style="display:none;">
								<label for="imagen" class="button is-outlined" id="boton-subir-foto">Seleccionar foto de perfil</label>           

								<div class="columns">
                      <!-- Columna 1 -->
                      <div class="column">
                          <div class="field">
                              <label class="label">Nombre</label>
                              <div class="control">
                                  <input class="input" name="nombre" type="text" placeholder="Nombre">
                              </div>
                          </div>

                          <div class="field">
                              <label class="label">Apellidos</label>
                              <div class="control">
                                  <input class="input" name="apellidos" type="text" placeholder="Apellidos">
                              </div>
                          </div>

                          <div class="field">
                              <label class="label">Ciudad</label>
                              <div class="control">
                                  <input class="input" name="ciudad" type="text" placeholder="Ciudad">
                              </div>
                          </div>

                          <div class="field">
                              <label class="label">Edad</label>
                              <div class="control">
                                  <input class="input" name="edad" type="number" placeholder="Edad">
                              </div>
                          </div>

                          <!-- Sección de intereses -->
                          <div class="interests-section">
                              <h2 class="title is-4">Intereses</h2>
																<div class="columns">
																	<div class="column">
																		<?php
																			include '../webapp-back-end/conexion.php';
																			
																			$query = "SELECT id, nombre FROM categoria";
																			$resultado = $conexion->query($query);
																			
																			$flag = true;
																			while ($flag && $fila = $resultado->fetch_assoc()) {
																				echo '<label>';
																				echo '<input type="checkbox" name="categorias[]" value="' . $fila['id'] . '"> ';
																				echo htmlspecialchars($fila['nombre']);
																				echo '</label><br>';
																				
																				if($fila['nombre'] == 'Deporte'){
																					$flag = false;
																				}
																			}
																		?>																	
																	</div>
																	<div class="column">
																		<?php
																			while ($fila = $resultado->fetch_assoc()) {
																				echo '<label>';
																				echo '<input type="checkbox" name="categorias[]" value="' . $fila['id'] . '"> ';
																				echo htmlspecialchars($fila['nombre']);
																				echo '</label><br>';
																			}
																		?>
																	</div>
																</div>
                          </div>
                      </div>

                      <!-- Columna 2 -->
                      <div class="column">
                          <div class="field">
                              <label class="label">Correo Electrónico</label>
                              <div class="control">
                                  <input class="input" name="correo" type="email" placeholder="Correo Electrónico" required>
                              </div>
                          </div>

                          <div class="field">
                              <label class="label">Contraseña</label>
                              <div class="control">
                                  <input class="input" name="pass" type="password" placeholder="Contraseña" required>
                              </div>
                          </div>

                          <div class="field">
                              <label class="label">Repite la contraseña</label>
                              <div class="control">
                                  <input class="input" name="pass2" type="password" placeholder="Repite la contraseña" required>
                              </div>
                          </div>

                          <div class="field">
                            <label class="label">Género</label>
                            <div class="control">
                              <div class="select">
																<select name="genero" required>
																	<option value="masculino">Masculino</option>
																	<option value="femenino">Femenino</option>
																	<option value="no-binario">No Binario</option>
																	<option value="no-decir">Prefiero no decirlo</option>
																</select>					
															</div>
														</div>
													</div>

                          <div class="container">
                            <div class="rrss">
                                <label class="label">Redes sociales</label>
                                <div class="control">
                                    <textarea class="textarea" name="rrss" placeholder="Escribe aquí tus usuarios de las redes sociales que consideres" required></textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>

                  <div class="field">
                      <div class="control">
                          <button type="submit" class="button is-link">Registrarse</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </section>
</body>
</html>