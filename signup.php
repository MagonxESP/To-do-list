<?php
  // si hay datos en $_POST
  if(isset($_POST) && !empty($_POST['username']) && !empty($_POST['pass']) && !empty($_POST['repass'])) {
    include 'lib/conectar.php';

    $usuario = htmlspecialchars($_POST['username']); // recogemos el nombre de usuarios
    $password = htmlspecialchars($_POST['pass']); // la contraseña
    $repassword = htmlspecialchars($_POST['repass']); // y la contraseña repetida

    try {
      // si las contraseñas son iguales
      if($password == $repassword) {
        $md5password = md5($password); // la encriptamos en md5

        $db = conectar(); // nos conectamos a la base de datos

        $sql = "INSERT INTO usuarios (nombre, password) VALUES ('".$usuario."', '".$md5password."')";

        ejecutar($sql, $db); // e insertamos el usuario nuevo

        // si el usuario se ha insertado a la base de datos (es decir affected_rows devuelve 1)
        if($db->affected_rows == 1) {
          session_start(); // iniciamos (o reiniciamos) la sesion
          $_SESSION['signup_success'] = true;
          header('Location: index.php'); // lo trasladamos a la pantalla de las tareas
        }
      }
    }
    catch(Exception $e) {
      // si se proboca alguna excepcion
      $error = $e->getMessage(); // guardamos el error en una variable
      // El error se mostrara en una alerta de bootstrap
    }
  }

  include 'lib/head.php';
  include 'lib/header.php';
?>

<div class="container">
  <ol class="breadcrumb">
    <li><a href="index.php">Inicio</a></li>
    <li class="active">Registrarse</li>
  </ol>
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="text-center">Registrarse</h1>
      <?php if(isset($error) && !empty($error)): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Oups!</strong> <?php echo $error; ?>
        </div>
      <?php endif; ?>
      <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label>Nombre de usuario</label><br />
        <input type="text" name="username" required /><br />
        <label>Contraseña</label><br />
        <input type="password" name="pass" required /><br />
        <label>Repetir contraseña</label><br />
        <input type="password" name="repass" required /><br />
        <input class="btn btn-default" type="submit" value="Registrarse" />
      </form>
    </div>
  </div>
</div>

<?php include 'lib/footer.php'; ?>
