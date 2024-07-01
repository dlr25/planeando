<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="index.css" />

  <!-- Añado "FontAwesome" para usar el icono del ojo en la funcionalidad de mostrar la conraseña -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90vh; /* Si no pongo esta altura se ve un rectángulo blanco debajo */
    }

    .login-box {
      width: 400px;
      padding: 20px;
      border: 1px solid #dbdbdb;
      border-radius: 5px;
      background-color: #fff;
      box-shadow: 0 2px 3px rgba(10,10,10,.1);
    }

    .forgot-password {
      margin-top: 10px;
      text-align: right;
    }

    /* No conseguí que funcionase poniéndolo en el inbox (lo tapaba, ni siquiera usando z-index salía al frente)
       así que utilicé la posición relativa para colocarlo donde quería (y por alguna razón usaba top negativo para subir). */
    #mostrarContrasenya{
      cursor: pointer;
      position: absolute;
      right: 10px;
      top: -31px;
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

  <div class="login-container">
    <div class="login-box">
      <h3 class="title is-3">INICIA SESIÓN</h3>

      <form action="../webapp-back-end/login-back.php" method="post">
        <div class="field">
          <label class="label">Correo Electrónico</label>
          <div class="control">
            <input class="input" name="correo" type="email" placeholder="Correo Electrónico">
          </div>
        </div>

        <div class="field">
          <label class="label">Contraseña</label>
          <div class="control">
            <input class="input" name="pass" type="password" id="password" placeholder="Contraseña">
          </div>
          <div class="control" >
            <span id="mostrarContrasenya">
              <i class="fas fa-eye-slash"></i>
            </span>
          </div>
        </div>

<!--
        <div class="forgot-password">
          <a href="#">He olvidado la contraseña</a>
        </div>
-->
        <div class="field">
          <div class="control">
            <button type="submit" class="button is-link">Iniciar Sesión</button>
          </div>
        </div>
      </form>
    </div>
  </div>



  <!-- Código para mostrar contraseña al pulsar el ojo, con un EventListener al clicar -->
  <script>
    document.getElementById('mostrarContrasenya').addEventListener('click', function(e) {
      const passwordInput = document.getElementById('password');
      const toggleIcon = this.getElementsByTagName('i')[0]; // Obtengo el icono dentro del span

      if (passwordInput.type === 'password') {  //Quitamos el icono del ojo y ponemos el del ojo tachado y viceversa.
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      }
    });
  </script>
</body>
</html>