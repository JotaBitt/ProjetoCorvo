<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../config.php';


    try {
        
        if(!isset($_POST['turma_id'], $_POST['atividade'], $_POST['descricao'], $_POST['nota_maxima'])) {
            echo 'Turma, atividade, descrição e/ou atividade não informada.';
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO corvo_atividades (descricao, atividade, nota_maxima, turma) VALUES (:descricao, :atividade, :nota_maxima, :turma_id)");
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->bindParam(':atividade', $_POST['atividade']);
        $stmt->bindParam(':nota_maxima', $_POST['nota_maxima']);
        $stmt->bindParam(':turma_id', $_POST['turma_id']);
        $stmt->execute();

        $atividadeID = $conn->lastInsertId();


        // Verificar se foi enviado data de entrega
        if($_POST['data_entrega']) {

            $dataEntrega = DateTime::createFromFormat('Y-m-d', $_POST['data_entrega']);

            // converter pra string
            $dataEntrega = $dataEntrega->format('Y-m-d');

            $stmt = $conn->prepare("UPDATE corvo_atividades SET data_entrega = :data_entrega WHERE id = :atividade_id");
            $stmt->bindParam(':data_entrega', $dataEntrega);
            $stmt->bindParam(':atividade_id', $atividadeID);
            $stmt->execute();
        }


        echo $atividadeID;
        exit;
        
    } catch (Exception $e) {
        echo 'erro';
        exit;
    }

} else {
    echo 'erro';
    exit;
}