<?php
  include 'lib/conectar.php';
  session_start();

  if(isset($_POST) && !empty($_POST['nombre']) && !empty($_POST['descripcion']) && !empty($_POST['fechaEntrega'])) {
    // si $_POST existe y no estan vacios los campos
    $nombre = htmlspecialchars($_POST['nombre']); // recogemos el nombre
    $descripcion = htmlspecialchars($_POST['descripcion']); // recogemos la descripcion
    $fechaEntrega = $_POST['fechaEntrega']; // recogemos la fecha de entrega

    if(isset($_SESSION) && !empty($_SESSION['usuario']['id'])) {
      // si $_SESSIOn existe y no esta vacio
      $usuarioId = $_SESSION['usuario']['id']; // recogemos el id del usuario

      $sql = "INSERT INTO tareas (nombre, descripcion, fecha_creacion, fecha_entrega, usuario) VALUES (?, ?, CURDATE(), ?, ?)"; // sentencia para insertar la tarea
      // un '?' es un parametro
      try {
        $query = $db->prepare($sql); // preparamos la query
        $query->bind_param("sssi", $nombre, $descripcion, $fechaEntrega, $usuarioId); // le damos los valores que vamos a insertar
        $query->execute(); // ejecuta la query

        if($query->affected_rows == 1) {
          // si se ha insertado una fila
          header('Location: tasklist.php'); // vamos a la lista de tareas
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
  <ol class="breadcrumb">
    <li><a href="index.php">Inicio</a></li>
    <li><a href="tasklist.php">Tareas de <?php echo $_SESSION['usuario']['nombre']; ?></a></li>
    <li class="active">Añadir una tarea</li>
  </ol>
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
