<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="index.css" />

  <style>
    .image-description-container {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start; /* Asegura que la imagen y la descripción comiencen en la misma línea */
        justify-content: space-between;
    }
    .plan-description {
        flex: 1; /* Permite que la descripción llene el espacio disponible */
        max-width: 48%; /* Ajusta este valor según necesites */
    }
    .plan-image {
        flex: 1; /* Permite que la imagen se ajuste dinámicamente, pero puedes fijar un tamaño si lo prefieres */
        max-width: 48%; /* Ajusta este valor según necesites */
    }
    .plan-image img {
        width: 100%; /* Hace que la imagen ocupe todo el espacio disponible */
        height: auto; /* Mantiene la proporción de la imagen */
    }
  </style>

</head>
<body>
	<?php
		session_start(); // Comenzamos la sesión (si existe un usuario logueado)

		if (!isset($_SESSION['usuario'])) {
			include 'header-notloggedin.php';	//Si no hay un usuario logueado, mostramos el header correspondiente.
		}else{
			include 'header-loggedin.php';		//Si hay un usuario logueado, mostramos el otro header.
		}
	?>

  
  <section class="section">
    <div class="container">
        <h1 class="title">TÍTULO DEL PLAN</h1>
        <h2 class="subtitle">Categorías: <span class="tag is-primary">Categoría 1</span></h2>
        <p><strong>Localización:</strong> Ciudad, País</p>
        <p><strong>Fecha y hora:</strong> DD/MM/AAAA HH:MM</p>
        
        <div class="image-description-container">
          <div class="plan-description">
              <p>Descripción larga: Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis atque consectetur, culpa, odit illum quae iure repudiandae inventore officiis quasi ad in sint laboriosam iusto voluptatum distinctio sunt deserunt doloremque? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maxime eum dignissimos fugiat omnis impedit cupiditate quo labore reprehenderit cumque ratione earum consequuntur totam, consectetur laboriosam asperiores deserunt aperiam, adipisci quae!</p>
          </div>
          <figure class="plan-image">
              <img src="ruta/a/la/imagen_del_plan.jpg" alt="Imagen del plan">
          </figure>
        </div>
        
        <p><strong>Precio:</strong> $XX.XX</p>
        <p><strong>Cantidad de gente apuntada:</strong> X personas</p>
        <p><strong>Requisitos especiales:</strong> Detalles de los requisitos especiales</p>

        <div class="has-text-centered">
            <p>Plan propuesto por: <strong>Nombre del creador</strong></p>
            <button class="button is-large is-info">Solicitar apuntarse</button>
        </div>
    </div>
  </section>
</body>
</html>