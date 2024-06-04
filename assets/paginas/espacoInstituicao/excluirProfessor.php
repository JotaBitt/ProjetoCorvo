<?php

    $cpf = $_POST["cpf"];

    $servidor = "localhost";
    $username = "root";
    $senha = "";
    $database = "4ads";

    $conn = new mysqli($servidor,$username,$senha,$database);
    if ($conn->connect_error) {
       die("Conexao falhou, avise o administrador do sistema");
    }
    $comandoSQL = "DELETE FROM corvo_professor WHERE cpf = '$cpf'";


    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;
?>
