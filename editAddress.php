<?php

  require "database.php";
  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
  $id = $_GET["id"]; //id from the address

  $statement = $connection->prepare("SELECT * FROM addresses WHERE id = :id");
  //Equicalente al bindParam
  $statement->execute([":id" => $id]);

  if ($statement->rowCount() == 0) {
    http_response_code(404);
    echo("HTTP 404 NOT FOUND");
    return;
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


  $error = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["street"])) {
      $error = "Street name is required";
    } else if (empty($_POST["city"])) {
      $error = "City field is required";
    }else if (empty($_POST["state"])) {
      $error = "State field is required";
    }else {
      $street = $_POST["street"];
      $city = $_POST["city"];
      $state = $_POST["state"];

      $statement = $connection->prepare("UPDATE addresses SET street = :street, city = :city, state = :state WHERE id = :id");
      $statement->execute([
        ":id" => $id,
        ":street" => $_POST["street"],
        ":city" => $_POST["city"],
        ":state" => $_POST["state"]
      ]);
      //flash message
      $_SESSION['flash'] = ["message" => "Address updated."];
      // Redirect to the addresses page with the contact id
      header("Location: addresses.php?id={$address['contact_id']}");

      return; //Cerramos ejecucion hacia abajo

      header("Location: home.php");
    }
  }
?>

<?php require './partials/header.php'; ?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Edit Address</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="editAddress.php?id=<?= $address['id'] ?>">
              <div class="mb-3 row">
                <label for="street" class="col-md-4 col-form-label text-md-end">Street</label>

                <div class="col-md-6">
                  <input id="street" value=<?= $address['street'] ?>  type="text" class="form-control" name="street" autocomplete="street" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="city" class="col-md-4 col-form-label text-md-end">City</label>

                <div class="col-md-6">
                  <input id="city" value=<?=$address['city'] ?> type="text" class="form-control" name="city" autocomplete="city" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="state" class="col-md-4 col-form-label text-md-end">State</label>

                <div class="col-md-6">
                  <input id="state" value=<?=$address['state'] ?> type="text" class="form-control" name="state" autocomplete="state" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require './partials/footer.php'; ?>
