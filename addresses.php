<?php
  require_once './database.php';
  session_start();

  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
  $user_id = $_GET['id'];
  //obtenemos las direcciones del usuario seleccionado
  $addresses = $connection->query("SELECT * FROM addresses WHERE contact_id = $user_id");
  $addresses->execute();
  $addresses = $addresses->fetchAll();

?>

<!-- Reutilizacion de HTML usando php -->
<?php require './partials/header.php'; ?>
<div class="container pt-4 p-3">
  <div class="row">
    <!-- Verificamos si existen direccipnes -->
    <?php if (empty($addresses)): ?>
      <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
          No addresses found
          <a href="addAddress.php" class="alert-link>"> Add a new address</a>
        </div>
      </div>
    <?php endif; ?>
    <!-- Nombre del usuario -->
    <?php $contact = $connection->query("SELECT * FROM contacts WHERE id = $user_id")->fetch(); ?>
    <h3 class="card-title text-capitalize">Addresses of <?= $contact["name"]?></h3>
    <!-- Salto de linea -->
    
    <?php foreach ($addresses as $address): ?>
      
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <li class="list-group
                  -item"><?= $address["street"]?>, <?= $address["city"]?>, <?= $address["state"]?></li>
            <a href="editAddress.php?id=<?= $address["id"] ?>" class="btn btn-secondary mb-2">Edit</a>
            <a href="deleteAddress.php?id=<?= $address["id"] ?>" class="btn btn-danger mb-2">Delete</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    
  </div>
</div>

<?php require './partials/footer.php'; ?>
  


