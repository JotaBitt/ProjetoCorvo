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
    <?php require_once "assets/includes/head.php"; ?>
    <title>Controle de Aulas - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "assets/includes/header.php"; ?>

    <main class="container mt-4">
        <?php require_once "assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <h1 class="h3 mb-3">Controle de Aulas</h1>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>

                    <?php if(0 == 1) {?>
                    <a href="<?= $link ?>/turmas/<?= $_GET["turma"] ?>/aulas/criar" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></a>
                    <?php } ?>
                </div>
            </div>
            <hr class="my-3">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Aula</th>
                        <th>Data da aula</th>
                        <th>Ações</th>
                    </tr>
                <tbody>
                    <?php

                    if($verificarProfessor) {

                        $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE siglaTurma = :turma");
                        $stmt->bindParam(":turma", $turma["siglaTurma"]);
                        $stmt->execute();
                    } else {
                        $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE siglaTurma = :turma AND status = 1");
                        $stmt->bindParam(":turma", $turma["siglaTurma"]);
                        $stmt->execute();
                    }
                    

                    $aulas = $stmt->fetchAll();

                    if($aulas) {
                        foreach($aulas as $aula) {
                            echo "<tr>";
                            echo "<td>" . $aula['nomeAula'] . "</td>";
                            if($aula['data_aula'] == "0000-00-00") {
                                echo "<td>---</td>";
                            } else {
                                echo "<td>" . date('d/m/Y', strtotime($aula['data_aula'])) . "</td>";
                            }
                            echo "<td>";
                            echo "<a href='" . $link . "/turmas/" . $_GET["turma"] . "/aulas/" . $aula['id'] . "' class='btn btn-primary mx-2'><i class='fa-solid fa-eye'></i></a>";
                            if($verificarProfessor) {
                                echo "<a href='" . $link . "/turmas/" . $_GET["turma"] . "/aulas/" . $aula['id'] . "/editar' class='btn btn-warning mx-2'><i class='fa-solid fa-pen-to-square'></i></a>";
                                echo "<a href='" . $link . "/turmas/" . $_GET["turma"] . "/aulas/" . $aula['id'] . "/excluir' class='btn btn-danger mx-2'><i class='fa-solid fa-trash-can'></i></a>";
                            }
                             echo "</td>";
                             echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Nenhuma aula cadastrada.</td></tr>";
                    }


                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php require_once "assets/includes/footer.php"; ?>

    <?php require_once "assets/includes/scripts.php"; ?>
</body>

</html>