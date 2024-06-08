<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../config.php';

    if(!isset($_POST['turma_id'], $_POST['atividade_id'], $_POST['descricao'], $_POST['atividade'], $_POST['nota_maxima'])) {
        echo 'Turma, atividade, descrição e/ou atividade não informada.';
        exit;
    }

    $stmt = $conn->prepare("UPDATE corvo_atividades SET descricao = :descricao, atividade = :atividade, nota_maxima = :nota_maxima WHERE id = :atividade_id");
    $stmt->bindParam(':descricao', $_POST['descricao']);
    $stmt->bindParam(':atividade', $_POST['atividade']);
    $stmt->bindParam(':atividade_id', $_POST['atividade_id']);
    $stmt->bindParam(':nota_maxima', $_POST['nota_maxima']);
    $stmt->execute();

    // Verificar se foi enviado data de entrega
    if(isset($_POST['data_entrega'])) {

        $dataEntrega = DateTime::createFromFormat('Y-m-d', $_POST['data_entrega']);

        // converter pra string
        $dataEntrega = $dataEntrega->format('Y-m-d');

        $stmt = $conn->prepare("UPDATE corvo_atividades SET data_entrega = :data_entrega WHERE id = :atividade_id");
        $stmt->bindParam(':data_entrega', $dataEntrega);
        $stmt->bindParam(':atividade_id', $_POST['atividade_id']);
        $stmt->execute();
    }

    echo 'Atividade editada com sucesso!';
    exit;

} else {
    echo 'Método de requisição inválido.';
    exit;
}