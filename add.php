
<?php
  require_once 'database.php';
  // Check if the user is logged in
  if (!isset($_SESSION['user'])){
    header('Location: login.php');
    return;
  }
  $error = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $error = "Name is required";
    } else if (empty($_POST["phone_number"])) {
      $error = "Phone number is required";
    }else if (!preg_match("/^[0-9]{10}$/", $_POST["phone_number"])) {
      $error = "Phone number must be 10 digits";
    }else {
      $name = $_POST["name"];
      $phoneNumber = $_POST["phone_number"];
      $contact = ["name" => $name, "phone" => $phone_number];
      
      $statement = $connection->prepare("INSERT INTO contacts (name, phone_number) VALUES (:name, :phone_number)");
      $statement->bindParam(":name", $name); // Avoid SQL injection
      $statement->bindParam(":phone_number", $phoneNumber);
      $statement->execute();  // Execute the statement
      
      header("Location: /contacts-app/home.php"); // Redirect to the index page
    }
    

  }

?>


<?php require './partials/header.php'; ?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger"><?= $error ?></p>
              
          <?php endif; ?>

          <form method="post" action="add.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" autocomplete="phone_number" autofocus>
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
