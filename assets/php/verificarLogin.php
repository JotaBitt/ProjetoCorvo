<?php

include '../../config.php';

if($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location:" . $link ."/login");
    echo "Método de requisição inválido.";
    exit;
}

if(!isset($_POST['usuario'], $_POST['senha'])) {
    header("Location:" . $link ."/login");
    echo "Parâmetros incorretos.";
    exit;
}

// Verificando se o usuário consta no banco de dados
$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE usuario = :usuario");
$stmt->bindParam(":usuario", $_POST['usuario']);
$stmt->execute();
$usuario = $stmt->fetch();

if(!$usuario) {
    header("Location:" . $link ."/login");
    echo "Não existe um usuário com essa identificação.";
    exit;
}

// Verificando se a senha coincide
if(password_verify($_POST['senha'], $usuario['senha'])) {

    // Iniciando a sessão
    session_start();

    // Definindo as variáveis de sessão
    $_SESSION['id_usuario'] = $usuario['id'];
    $_SESSION['nome_usuario'] = $usuario['nome'];
    $_SESSION['matricula'] = $usuario['matricula'];
    
    if($usuario['unidade'] != 0) {
       header("Location: " . $link . "/instituicao");
       exit;
    }

    header("Location:" . $link ."/");
    exit;

} else { 
    header("Location:" . $link ."/login");
    echo "Senha inválida! Tente novamente.";
    exit;
}