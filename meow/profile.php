<?php

require_once("header.php");


if (!isset($_SESSION["iduser"])) {
    header("location:about.php");
} // if not logged in go to about.php 



if (isset($_GET["action"]) && $_GET["action"] == "disconnection") {
    // je vide ma session
    unset($_SESSION["iduser"]);
    unset($_SESSION["email"]);
    header("location:about.php"); // redirection sans paramètre
}

?>
<section class='main'>
<div class='aboutus'>
<?php echo "<h1>Welcome back " . $_SESSION["email"] . "!</h1>"; ?>

<br>
<h3><a href="?action=disconnection">Disconnect</a></h3>
<br>
<br>
<p>This website was made by Laura Thiaw-Kine with the help of her parrain who explained techniques and helped fix issues with her code.</p>
<p>Images were provided by Laura Thiaw-Kine and Erwyna Soo.</p>
<p>Recipes were provided by online articles.</p>

</div>
</section>

<?php
require_once("footer.php");
?>