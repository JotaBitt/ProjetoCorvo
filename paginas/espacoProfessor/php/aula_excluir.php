<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../config.php';

    if(!isset($_POST['aula_id'], $_POST['turma_id'])) {
        echo 'Aula não informada.';
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM corvo_aulas WHERE id = :aula_id");
    $stmt->bindParam(':aula_id', $_POST['aula_id']);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM corvo_presencas WHERE aula = :aula_id");
    $stmt->bindParam(':aula_id', $_POST['aula_id']);
    $stmt->execute();
    
    echo 'Aula excluída com sucesso!';
    exit;

} else {
    echo 'Método de requisição inválido.';
    exit;
}