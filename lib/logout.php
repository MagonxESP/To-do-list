<?php
  //este script cierra la sesion
  session_start(); //reanudamos la sesion
  session_destroy(); //y la destruimos

  header('Location: ../index.php'); //redirigimos a la pagina principal
?>
