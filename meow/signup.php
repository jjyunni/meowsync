<?php

require_once("header.php");
  
if($_POST){ 
  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "INSERT INTO user (email, password) VALUES(:email, :password)";
  //sql code to insert values
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT) //to hash passwords
  ]);

    echo "<section class='main'>";
    echo "<div class='aboutus'>";
    echo "<h1>You're now signed up. <a href='about.php'>Go back to login page</a></h1>";
    echo "</div>";
    echo "</section>";

} else {
?>

  <section class="main">
    <div class="login-section">
      <form method="POST" class="loginform">

        <label for="email">Email</label>
        <input type="text" name="email" id="email" placeholder="Email">


        <label for="password">Password</label>
        <input type="text" name="password" id="password" placeholder="Password">

        <input type="submit" value="Sign up">
      </form>
    </div>
  </section>
  
  <?php

}
  require_once("footer.php");
?>








