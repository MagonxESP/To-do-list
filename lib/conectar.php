<?php

function conectar() {
  $db = new mysqli("localhost", "root", "root", "todo_list");
  return $db;
}

function ejecutar(string $query, mysqli $db) {
  $result = $db->query($query);

  if(!$result) {
    throw new Exception($db->error);
    return false;
  }

  return $result;
}


?>
