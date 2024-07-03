<?php

include 'config.php';

if(!isset($_POST['nome'], $_POST['cnpj'], $_POST['instituicao'])) {
    echo 'Preencha todos os campos.';
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método de requisição inválido.';
    exit;
}

$stmt = $conn->prepare("INSERT INTO `corvo_unidades` (nome, cnpj, instituicao) VALUES (:nome, :cnpj, :instituicao)");
$stmt->bindParam(":nome", $_POST['nome']);
$stmt->bindParam(":cnpj", $_POST['cnpj']);
$stmt->bindParam(":instituicao", $_POST['instituicao']);
$stmt->execute();

$stmt = $conn->prepare("UPDATE corvo_instituicoes SET codigo = NULL WHERE codigo = :instituicao");
$stmt->bindParam(":instituicao", $_POST['instituicao']);
$stmt->execute();

$senhaPadrao = password_hash("1234", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO corvo_usuarios (usuario, nome, senha, status, unidade) VALUES (:usuario, :nome, :senha, 1, 1)");
$stmt->bindParam(":usuario", $_POST['cnpj']);
$stmt->bindParam(":nome", $_POST['nome']);
$stmt->bindParam(":senha", $senhaPadrao);
$stmt->execute();

session_start();

$_SESSION['id_usuario'] = $conn->lastInsertId();
$_SESSION['nome_usuario'] = $_POST['nome'];
$_SESSION['matricula'] = $_POST['cnpj'];


header("Location: ". $link . "/instituicao");
exit;