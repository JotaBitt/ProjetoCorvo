<?php

    $siglaCurso = $_POST["siglaCurso"];

    $servidor = "localhost";
    $username = "root";
    $senha = "";
    $database = "4ads";

    $conn = new mysqli($servidor,$username,$senha,$database);
    if ($conn->connect_error) {
       die("Conexao falhou, avise o administrador do sistema");
    }
    $comandoSQL = "DELETE FROM corvo_cursos WHERE siglaCurso = '$siglaCurso'";

    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;
?>
