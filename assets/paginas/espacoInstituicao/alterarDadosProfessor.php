<?php

    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_nascimento = $_POST["data_nascimento"];

    $servidor = "localhost";
    $username = "root";
    $senha = "";
    $database = "4ads";

    $conn = new mysqli($servidor,$username,$senha,$database);
    if ($conn->connect_error) {
       die("Conexao falhou, avise o administrador do sistema");
    }
    $comandoSQL = "UPDATE corvo_professor SET nome='$nome', matricula='$matricula', email='$email', telefone='$telefone', data_nascimento='$data_nascimento' WHERE cpf='$cpf'";

    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;
?>
