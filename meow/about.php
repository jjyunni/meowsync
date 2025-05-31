<?php

require_once("header.php"); //the header bit separated to have only one file

if (isset($_SESSION["iduser"])) {
  header("location:profile.php");
} // if the user has already logged in the about tab sends us to profile.php tab instead of about.php

if ($_POST) { //if submitted data

  $email = trim($_POST["email"]); //variable for the data submitted
  $password = trim($_POST["password"]);

  if ($email && $password) {

    // je récupère les infos du user en bdd pour cet email
    // SELCT ... WHERE email =...
    // je variabilise avec un fetch
    $stmt = $pdo->query("SELECT * FROM user WHERE email = '$email' "); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    // je vérifie si le mot de passer de mon form et celui en bdd sont les même
    // password_verify
    if ($user && password_verify($password, $user["password"])) {
      $_SESSION["iduser"] = $user["iduser"]; 
      $_SESSION["email"] = $user["email"];
      header("location:profile.php");
    }

    // si c'est le cas
    // j'alimente ma session avec l'id, l'email en sesssion
  }
}

?>

<section class="main">
  <div class="aboutus">
    <p>This website was made by Laura Thiaw-Kine with the help of her parrain who explained techniques and helped fix
      issues with her code.</p>
    <p>Images were provided by Laura Thiaw-Kine and Erwyna Soo.</p>
    <p>Recipes were provided by online articles.</p>
  </div>
  <div class="login-section">

    <h1>Login</h1>

    <?php if (!isset($_SESSION["iduser"])) { ?> 
      <form method="POST" class="loginform">

        <label for="email">Email</label>
        <input type="text" name="email" id="email" placeholder="Email">


        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Mot de passe">

        <input type="submit" value="Connection">

      </form>

    <?php } ?>

    <p>Don't have an account? <a class="title" href="signup.php">Create an Account</a></p> 

  </div>
</section>



<?php
require_once("footer.php"); //the footer bit separated to have only one file
?>