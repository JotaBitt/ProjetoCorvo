<?php

$servidor = "localhost";
$username = "root";
$senha = "";
$database = "4ads_v1";


$link = "http://localhost/projetocorvo-dev";
$conn = new mysqli($servidor,$username,$senha,$database);

if ($conn->connect_error) {
    die("Conexao falhou, avise o administrador do sistema");
}


session_start();

// Verificando se o usuário está logado
if(!isset($_SESSION['id_usuario'], $_SESSION['nome_usuario'], $_SESSION['matricula'])) {
    header("Location: ". $link . "/login");
    exit;
}
