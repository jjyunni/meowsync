<?php

$host = 'localhost';
$dbname = 'capycooks';
$username = 'root';
$port = 8889;
$password = 'root';

//make variables so easily changeable for access

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password); //connection to db
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //for errors
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

session_start(); //must be used to be able to keep users logged in and stuff
