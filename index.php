<?php
  session_start();
  include 'lib/head.php';
?>

<div class="container">
  <div class="row titulo-principal">
    <div class="col-lg-12 text-center">
      <h1>Todo List</h1>
    </div>
  </div>
  <div class="row text-center inicio-links">
    <?php if(isset($_SESSION) && !empty($_SESSION['usuario']['id']) && !empty($_SESSION['usuario']['nombre'])): ?>
      <div class="col-lg-6">
        <a href="tasklist.php">Ver tareas</a>
      </div>
      <div class="col-lg-6">
        <a href="lib/logout.php">Cerrar Sesion</a>
      </div>
    <?php else: ?>
      <div class="col-lg-6">
        <a href="login.php">Iniciar sesion</a>
      </div>
      <div class="col-lg-6">
        <a href="signup.php">Registrarse</a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'lib/footer.php'; ?>
