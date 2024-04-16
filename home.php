<?php
  require_once './database.php';
  session_start();

  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
  //obtenemos los contactos del usuario logeado
  $contacts = $connection->query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']} ORDER BY name ASC");
  $contacts->execute();


?>

<!-- Reutilizacion de HTML usando php -->
<?php require './partials/header.php'; ?>
<div class="container pt-4 p-3">
  <div class="row">
    <?php if ($contacts-> rowCount() == 0): ?>
      <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
          No contacts found
          <a href="add.php" class="alert-link>"> Add a new contact</a>
        </div>
      </div>
    <?php endif; ?>
    <?php foreach ($contacts as $contact): ?>
      <!-- Para cada contacto obtenemos sus direcciones -->
      <?php
        $addresses = $connection->query("SELECT * FROM addresses WHERE contact_id = {$contact['id']}");
        $addresses->execute();
      ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contact["name"]?></h3>
            <p class="m-2"><?= $contact["phone_number"]?></p>
            <?php if ($addresses->rowCount() > 0): ?>
              <p class="font-weight-bold">Addresses:</p>
              <ul class="list-group">
                <?php foreach ($addresses as $address): ?>
                  <li class="list-group
                  -item"><?= $address["street"]?>, <?= $address["city"]?>, <?= $address["state"]?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <a href="addresses.php?id=<?= $contact["id"] ?>" class="btn btn-success mb-2">Show Addresses</a>
            <a href="addAddress.php?id=<?= $contact["id"] ?>" class="btn btn-success mb-2">Add Address</a>
            <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
            <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
            
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    
  </div>
</div>

<?php require './partials/footer.php'; ?>
  


