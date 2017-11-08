<?php

  //este script eliminara y marcara como acabado una tarea

  include 'conectar.php';

  if(isset($_POST) && !empty($_POST['action']) && !empty($_POST['id'])) {

    $action = $_POST['action'];
    $idtask = $_POST['id'];

    $db = conectar();

    switch($action) {
      case 1:
        $sql = "UPDATE tareas SET acabado = true, fecha_entrega = CURDATE() WHERE id_tarea = ".$idtask;
        break;
      case 2:
        $sql = "DELETE FROM tareas WHERE id_tarea = ".$idtask;
        break;
    }

    try {
      ejecutar($sql, $db);
    }
    catch(Exception $e) {
      echo $e->getMessage();
      die;
    }

    header('Location: ../tasklist.php');
  }

?>
