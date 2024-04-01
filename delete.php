<?php
  require_once 'database.php';
//Diccionario de datos enviados por la URL usando GET
  $id = $_GET['id']; //Obtenemos el id del contacto a eliminar

  //Comprobamos que exista el id
  $statement = $connection->prepare('SELECT * FROM contacts WHERE id = :id');
  // Avoid SQL injection
  $statement->bindParam(':id', $id);
  $statement->execute();
  if ($statement->rowCount() == 0) {
    http_response_code(404);
    die('HTTP 404 Contact not found');
  }



  // Prepare the SQL statement

  $statement = $connection->prepare('DELETE FROM contacts WHERE id = :id');
  // Avoid SQL injection
  $statement->bindParam(':id', $id);
  $statement->execute();

  header('Location: /contacts-app/index.php');
