<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea un plan</title>
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

        .textarea {
          width: 100%;
          box-sizing: border-box; /* Asegura que el padding de abajo no afecte el ancho total */
        }

        .texto-largo {
          padding-right: 350px;
          margin-bottom: 50px;
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
		}
	?>


  <section class="section">
    <div class="container">
      <div class="registration-form">
        <h1 class="title">CREAR UN PLAN</h1>

        <form action="../webapp-back-end/new_plan-back.php" method="post" enctype="multipart/form-data">
          <div class="columns">
            <!-- Columna 1 -->
            <div class="column">
              <div class="field">
                <label class="label">Título del plan</label>
                <div class="control">
                  <input class="input" name="titulo" type="text" placeholder="Título del plan" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Ciudad</label>
                <div class="control">
                  <input class="input" name="ciudad" type="text" placeholder="Ciudad (si varias, la principal)" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Breve descripción (5-10 palabras)</label>
                <div class="control">
                  <input class="input" name="breve-descripcion" type="text" placeholder="Breve descripción" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Número de plazas</label>
                <div class="control">
                  <input class="input" name="plazas" type="number" placeholder="Plazas disponibles" required>
                </div>
              </div>

              <br>

              <!-- Sección de categorías -->
              <div class="interests-section">
								<h2 class="title is-4">Categorías (escoja todas las relacionadas)</h2>
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
										<div class="column"></div> <!-- Columna extra para juntar más los intereses -->
									</div>
								</div>
              </div>

              <!-- Columna 2 -->
              <div class="column">
                <div class="field">
                  <label class="label">Localización quedada</label>
                  <div class="control">
                    <input class="input" name="localizacion" type="text" placeholder="Lugar exacto de inicio" required>
                  </div>
              </div>

              <div class="field">
                <label class="label">Fecha</label>
                <div class="control">
                  <input class="input" name="fecha" type="date" placeholder="Fecha de inicio" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Hora</label>
                <div class="control">
                  <input class="input" name="hora" type="time" placeholder="Hora de inicio" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Requisitos</label>
                <div class="control">
                  <input class="input" name="requisitos" type="text" placeholder="Requisitos para apuntarte al plan" required>
                </div>
              </div>

              <div class="field">
                <label class="label">Precio por persona (en euros)</label>
                <div class="control">
                  <input class="input" name="precio" type="number" placeholder="Precio total por persona" required>
                </div>
              </div>

              <br>

              <!-- Zona para subir una foto relacionada -->
								<div class="profile-picture">Foto relacionada</div>
								<input type="file" name="imagen" id="imagen" style="display:none;">
								<label for="imagen" class="button is-outlined" id="boton-subir-foto">Seleccionar imagen</label>       
            </div>
          </div>

          <div class="container">
              <div class="texto-largo">
                  <label class="label">Descripción completa</label>
                  <div class="control">
                      <textarea class="textarea" name="descripcion" placeholder="Describe todo el plan o viaje, con pelos y señales" required></textarea>
                  </div>
              </div>
          </div>

          <div class="field">
            <div class="control">
              <button type="submit" class="button is-link">CREAR PLAN</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

</body>
</html>