<?php
  session_start();
  session_destroy(); //Destruye la sesion del usuario
  header("Location: index.php");
?>
