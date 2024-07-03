<?php

include "session.php";

if(!isset($_GET['turma'])) {
    echo 'Turma não informada.';
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

$professor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$professor) {
    echo "Professor não encontrado.";
    exit;
}


$verificarProfessor = ($professor["matricula"] == $_SESSION['matricula']) ? true : false;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "assets/includes/head.php"; ?>
    <title>Controle de Atividades - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "assets/includes/header.php"; ?>

    <main class="container mt-4">
        <?php require_once "assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <h1 class="h3 mb-3">Atividades</h1>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>

                    <?php if($verificarProfessor) {?>
                    <a href="<?= $link ?>/turmas/<?= $_GET["turma"] ?>/atividades/criar" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></a>
                    <?php } ?>
                </div>
            </div>
            <hr class="my-3">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Atividade</th>
                        <th>Data de entrega</th>
                        <?php if($verificarProfessor) { ?>
                        <th>Descrição</th>
                        <th>Nota máxima</th>
                        <?php } ?>
                        <th>Ações</th>
                    </tr>
                <tbody>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE turma = :turma");
                        $stmt->bindParam(":turma", $_GET["turma"]);
                        $stmt->execute();

                        $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if(!$atividades) {
                            echo "<tr><td colspan='5'>Nenhuma atividade cadastrada.</td></tr>";
                        }

                        foreach ($atividades as $atividade) {
                            echo "<tr>";
                            echo "<td>" . $atividade["atividade"] . "</td>";
                            echo "<td>" . ($atividade["data_entrega"] ? date("d/m/Y H:i", strtotime($atividade['data_entrega'])) : "Sem data de entrega") . "</td>";
                            if($verificarProfessor) {
                            echo "<td>" . ($atividade["descricao"] ? $atividade["descricao"] : "-") . "</td>";
                            echo "<td>" . $atividade["nota_maxima"] . "</td>";
                            }
                            echo "<td>";
                                echo "<a href='". $link . "/turmas/" . $_GET["turma"] . "/atividades/" . $atividade["id"] . "/ver' class='btn btn-primary mx-2'><i class='fa-solid fa-eye'></i></a>";
                                if($verificarProfessor) {
                                echo "<a href='" . $link . "/turmas/" . $_GET["turma"] . "/atividades/" . $atividade["id"] . "/editar' class='btn btn-warning mx-2'><i class='fa-solid fa-pen-to-square'></i></a>";
                                echo "<a href='" . $link . "/turmas/" . $_GET["turma"] . "/atividades/" . $atividade["id"] . "/excluir' class='btn btn-danger mx-2'><i class='fa-solid fa-trash'></i></a>";
                                }
                                
                                echo "</td>";
                            } 
                            echo "</tr>";


                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php require_once "assets/includes/footer.php"; ?>

    <?php require_once "assets/includes/scripts.php"; ?>
</body>

</html>