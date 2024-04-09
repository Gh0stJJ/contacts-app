<?php
  
  require_once './database.php';
  $error = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $error = "Name is required";
    } else if (empty($_POST["email"])) {
      $error = "Email is required";
    } else if (empty($_POST["password"])) {
      $error = "Password is required";
    } else {
      $statement = $connection->prepare("SELECT * FROM users WHERE email = :email");
      $statement->bindParam(":email", $_POST["email"]);
      $statement->execute();
      // Check if email already exists
      if ($statement->rowCount() > 0) {
        $error = "Email already exists";
        
      }
      $statement = null;
      // Check if name already exists
      $statement = $connection->prepare("SELECT * FROM users WHERE name = :name");
      $statement->bindParam(":name", $_POST["name"]);
      $statement->execute();
      if ($statement->rowCount() > 0) {
        $error = "Name already exists";

      }
      $statement = null;
      if (!$error) {
        $statement = $connection->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->bindParam(":name", $_POST["name"]);
        $statement->bindParam(":email", $_POST["email"]);
        $statement->bindParam(":password", password_hash($_POST["password"], PASSWORD_BCRYPT));
        $statement->execute();

        // Login the user after registration
        $statement = $connection->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $statement->bindParam(":email", $_POST["email"]);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['user'] = $user; //Coockie
        header("Location: /contacts-app/index.php");
      } 
    }
    
  }

?>


<?php require './partials/header.php'; ?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger"><?= $error ?></p>
              
          <?php endif; ?>

          <form method="post" action="register.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" autocomplete="password" autofocus>
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
