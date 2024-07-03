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
    <title>Controle de Notas - <?= $turma['nome'] ?> - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <h2 class="h4">Controle de Notas</h2>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                </div>
            </div>
            <hr class="my-3">
            <?php if($verificarProfessor) { ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <th>Nome</th>
                    <?php

                    $stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE turma = :turma");
                    $stmt->bindParam(":turma", $_GET["turma"]);
                    $stmt->execute();

                    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($atividades as $atividade) {
                        echo "<th>" . $atividade["atividade"] . "</th>";
                    }
                    ?>
                    <th>Média</th>
                </thead>
                <tbody>
                    <?php

                    $stmt = $conn->prepare("SELECT * FROM corvo_usuarios_turma WHERE siglaTurma = :turma");
                    $stmt->bindParam(":turma", $turma['siglaTurma']);
                    $stmt->execute();

                    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($alunos as $aluno) {
                        echo "<tr>";
                        echo "<td>" . $aluno["nome"] . "</td>";

                        $soma = 0;
                        $qtd = 0;

                        foreach ($atividades as $atividade) {
                            $stmt = $conn->prepare("SELECT * FROM corvo_atividades JOIN corvo_atividades_entregas ON corvo_atividades.id = corvo_atividades_entregas.atividade WHERE corvo_atividades_entregas.aluno = :aluno AND corvo_atividades.id = :atividade");

                            $stmt->bindParam(":aluno", $aluno['matricula']);
                            $stmt->bindParam(":atividade", $atividade['id']);
                            
                            $stmt->execute();

                            $nota = $stmt->fetch();

                            if(isset($nota['nota'])) {
                                echo "<td>" . $nota['nota'] . "</td>";
                                $soma += $nota['nota'];
                                $qtd++;

                            } else {
                                echo "<td>---</td>";
                                $qtd++;
                            }
                        }

                        if($qtd > 0) {
                            echo "<td>" . number_format($soma / $qtd, 2) . "</td>";
                        } else {
                            echo "<td>Não lançado.</td>";
                        }

                        echo "</tr>";
                    }



                    ?>
                </tbody>
            </table>
            <?php } else { ?>
                <table class="table table-hover table-bordered">
                <thead>
                    <th>Atividades</th>
                    <th>Nota</th>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE turma = :turma");
                    $stmt->bindParam(":turma", $_GET["turma"]);
                    $stmt->execute();

                    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if($atividades) { 
                        foreach ($atividades as $atividade) {
                            // $stmt = $conn->prepare("SELECT * FROM corvo_notas WHERE aluno = :aluno AND atividade = :atividade AND turma = :turma");
                            // $stmt->bindParam(":aluno", $_SESSION['matricula']);
                            // $stmt->bindParam(":atividade", $atividade["id"]);
                            // $stmt->bindParam(":turma", $_GET["turma"]);
                            // $stmt->execute();

                            $stmt = $conn->prepare("SELECT * FROM corvo_atividades JOIN corvo_atividades_entregas ON corvo_atividades.id = corvo_atividades_entregas.atividade WHERE corvo_atividades_entregas.aluno = :aluno AND corvo_atividades.id = :atividade");

                            $stmt->bindParam(":aluno", $_SESSION['matricula']);
                            $stmt->bindParam(":atividade", $atividade['id']);
                            
                            $stmt->execute();
    
                            $nota = $stmt->fetch();
    
                            echo "<tr>";
                            echo "<td>" . $atividade["atividade"] . "</td>";
                            if(isset($nota['nota'])) {
                                echo "<td>" . $nota['nota'] . "</td>";
                            } else {
                                echo "<td>Nota não lançada.</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='2'>Nenhuma atividade lançada.</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </main>

    <?php require_once "assets/includes/footer.php"; ?>
    <?php require_once "assets/includes/scripts.php"; ?>
</body>

</html>