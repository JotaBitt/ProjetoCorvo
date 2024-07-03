<?php

include_once "config.php";

session_start();

// Verificando se o usuário está logado
if(!isset($_SESSION['id_usuario'], $_SESSION['nome_usuario'], $_SESSION['matricula'])) {
    header("Location: ". $link . "/login");
    exit;
}

