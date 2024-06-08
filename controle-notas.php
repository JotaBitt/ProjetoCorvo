<?php

require_once "config.php";

if (!isset($_GET["turma"])) {
    echo "Turma não informada.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM corvo_cursos JOIN corvo_turmas ON corvo_turmas.curso = corvo_cursos.id WHERE corvo_turmas.id = :turma");
$stmt->bindParam(":turma", $_GET["turma"]);
$stmt->execute();

$turma = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$turma) {
    echo "Turma não encontrada.";
    exit;
}


$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE id = :id");
$stmt->bindParam(":id", $turma["professor"]);
$stmt->execute();

$professor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$professor) {
    echo "Professor não encontrado.";
    exit;
}

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
                <h1 class="h3 mb-3">Controle de Notas</h1>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                </div>
            </div>
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
                    $stmt = $conn->prepare("SELECT * FROM `corvo_alunos-turma` JOIN corvo_usuarios ON corvo_usuarios.id = `corvo_alunos-turma`.usuario WHERE `corvo_alunos-turma`.turma = :turma");
                    $stmt->bindParam(":turma", $_GET["turma"]);
                    $stmt->execute();

                    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($alunos as $aluno) {

                        $imgAluno = "data:image/png;base64," . base64_encode($aluno['foto']);
                        echo "<tr>";
                        echo "<td>";
                        echo "<img src='" . $imgAluno . "' class='rounded-circle mr-3' width='30' height='30' alt=''>";
                        echo $aluno["nome"] . "</td>";

                        $valorAtividade = 0;
                        $quantidadeAtividades = 1;

                        foreach ($atividades as $atividade) {
                            $stmt = $conn->prepare("SELECT * FROM corvo_notas WHERE aluno = :aluno AND atividade = :atividade AND turma = :turma");
                            $stmt->bindParam(":aluno", $aluno["usuario"]);
                            $stmt->bindParam(":atividade", $atividade["id"]);
                            $stmt->bindParam(":turma", $_GET["turma"]);
                            $stmt->execute();

                            $nota = $stmt->fetch(PDO::FETCH_ASSOC);

                            if (!$nota) {
                                echo "<td>Nota não lançada.</td>";
                                continue;
                            }

                            $valorAtividade += $nota["nota"];
                            $quantidadeAtividades++;
                        }

                        $media = $valorAtividade / $quantidadeAtividades;

                        echo "<td>" . $media . "</td>";

                        echo "</tr>";
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