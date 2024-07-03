<?php

    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_nascimento = $_POST["data_nascimento"];

    include '../../config_mysqli.php';
    $comandoSQL = "UPDATE corvo_aluno SET nome='$nome', cpf='$cpf', email='$email', telefone='$telefone', data_nascimento='$data_nascimento' WHERE matricula='$matricula'";
    $resultado = $conn->query($comandoSQL);
    $retorno=json_encode($resultado);
    echo $retorno;

    function dividirNome($nomeCompleto) {
        $nomeCompleto = trim(preg_replace('/\s+/', ' ', $nomeCompleto));
        $partesDoNome = explode(' ', $nomeCompleto);
        return $partesDoNome;
    }

    $partesDoNome = dividirNome($nome);

    $usuario = $partesDoNome[0] . "." . $matricula;

    $comandoSQL_usuario = "UPDATE corvo_usuarios SET  usuario= '$usuario', nome='$nome', email='$email' WHERE matricula='$matricula'";
    $resultado= $conn->query($comandoSQL_usuario);
    $retorno=json_encode($resultado);
    echo $retorno;
?>
