<?php

include "../../../session.php";

if (!isset($_GET["turma"])) {
    echo "Turma não informada.";
    exit;
}

$stmt = $conn->prepare("SELECT *, corvo_turmas.id AS idTurma FROM corvo_turmas JOIN corvo_cursos ON corvo_turmas.siglaCurso = corvo_cursos.siglaCurso WHERE corvo_turmas.id = :turma");
$stmt->bindParam(":turma", $_GET["turma"]);
$stmt->execute();

$turma = $stmt->fetch();

if (!$turma) {
    echo "Turma não encontrada.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :id");
$stmt->bindParam(":id", $turma["professor"]);
$stmt->execute();

$professor = $stmt->fetch();

if (!$professor) {
    echo "Professor não encontrado.";
    exit;
}

$verificarProfessor = ($professor["matricula"] == $_SESSION['matricula']) ? true : false;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../../assets/includes/head.php"; ?>
    <title>Controle de Membros - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>


        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <h2 class="h4">Controle de Membros</h2>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                    <?php if ($verificarProfessor) { ?>
                    <?php } ?>
                </div>
            </div>
            <hr class="my-3">
            <h3 class="h5">Professor</h3>
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-title"><?= $professor['nome'] ?></h5>
                    <p class="card-text"><?= $professor['email'] ?></p>
                </div>
            </div>

            <h3 class="h5">Alunos</h3>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <?php if ($verificarProfessor) { ?>
                        <th>E-mail</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM corvo_usuarios_turma INNER JOIN corvo_usuarios ON corvo_usuarios_turma.matricula = corvo_usuarios.matricula WHERE corvo_usuarios_turma.siglaTurma = :turma");
                    $stmt->bindParam(":turma", $turma["siglaTurma"]);
                    $stmt->execute();

                    $alunos = $stmt->fetchAll();

                    if(!$alunos) {
                        echo "<tr><td colspan='3'>Nenhum aluno encontrado.</td></tr>";
                    }

                    foreach ($alunos as $aluno) {
                        echo "<tr>";
                        echo "<td>{$aluno['nome']}</td>";
                        if ($verificarProfessor) {
                            echo "<td>{$aluno['email']}</td>";
                        }
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php require_once "../../../assets/includes/scripts.php"; ?>

</body>

</html>