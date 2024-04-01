<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.3/darkly/bootstrap.min.css" 
  integrity="sha512-HDszXqSUU0om4Yj5dZOUNmtwXGWDa5ppESlX98yzbBS+z+3HQ8a/7kcdI1dv+jKq+1V5b01eYurE7+yFjw6Rdg==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer" />
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous">
  </script>
  <!-- Static content -->
  <link rel="stylesheet" href="./static/css/index.css">
  <!-- Quitar las variables de la URL -->
  <?php $uri = parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH); ?>
  <?php if ($uri == "/contacts-app/index.php" || $uri == '/contacts-app/'): ?>
    <script defer src="./static/js/welcome.js"></script>
  <?php endif; ?> 
    
  
  <title>Contacts App</title> 
</head>
<body>
  <?php require 'navbar.php'; ?>

  <main>

  <!-- Content here -->
