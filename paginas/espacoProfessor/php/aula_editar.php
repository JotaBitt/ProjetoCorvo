<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../config.php';

    if(!isset($_POST['aula'], $_POST['conteudo'], $_POST['data_aula'], $_POST['turma_id'])) {
        var_dump($_POST);
        echo 'Aula, conteúdo, data da aula e/ou turma não informada.';
        exit;
    }

    $stmt = $conn->prepare("UPDATE corvo_aulas SET nomeAula = :aula, conteudo = :conteudo, data_aula = :data_aula, status = true WHERE id = :aula_id");
    $stmt->bindParam(':aula', $_POST['aula']);
    $stmt->bindParam(':conteudo', $_POST['conteudo']);
    $stmt->bindParam(':data_aula', $_POST['data_aula']);
    $stmt->bindParam(':aula_id', $_POST['aula_id']);
    $stmt->execute();

    echo 'Aula editada com sucesso!';
    exit;

} else {
    echo 'Método de requisição inválido.';
    exit;
}