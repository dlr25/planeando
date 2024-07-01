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
  <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css"/>

  <title>Planeando</title>
</head>
<body>

  <div id="app">
    <!-- Pego una navbar de Bulma -->
    <!-- Este NAV es el header de la WEBAPP -->
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">

        <!-- Hacia donde lleva la imagen y la imagen en sí -->
        <a href="index.php">
          <img src="Imagenes/LogoPlaneandoSinLineaHD.png" width="120" height="100" style="margin-left: 5px; margin-right: 10px; margin-top: 10px">
        </a>
    
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>
    
      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" href="new_plan.php">
            Crear Plan
          </a>
    
          <a class="navbar-item" href="search-plan.php">
            Buscar Plan
          </a>
        </div>
    
        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a href="profile.php" class="button is-link is-light">
                <strong>Mi Perfil</strong>
              </a>
              <a class="button is-danger is-light" href="../webapp-back-end/logout-back.php">
                Cerrar Sesión
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
 </body>
 </html>