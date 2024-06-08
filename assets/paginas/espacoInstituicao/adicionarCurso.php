<?php

    $siglaCursoADC = $_POST["siglaCursoADC"];
    $unidadeADC = $_POST["unidadeADC"];
    $nomeADC = $_POST["nomeADC"];
    $carga_horariaADC = $_POST["carga_horariaADC"];

    $servidor = "localhost";
    $username = "root";
    $senha = "";
    $database = "4ads";

    $conn = new mysqli($servidor,$username,$senha,$database);
    if ($conn->connect_error) {
       die("Conexao falhou, avise o administrador do sistema");
    }
    
    $comandoSQL = "INSERT INTO `corvo_cursos`( `siglaCurso`, `unidade`, `nome`, `carga_horaria`) VALUES ('$siglaCursoADC','$unidadeADC','$nomeADC','$carga_horariaADC')";
    
    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;
?>
