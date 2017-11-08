<?php
  include 'lib/conectar.php';

  if(isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['fechaEntrega'])) {
    session_start();

    $nombre = htmlspecialchars($_POST['nombre']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $fechaEntrega = $_POST['fechaEntrega'];

    if(isset($_SESSION) && !empty($_SESSION['usuario']['id'])) {
      $usuarioId = $_SESSION['usuario']['id'];

      $sql = "INSERT INTO tareas (nombre, descripcion, fecha_creacion, fecha_entrega, usuario)
              VALUES ('".$nombre."', '".$descripcion."', CURDATE(), '".$fechaEntrega."', ".$usuarioId.")";

      try {
        $db = conectar();
        ejecutar($sql, $db);

        if($db->affected_rows == 1) {
          header('Location: tasklist.php');
        }
      }
      catch(Exception $e) {
        $error = $e->getMessage();
      }
    }
  }

  include 'lib/head.php';
  include 'lib/header.php';
?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="text-center">Añadir una tarea</h1>
      <?php if(isset($error)): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Oups!</strong> <?php echo $error; ?>.
        </div>
      <?php endif; ?>
      <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label>Nombre</label><br />
        <input type="text" name="nombre" required /><br />
        <label>descripcion</label><br />
        <textarea name="descripcion" placeholder="Escribe aqui la descripcion de la tarea..." required></textarea><br />
        <label>Fecha de entrega</label><br />
        <input type="date" name="fechaEntrega" required /><br /><br />
        <input class="btn btn-success" type="submit" value="Crear tarea" />
      </form>
    </div>
  </div>
</div>

<?php include 'lib/footer.php'; ?>
