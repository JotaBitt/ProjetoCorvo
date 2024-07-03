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

$verificarProfessor = ($professor["matricula"] == $_SESSION["matricula"]) ? true : false;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "assets/includes/head.php"; ?>
    <title>Controle de Frequência - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <h2 class="h4">Controle de Frequência</h2>
                <?php if(!$verificarProfessor) { ?>
                <p class="text-muted"><strong>Aluno(a): <?= $_SESSION['nome_usuario'] ?></strong></p>
                <?php } ?>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                    <?php if($verificarProfessor) { ?>
                    <a href="<?= $link ?>/turmas/<?= $_GET["turma"] ?>/frequencia/registrar" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></a>
                    <?php } ?>
                </div>
            </div>
            <hr class="my-3">
            <?php if($verificarProfessor) { ?>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <?php

                        // $stmt = $conn->prepare("SELECT COUNT(*) AS contador FROM corvo_presencas WHERE aula IN (SELECT id FROM corvo_aulas WHERE siglaTurma = :turma) GROUP BY aula");

                        $stmt = $conn->prepare("SELECT *, corvo_aulas.id AS idAula FROM `corvo_aulas` JOIN corvo_presencas ON corvo_presencas.aula = corvo_aulas.id WHERE siglaTurma = :turma GROUP BY corvo_presencas.aula");
                        $stmt->bindParam(":turma", $turma["siglaTurma"]);
                        $stmt->execute();

                        $aulas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($aulas as $key => $aula) {
                            echo "<th>" . $aula['nomeAula'] . " - " . date("d/m/Y", strtotime($aula["data_aula"])) . "</th>";
                        }

                        ?>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM `corvo_usuarios_turma` JOIN corvo_usuarios ON corvo_usuarios.matricula = `corvo_usuarios_turma`.matricula WHERE `corvo_usuarios_turma`.siglaTurma = :turma");
                        $stmt->bindParam(":turma", $turma['siglaTurma']);
                        $stmt->execute();

                        $alunos = $stmt->fetchAll();

                        foreach ($alunos as $aluno) {

                            echo "<tr>";
                            echo "<td>" . $aluno["nome"] . "</td>";

                            $falta = 0;

                            foreach($aulas as $aula) {
                                $stmt = $conn->prepare("SELECT * FROM corvo_presencas WHERE aluno = :aluno AND aula = :aula");
                                $stmt->bindParam(":aluno", $aluno["matricula"]);
                                $stmt->bindParam(":aula", $aula["idAula"]);
                                $stmt->execute();

                                $presenca = $stmt->fetch();

                                if (isset($presenca['presenca']) && $presenca["presenca"] == 1) {
                                    echo "<td><span class='badge bg-success text-white p-2 px-3'>Presente</span></td>";
                                    
                                } else {
                                    echo "<td><span class='badge bg-danger text-white p-2 px-3'>Falta</span></td>";
                                    $falta++;
                                }
                            }

                            echo "<td>" . $falta . "</td>";


                            echo "</tr>";
                        }

                    ?>
                </tbody>
            </table>
            <?php } else { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Aulas</th>
                        <th>Presença</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE siglaTurma = :turma AND status = 1");
                    $stmt->bindParam(":turma", $turma["siglaTurma"]);
                    $stmt->execute();

                    $aulas = $stmt->fetchAll();

                    foreach ($aulas as $aula) {

                        $stmt = $conn->prepare("SELECT * FROM corvo_presencas WHERE aula = :aula");
                        $stmt->bindParam(":aula", $aula['id']);
                        $stmt->execute();

                        $presencas = $stmt->fetchAll();

                        if(!$presencas) {
                            echo "<tr>";
                            if($aula["data_aula"] == "0000-00-00") {
                                echo "<td>" . $aula['nomeAula'] . "</td>";
                            } else {
                                echo "<td>" . $aula['nomeAula'] . " - " . date("d/m/Y", strtotime($aula["data_aula"])) . "</td>";
                            }
                            echo "<td><span class='badge bg-light text-secondary p-2 px-3'>Não lecionada</span></td>";
                            echo "</tr>";
                            continue;
                        }

                        $stmt = $conn->prepare("SELECT * FROM corvo_presencas WHERE aluno = :aluno AND aula = :aula");
                        $stmt->bindParam(":aluno", $_SESSION['matricula']);
                        $stmt->bindParam(":aula", $aula['id']);
                        $stmt->execute();

                        $presenca = $stmt->fetch();

                        echo "<tr>";

                        if($aula["data_aula"] == "0000-00-00") {
                            echo "<td>" . $aula['nomeAula'] . "</td>";
                        } else {
                            echo "<td>" . $aula['nomeAula'] . " - " . date("d/m/Y", strtotime($aula["data_aula"])) . "</td>";
                        }
                        echo "<td>" . (isset($presenca['presenca']) && $presenca["presenca"] == 1 ? "<span class='badge bg-success text-white p-2 px-3'>Presente</span>" : "<span class='badge bg-danger text-white p-2 px-3'>Falta</span>" ) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php } ?>
        </form>
        </div>

    </main>


    <?php require_once "assets/includes/footer.php"; ?>
    <?php require_once "assets/includes/scripts.php"; ?>
</body>

</html>