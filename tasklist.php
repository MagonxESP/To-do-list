<?php
  session_start(); // reanudamos la sesion

  // si $_SESSION existe y tiene un usuario guardado
  if(isset($_SESSION) && !empty($_SESSION['usuario'])) {
    $usuarioId = $_SESSION['usuario']['id']; // guardamos en $usuarioId el id del usuario
    $usuario = $_SESSION['usuario']['nombre']; // y guardamos en $usuario el nombre de usuario
  } else {
    // si no existe $_SESSION y no tiene un usuario
    echo '<h1>Deberias iniciar sesion antes de hacer nada</h1>'; // mostramos este error
    die; // y matamos el script justo qui
  }

  include 'lib/conectar.php';
  include 'lib/head.php';
  include 'lib/header.php';

  $db = conectar(); // nos conectamos a la base de datos
  $sql = "SELECT id_tarea, nombre, descripcion, acabado, fecha_creacion, fecha_entrega FROM tareas WHERE usuario = ".$usuarioId." ORDER BY fecha_creacion DESC";

  $resultTareas = ejecutar($sql, $db); // ejecutamos la consulta que nos devuelve las tareas creadas por el usuario
?>

<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h1 class="text-center">Tareas de <?php echo $usuario; ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <a class="btn btn-default" href="addtask.php"><span class="glyphicon glyphicon-plus"></span> Añadir nueva tarea</a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?php if($resultTareas->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Fecha de creacion</th>
              <th>Fecha de entrega</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
            <?php while($row = $resultTareas->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><p class="descripcion"><?php echo $row['descripcion']; ?></p></td>
                <?php $fechaCreacion = new DateTime($row['fecha_creacion']); ?>
                <td><?php echo $fechaCreacion->format('d-m-Y'); ?></td>
                <?php $fechaEntrega = new DateTime($row['fecha_entrega']); ?>
                <td><?php echo $fechaEntrega->format('d-m-Y'); ?></td>
                <?php if($row['acabado'] == false): ?>
                  <td>
                    <form action="lib/doaction.php" method="post">
                      <label>En curso</label>
                      <input type="hidden" name="action" value="1" />
                      <input type="hidden" name="id" value="<?php echo $row['id_tarea']; ?>" />
                      <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-flag"></span> Acabar tarea
                      </button>
                    </form
                  </td>
                <?php else: ?>
                  <td>Terminado</td>
                <?php endif; ?>
                <td class="text-center">
                  <form action="lib/doaction.php" method="post">
                    <input type="hidden" name="action" value="2" />
                    <input type="hidden" name="id" value="<?php echo $row['id_tarea']; ?>" />
                    <button class="btn btn-danger" type="submit">
                      <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </table>
        </div>
      <?php else: ?>
        <h1 class="text-center">No tienes tareas :(</h1>
        <p class="text-center">Prueba a <a href="addtask.php">crear una tarea nueva</a></p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include 'lib/footer.php'; ?>
