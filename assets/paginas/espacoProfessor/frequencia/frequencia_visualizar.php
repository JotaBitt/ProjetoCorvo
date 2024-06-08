<?php

require_once "../../config.php"; 

if(!isset($_GET["turma"], $_GET['aula'])) {
    echo "Turma e/ou aula não informada.";
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

$stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE id = :aula");
$stmt->bindParam(":aula", $_GET["aula"]);
$stmt->execute();

$aula = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aula) {
    echo "Aula não encontrada.";
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Frequência - Aula #<?= $aula['id'] ?> - Corvo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../turma.css" />
    <link rel="shortcut icon" href="../../assets/img/corvo-logo.ico" type="image/x-icon" />
</head>

<body class="bg-light">
    <?php require_once "../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
            </div>
            <h2 class="h4">Controle de Frequência</h2>
            <p class="text-muted">Data: <strong><?= date("d/m/Y", strtotime($aula['data_aula'])) ?></strong></p>

            <hr class="my-3">
            <form action="javascript:frequencia.atribuir();">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Presença</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM `corvo_alunos-turma` JOIN corvo_usuarios ON corvo_usuarios.id = `corvo_alunos-turma`.usuario WHERE `corvo_alunos-turma`.turma = :turma");
                        $stmt->bindParam(":turma", $_GET["turma"]);
                        $stmt->execute();

                        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($alunos as $aluno) {

                            echo "<tr>";
                            echo "<td>" . $aluno["nome"] . "</td>";

                            // checkbox
                            echo "<td><input type='checkbox' name='frequencia' value='" . $aluno["usuario"] . "'></td>";

                            $stmt = $conn->prepare("SELECT COUNT(*) AS faltas FROM corvo_presencas JOIN corvo_aulas ON corvo_aulas.turma = :turma WHERE aluno = :aluno AND presenca = 0 GROUP BY aluno, turma");
                            $stmt->bindParam(":aluno", $aluno["usuario"]);
                            $stmt->bindParam(":turma", $_GET["turma"]);
                            $stmt->execute();

                            $faltas = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($faltas == false) {
                                $faltas["faltas"] = 0;
                            }

                            echo "<td>" . $faltas["faltas"] . "</td>";


                            echo "</tr>";
                        }

                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        </div>

    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        var frequencia = {
            atribuir: function() {
                var checkboxes = document.querySelectorAll("input[type='checkbox']");

                var frequencia = [];

                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        frequencia.push(checkbox.value);
                    }
                });

                // enviando por ajax jquery
                $.ajax({
                    url: "/projetocorvo-dev/espacoProfessor/php/frequencia-atribuir.php",
                    method: "POST",
                    data: {
                        frequencia: frequencia,
                        turma: <?php echo $_GET["turma"]; ?>,
                        aula: <?php echo $_GET["aula"]; ?>
                    },
                    success: function(data) {
                        alert(data);
                        console.log(data);
                    }
                });
            }
        }
    </script>
</body>

</html>