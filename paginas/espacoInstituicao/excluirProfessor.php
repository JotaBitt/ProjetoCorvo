<?php

    $matricula = $_POST["matricula"];

    include '../../config_mysqli.php';

    $comandoSQL = "DELETE FROM corvo_professor WHERE matricula = '$matricula'";
    $resultado = $conn->query($comandoSQL);
    $retorno=json_encode($resultado);
    echo $retorno;

    $comandoSQL_deleta_usuario = "DELETE FROM corvo_usuarios WHERE matricula = '$matricula'";
    $resultado = $conn->query($comandoSQL_deleta_usuario);
    $retorno=json_encode($resultado);
    echo $retorno;

    
    $comandoSQL_deleta_usuario_funcao = "DELETE FROM corvo_usuarios_funcao WHERE matricula = '$matricula'";
    $resultado = $conn->query($comandoSQL_deleta_usuario_funcao);
    $retorno=json_encode($resultado);
    echo $retorno;

?>
