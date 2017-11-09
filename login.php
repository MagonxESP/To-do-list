<?php
  // si existe $_POST y tiene datos
  if(isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['pass'])) {

    include 'lib/conectar.php';

    session_start(); // iniciamos (o reanudamos) la sesion

    $nombreUsuario = htmlspecialchars($_POST['nombre']); // recogemos el nombre de usuario
    $pass = md5(htmlspecialchars($_POST['pass'])); // y la contraseña encriptada en md5

    $sql = "SELECT id_usuario FROM usuarios WHERE nombre = '".$nombreUsuario."'AND password = '".$pass."'";

    $db = conectar(); // nos conectamos a la base de datos
    $result = ejecutar($sql, $db); // ejecutamos la consulta

    // si la consulta devuelve 1 fila es que el usuario existe y su contraseña es valida
    if($result->num_rows == 1) {
      $row = $result->fetch_assoc(); // cargamos los datos que tienen los campos de esta fila y las guardamos en un array

      $_SESSION['usuario']['id'] = $row['id_usuario']; // guardamos en la sesion el id de usuario
      $_SESSION['usuario']['nombre'] = $nombreUsuario; // y el nombre de usuario
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
        <input type="text" name="nombre" required /><br />
        <label>Contraseña</label><br />
        <input type="password" name="pass" required /><br />
        <input class="btn btn-default" type="submit" value="entrar" />
      </form>
    </div>
  </section>
</div>

<?php include 'lib/footer.php'; ?>
