<?php
  require_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>CAPYCOOKS</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/cards.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="css/main.css"> 

</head>

<body>
  <header>
    <div class="topnav">
      <img src="content/capylogo.png" width="60" height="60" alt="capylogo">
      <a class="title" href="home.php">CAPYCOOKS</a>
      <nav class="menubar">
        <a href="recipes.php">recipes</a>
        <a href="about.php">about</a>
      </nav>
      <button class="menu-btn">☰</button>
    </div>
    <div class="sidebar">
      <a href="recipes.php">Recipes</a>
      <a href="about.php">About</a>
    </div>
  </header>