<?php

include_once '../../config.php';

// Verificando o método de requisição
if($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "Método de requisição inválido.";
    exit;
}

try {

    // Verificando se os dados foram informados
    if(!isset($_POST['meet'], $_POST['turma'])) {
        echo 'Link do Google Meet e/ou turma não informada.';
        exit;
    }

    // Atualizando a aula
    $stmt = $conn->prepare("UPDATE corvo_turmas SET linkMeet = :link WHERE id = :turma_id");
    $stmt->bindParam(':link', $_POST['meet']);
    $stmt->bindParam(':turma_id', $_POST['turma']);
    $stmt->execute();

    echo '1';
    exit;


} catch (Exception $e) {
    echo "Erro ao processar requisição.";
    exit;
}