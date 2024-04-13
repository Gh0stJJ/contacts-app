
<?php
  require_once 'database.php';
  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
  $error = null;
  $id = $_GET["id"];

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
      //Address Dictionary
      $address = ["street" => $street, "city" => $city, "state" => $state];
      
      $statement = $connection->prepare("INSERT INTO addresses (contact_id, street, city, state) VALUES ({$id}, :street, :city, :state)");
      $statement->bindParam(":street", $street); // Avoid SQL injection
      $statement->bindParam(":city", $city);
      $statement->bindParam(":state", $state);
      $statement->execute();  // Execute the statement
      //flash message
      $_SESSION['flash'] = ["message" => "Address added."];
      header("Location: /contacts-app/home.php"); // Redirect to the index page
      return;
    }
    

  }

?>


<?php require './partials/header.php'; ?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add address</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger"><?= $error ?></p>
              
          <?php endif; ?>

          <form method="post" action="addAddress.php?id=<?=$id?>">

            <div class="mb-3 row">
              <label for="street" class="col-md-4 col-form-label text-md-end">Street</label>

              <div class="col-md-6">
                <input id="street" type="text" class="form-control" name="street" autocomplete="street" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="city" class="col-md-4 col-form-label text-md-end">City</label>

              <div class="col-md-6">
                <input id="city" type="text" class="form-control" name="city" autocomplete="city" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="state" class="col-md-4 col-form-label text-md-end">State</label>

              <div class="col-md-6">
                <input id="state" type="text" class="form-control" name="state" autocomplete="state" autofocus>
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
