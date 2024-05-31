<?php

include '../../config.php';

if($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "Método de requisição inválido.";
    exit;
}

if(!isset($_POST['usuario'], $_POST['senha'])) {
    echo "Parâmetros incorretos.";
    exit;
}

// Verificando se o usuário consta no banco de dados
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$stmt->bindParam(":usuario", $_POST['usuario']);
$stmt->execute();
$usuario = $stmt->fetch();

if($usuario) {
    echo "Já existe um usuário com esta identificação.";
    exit;
}

$rank = "aluno";

$stmt = $conn->prepare("INSERT INTO usuarios (usuario, rank, senha) VALUES (:usuario, :rank, :senha)");
$stmt->bindParam(":usuario", $_POST['usuario']);
$stmt->bindParam(":rank", $rank);
$stmt->bindParam(":senha", password_hash($_POST['senha'], PASSWORD_DEFAULT));
$stmt->execute();

header("Location: /login");
exit;