<?php
  // si existe $_POST y tiene datos
  if(isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['pass'])) {
    session_start(); // iniciamos (o reanudamos) la sesion

    include 'lib/conectar.php';

    $nombreUsuario = htmlspecialchars($_POST['nombre']); // recogemos el nombre de usuario
    $pass = md5(htmlspecialchars($_POST['pass'])); // y la contraseña encriptada en md5

    $sql = "SELECT id_usuario FROM usuarios WHERE nombre = ? AND password = ?";

    $query = $db->prepare($sql); // preparamos la query
    $query->bind_param("ss", $nombreUsuario, $pass); // le pasamos los parametros
    $query->execute(); // ejecutamos la query
    $query->store_result(); // guardamos los resultados

    // si la consulta devuelve 1 fila es que el usuario existe y su contraseña es valida
    if($query->num_rows == 1) {
      $query->bind_result($idUsuario); // cargamos el resultado en dos variables
      $query->fetch();

      $_SESSION['usuario']['id'] = $idUsuario; // guardamos en la sesion el id de usuario
      $_SESSION['usuario']['nombre'] = $nombreUsuario; // y el nombre de usuario

      if(isset($_POST['recordar']) && $_POST['recordar'] == 1) {
        // si se ha marcado la casilla de recordar la sesion
        setCookie("password", $_POST['pass'], time()+(60*60*24*30)); //guardamos la id del usuario
        setCookie("nombreUsuario", $nombreUsuario, time()+(60*60*24*30)); // guardamos el nombre de usuario
      }

      header('Location: tasklist.php'); // lo trasladamos a la pantalla de tareas
    } else {
      // si no existe el usuario
      $error = true; // ponemos true esta variable para mostrar un error
    }
  }

  include 'lib/head.php';
  include 'lib/header.php';
?>

<div class="container">
  <ol class="breadcrumb">
    <li><a href="index.php">Inicio</a></li>
    <li class="active">Iniciar sesion</li>
  </ol>
  <section class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="text-center">Iniciar Sesion</h1>
      <?php if(isset($error) && $error): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Oups!</strong> Nombre de usuario o contraseña incorrectos!
        </div>
      <?php endif; ?>
      <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label>Nombre</label><br />
        <?php if(isset($_COOKIE) && !empty($_COOKIE['nombreUsuario'])): ?>
          <input type="text" name="nombre" value="<?php echo $_COOKIE['nombreUsuario']; ?>" required /><br />
        <?php else: ?>
          <input type="text" name="nombre" required /><br />
        <?php endif; ?>
        <label>Contraseña</label><br />
        <?php if(isset($_COOKIE) && !empty($_COOKIE['password'])): ?>
          <input type="password" name="pass" value="<?php echo $_COOKIE['password']; ?>" required /><br />
        <?php else: ?>
          <input type="password" name="pass" required /><br />
        <?php endif; ?>
        <label>Recordarme</label>
        <input style="width: 20px; height: 20px;" type="checkbox" name="recordar" value="1" /><br />
        <input class="btn btn-default" type="submit" value="entrar" />
      </form>
    </div>
  </section>
</div>

<?php include 'lib/footer.php'; ?>
