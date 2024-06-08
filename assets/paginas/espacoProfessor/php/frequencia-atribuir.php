<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../../config.php";

    if(!isset($_POST["turma"], $_POST["aula"], $_POST["frequencia"])) {
        echo "Turma, aula e/ou frequência não informada.";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM `corvo_alunos-turma` WHERE turma = :turma");
    $stmt->bindParam(":turma", $_POST["turma"]);
    $stmt->execute();

    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($alunos as $aluno) {

        $validarPresenca = in_array($aluno["usuario"], $_POST["frequencia"]) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO corvo_presencas (aluno, aula, presenca) VALUES (:aluno, :aula, :presenca)");
        $stmt->bindParam(":aluno", $aluno["id"]);
        $stmt->bindParam(":aula", $_POST["aula"]);
        $stmt->bindParam(":presenca", $validarPresenca);
        $stmt->execute();
    }

    echo "Frequência atribuída com sucesso!";
    exit;

} else {
    echo "Método de requisição inválido.";
    exit;
}