<?php
  
  require_once './database.php';
  $error = null;
  

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
      $error = "Email is required";
    }elseif (!str_contains($_POST["email"], "@")) {
      $error = "Invalid email format";
    }else if (empty($_POST["password"])) {
      $error = "Password is required";
    } else {
      $statement = $connection->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
      $statement->bindParam(":email", $_POST["email"]);
      $statement->execute();
      // Check if the credentials are valid
      if ($statement->rowCount() == 0) {
        $error = "Invalid email or password";
      }else{
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        // Check if the password is correct
        if(!password_verify($_POST["password"], $user["password"])){
          $error = "Invalid credentials";
        }else{
          session_start(); //Si tu no tienes una sesion asociada a tu navegador, esta funcion crea una sesion en el servidor
          unset($user["password"]); //Elimina la contraseña del usuario (por seguridad)
          $_SESSION["user"] = $user; //Coockie
          
          header("Location: home.php");
        }
      }
      
    }
    
  }

?>


<?php require './partials/header.php'; ?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger"><?= $error ?></p>
              
          <?php endif; ?>

          <form method="post" action="login.php">
            

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
