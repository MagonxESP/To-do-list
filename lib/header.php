<header>
  <nav class="navbar navbar-inverse" style="border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">TODO LIST</a>
      </div>
      <?php if(isset($_SESSION['usuario'])): ?>
        <div class="nav navbar-nav navbar-right">
          <ul class="nav navbar-nav">
            <li><span class="navbar-text">Hola, <?php echo $_SESSION['usuario']['nombre']; ?>.</span></li>
            <li><a href="lib/logout.php">Cerrar sesion</a></li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </nav>
</header>
