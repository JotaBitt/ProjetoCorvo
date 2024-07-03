<?php

    $cpf = $_POST["cpf"];
    $nomeCompleto = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_nascimento = $_POST["data_nascimento"];

    include '../../config_mysqli.php';

    $comandoSQL = "INSERT INTO `corvo_usuarios`(`id`, `usuario`, `nome`, `matricula`, `email`, `senha`, `foto`, `status`) VALUES ('','','','','','','','')";

    $resultado = $conn->query($comandoSQL);

    $retorno=json_encode($resultado);
    echo $retorno;

    $partesDoNome = dividirNome($nomeCompleto);

    $primeiroNome = $partesDoNome[0];
    
    // dados a serem inseridos

    $ano = date("Y");
    $idUnidade = 1; // UNiDADE ????????????
    $idUsuario = $conn->insert_id;
    
    $nomeUsuario = gerarNomeUsuario($primeiroNome, $ano, $idUnidade, $idUsuario);

    function gerarNomeUsuario($nome, $ano, $idUnidade, $idUsuario) {
        // Limpar o nome (remover espaços e caracteres especiais)
        $nome = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($nome));
        
        // Formatar o ID do ano
        $idAno = str_pad($ano, 4, '0', STR_PAD_LEFT);
        
        // Formatar o ID da unidade
        $idUnidade = str_pad($idUnidade, 3, '0', STR_PAD_LEFT);
        
        // Formatar o ID do usuário
        $idUsuario = str_pad($idUsuario, 6, '0', STR_PAD_LEFT);
        
        // Concatenar os valores para formar a matrícula
        $nomeUsuario = "$nome.$idAno$idUnidade$idUsuario";
        
        return $nomeUsuario;
    }

    $matriculaString = explode('.', $nomeUsuario);

    $matricula = $matriculaString[1];

    function dividirNome($nomeCompleto) {
        $nomeCompleto = trim(preg_replace('/\s+/', ' ', $nomeCompleto));
        $partesDoNome = explode(' ', $nomeCompleto);
        return $partesDoNome;
    }

    
    $comandoSQL_insert_aluno= "INSERT INTO `corvo_aluno`(`id`, `nome`, `email`, `cpf`, `telefone`, `matricula`, `data_nascimento`) VALUES ('$idUsuario','$nomeCompleto','$email','$cpf','$telefone','$matricula','$data_nascimento')";
    
    $resultado = $conn->query($comandoSQL_insert_aluno);
    $retorno=json_encode($resultado);
    echo $retorno;

    $senha = password_hash('1234', PASSWORD_DEFAULT);

    $comandoSQL_update = "UPDATE `corvo_usuarios` SET `usuario`='$nomeUsuario',`nome`='$nomeCompleto',`matricula`='$matricula',`email`='$email',`senha`='$senha',`foto`='',`status`='1' WHERE id='$idUsuario'";

    $resultado = $conn->query($comandoSQL_update);
    $retorno=json_encode($resultado);
    echo $retorno;

    $comandoSQL_insert_usuario_funcao = "INSERT INTO `corvo_usuarios_funcao`(`id`, `matricula`, `aluno`, `professor`, `adm`) VALUES ('$idUsuario','$matricula','1','0','0')";
    $resultado = $conn->query($comandoSQL_insert_usuario_funcao);
    $retorno=json_encode($resultado);
    echo $retorno;

?>
