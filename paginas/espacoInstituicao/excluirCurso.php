<?php

    $siglaCurso = $_POST["siglaCurso"];

    include '../../config_mysqli.php';
    $comandoSQL = "DELETE FROM corvo_cursos WHERE siglaCurso = '$siglaCurso'";

    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;
?>
