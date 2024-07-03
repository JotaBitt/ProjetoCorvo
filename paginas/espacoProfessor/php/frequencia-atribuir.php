<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../../../config.php";

    if(!isset($_POST["turma"], $_POST["aula"])) {
        echo "Turma e/ou aula não informada.";
        exit;
    }

    if(!isset($_POST["frequencia"])) {
        $_POST['frequencia'] = [];
    }

    $stmt = $conn->prepare("SELECT * FROM `corvo_usuarios_turma` WHERE siglaTurma = :turma");
    $stmt->bindParam(":turma", $_POST["turma"]);
    $stmt->execute();

    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$alunos) {
        echo "Alunos não encontrados.";
        exit;
    }

    foreach ($alunos as $aluno) {

        $validarPresenca = in_array($aluno["matricula"], $_POST["frequencia"]) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO corvo_presencas (aluno, aula, presenca) VALUES (:aluno, :aula, :presenca)");
        $stmt->bindParam(":aluno", $aluno["matricula"]);
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