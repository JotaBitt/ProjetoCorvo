<?php


// Conexão com o banco de dados
$hostDB = "localhost";
$usuarioDB = "root";
$senhaDB = "";
$bancoDB = "4ads_v1";

$link = "http://localhost/projetocorvo-dev";



// Tentativa de conexão
try {
    $conn = new PDO("mysql:host=$hostDB;dbname=$bancoDB", $usuarioDB, $senhaDB);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    exit;
}
