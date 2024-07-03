<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../config.php';

    if(!isset($_POST['turma_id'], $_POST['atividade_id'])) {
        echo 'Turma e/ou atividade não informada.';
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM corvo_atividades WHERE id = :atividade_id");
    $stmt->bindParam(':atividade_id', $_POST['atividade_id']);
    $stmt->execute();
    
    echo 'Atividade excluída com sucesso!';
    exit;

} else {
    echo 'Método de requisição inválido.';
    exit;
}