<?php

$servidor = "localhost";
$username = "root";
$senha = "";
$database = "4ads";

try {
      $conn = new PDO("mysql:host=$servidor;dbname=$database", $username, $senha);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
   echo "ERRO! " . $e->getMessage();
   exit;
}