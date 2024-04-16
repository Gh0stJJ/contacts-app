<?php
  require_once 'database.php';
  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
  //Diccionario de datos enviados por la URL usando GET
  $id = $_GET['id']; //id from the address

  //Comprobamos que exista el id
  $statement = $connection->prepare('SELECT * FROM addresses WHERE id = :id');
  // Avoid SQL injection
  $statement->bindParam(':id', $id);
  $statement->execute();
  if ($statement->rowCount() == 0) {
    http_response_code(404);
    die('HTTP 404 address not found');
  }

  //Avoid editing addresses that do not belong to the user
  $address = $statement->fetch(PDO::FETCH_ASSOC);

  $current_user_id = $_SESSION["user"]["id"];

  $statement = $connection->prepare("SELECT addresses.id FROM addresses JOIN contacts ON addresses.contact_id = contacts.id JOIN users ON contacts.user_id = users.id WHERE users.id = :current_user_id AND addresses.id = :id;");
  $statement->execute([":current_user_id" => $current_user_id, ":id" => $id]);
  $check = $statement->fetch(PDO::FETCH_ASSOC);

  //If the query returns null, the address does not belong to the user
  if (!$check) {
    http_response_code(403);
    echo("HTTP 403 FORBIDDEN");
    return;
  }
  
  //Delete the address from the database
  $statement = $connection->prepare('DELETE FROM addresses WHERE id = :id');
  $statement->bindParam(':id', $id);
  $statement->execute();

  // Avoid SQL injection
  $statement->bindParam(':id', $id);
  $statement->execute();

  //flash message
  $_SESSION['flash'] = ["message" => "Address deleted."];
  header("Location: addresses.php?id={$address['contact_id']}");
  return; //Cerramos ejecucion hacia abajo

  header('Location: /contacts-app/home.php');
