<?php

    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_nascimento = $_POST["data_nascimento"];
    $data_contratacao = $_POST["data_contratacao"];


    $servidor = "localhost";
    $username = "root";
    $senha = "";
    $database = "4ads";

    $conn = new mysqli($servidor,$username,$senha,$database);
    if ($conn->connect_error) {
       die("Conexao falhou, avise o administrador do sistema");
    }
    $comandoSQL = "INSERT INTO corvo_professor (cpf, nome, matricula, email, telefone, data_nascimento, data_contratacao) VALUES ('$cpf', '$nome', '$matricula', '$email', '$telefone', '$data_nascimento', '$data_contratacao')";

    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;

    echo "   Professor Adicionado ";
?>
