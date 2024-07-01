<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
<!--plantilla 1-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bulma.min.css">
  <link rel="stylesheet" href="index.css">

  <!--plantilla 5-->
  <link rel="shortcut icon" href="../images/fav_icon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <!-- Bulma Version 0.9.x -->
  <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
  <link rel="stylesheet" href="index.css" />
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">


  <title>Planeando - Home</title>

  <style>
    #randomImage{
      padding: 5px;
      border: 1px solid #ccc;
    }
		
		.forzar-altura {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh; /* Crear un div con class */
    }
		
		/* Estilos CSS que se aplican solo a pantallas de escritorio */
		@media (min-width: 1024px) { /* Ajusta 1024px según el tamaño mínimo de pantalla que consideres como 'escritorio' */
			body, html {
				height: 100%; /* Ajusta la altura al 100% de la ventana del navegador */
				overflow: hidden; /* Oculta el desplazamiento, impidiendo el scroll */
			}
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

    <!-- plantillica -->
    <section class="hero is-fullheight is-default is-bold">
      <div class="hero-body">
        <div class="container has-text-centered">
          <div class="columns is-vcentered">
            <div class="column is-5">
              <figure class="image is-4by3">
              <!--<img id="randomImage" src="https://picsum.photos/800/600/?random" alt="Description"> -->
                <img id="randomImage" src="Imagenes/Home/img1.jpg" alt="Imagen aleatoria">
              </figure>
            </div>
            <div class="column is-6 is-offset-1">
              <!--<h1 class="titulo-p">
                PLANEANDO
              </h1>-->
							<img src="Imagenes/LogoPlaneandoSinLineaHD.png" style="width: 80%; margin-bottom: -20px;" alt="LogoHome">
              <h2 class="subtitle is-4 subtitulo-p">
							<br>
                ¿Te gustaría hacer planes con la temática que tú quieras y no tienes con quién hacerlos?
								¿Te gustaría conocer gente que comparte tus mismas pasiones?
								Estás en el sitio adecuado.
								<br>
								<br>
								En "Planeando" encontraremos personas a tu gusto y con tus mismos intereses con quienes compartir un plan agradable.
              </h2>
              <br>
              <p class="has-text-centered">
								<?php if (empty($_SESSION['usuario'])): ?>
									<a class="button is-link is-large" href="register.php">
										¡Regístrate ya!
									</a>
								<?php else: ?>
									<h3 class="subtitle is-5"><strong> Gracias por registrarte </strong></h3>
								<?php endif; ?>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!--
      <div class="hero-foot">
        <div class="container">
          <div class="tabs is-centered">
            <ul>
              <li><a>And this is the bottom</a></li>
            </ul>
          </div>
        </div>
      </div>
      -->
    </section>
    <!-- my job
    <div class="columns">
      <div class="column is-two-fifths">
        <figure class="image is-128x128">
          <img src="Imagenes/LogoRecortado.png">
        </figure>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eveniet tenetur illum illo. Dolorum voluptas aperiam corrupti! Neque recusandae, sed doloribus architecto, vel iusto dolorum ea aliquid itaque facilis commodi!</p>
        <a class="button is-link" id="registrate-ya">
          <strong>REGÍSTRATE YA</strong>
        </a>
      </div>
      <div class="column">
        Second column
      </div>
    </div>
    -->


  <!-- Script para la randomización de la imagen del Home -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var images = [
        'Imagenes/Home/img1.jpg',
        'Imagenes/Home/img2.jpg',
        'Imagenes/Home/img3.jpg',
        'Imagenes/Home/img4.jpg',
        'Imagenes/Home/img5.jpg',
        'Imagenes/Home/img6.jpg',
      ];
      var randomImage = images[Math.floor(Math.random() * images.length)];
      document.getElementById('randomImage').src = randomImage;
    });
  </script>
</body>
  
</html>
