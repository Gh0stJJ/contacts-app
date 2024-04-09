<?php
  require_once 'database.php';
  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
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

  //Avoid deleting contacts that do not belong to the user
  $contact = $statement->fetch(PDO::FETCH_ASSOC);
  if ($contact['user_id'] != $_SESSION['user']['id']){
    http_response_code(403);
    die('HTTP 403 Forbidden');
  }
  

  // Prepare the SQL statement

  $statement = $connection->prepare('DELETE FROM contacts WHERE id = :id');
  // Avoid SQL injection
  $statement->bindParam(':id', $id);
  $statement->execute();

  header('Location: /contacts-app/home.php');
