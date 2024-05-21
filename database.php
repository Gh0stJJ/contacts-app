<?php
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $port = 3307;
  $database = 'contacts_app';

  try {
    $connection = new PDO("mysql:host=$host;port=$port;dbname=$database", $user, $password);
    
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  } catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
  }
?>
