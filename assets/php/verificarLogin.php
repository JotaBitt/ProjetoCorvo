<?php

include '../../config.php';

if($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /login");
    echo "Método de requisição inválido.";
    exit;
}

if(!isset($_POST['usuario'], $_POST['senha'])) {
    header("Location: /login");
    echo "Parâmetros incorretos.";
    exit;
}

// Verificando se o usuário consta no banco de dados
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$stmt->bindParam(":usuario", $_POST['usuario']);
$stmt->execute();
$usuario = $stmt->fetch();

if(!$usuario) {
    header("Location: /login");
    echo "Não existe um usuário com essa identificação.";
    exit;
}

// Verificando se a senha coincide
if(password_verify($_POST['senha'], $usuario['senha'])) {

    session_start();
    $_SESSION['nome_usuario'] = $usuario['usuario'];
    $_SESSION['rank'] = $usuario['rank'];

    header("Location: /");
    exit;

} else { 
    header("Location: /login");
    echo "Senha inválida! Tente novamente.";
    exit;
}