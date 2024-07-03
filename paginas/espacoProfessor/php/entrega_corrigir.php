<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../config.php';


    /*

    formData.append("nota", $("#nota").val());
                    formData.append("entrega", <?= $_GET['entrega'] ?>);
                    formData.append("atividade", <?= $_GET['atividade'] ?>);
                    formData.append("aluno", <?= $aluno['matricula'] ?>);*

                    */
    try {

        if(!isset($_POST['nota'], $_POST['entrega'], $_POST['atividade'], $_POST['aluno'])) {
            echo 'Nota, entrega, atividade e/ou aluno não informada.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE id = :atividade");
        $stmt->bindParam(':atividade', $_POST['atividade']);
        $stmt->execute();

        $atividade = $stmt->fetch();

        if(!$atividade) {
            echo 'Atividade não encontrada.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :aluno");
        $stmt->bindParam(':aluno', $_POST['aluno']);
        $stmt->execute();

        $aluno = $stmt->fetch();

        if(!$aluno) {
            echo 'Aluno não encontrado.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_atividades_entregas WHERE id = :entrega");
        $stmt->bindParam(':entrega', $_POST['entrega']);
        $stmt->execute();

        $entrega = $stmt->fetch();

        if(!$entrega) {
            echo 'Entrega não encontrada.';
            exit;
        }

        $stmt = $conn->prepare("UPDATE corvo_atividades_entregas SET nota = :nota WHERE id = :entrega");
        $stmt->bindParam(':nota', $_POST['nota']);
        $stmt->bindParam(':entrega', $_POST['entrega']);
        $stmt->execute();

        echo 'Nota atribuída com sucesso!';
        exit;
        
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
        exit;
    }

} else {
    echo 'Método de requisição inválido.';
    exit;
}