<?php

require_once "config.php";

if(!isset($_GET["turma"])) {
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
    <title>Controle de Frequência - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <h2 class="h4">Controle de Frequência</h2>
                <div>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                    <a href="<?= $link ?>/turmas/<?= $_GET["turma"] ?>/frequencia/registrar" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></a>
                </div>
            </div>
            <hr class="my-3">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <?php

                        $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE turma = :turma");
                        $stmt->bindParam(":turma", $_GET["turma"]);
                        $stmt->execute();

                        $aulas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($aulas as $key => $aula) {
                            echo "<th>Aula " . $key+1 . " - " . date("d/m/Y", strtotime($aula["data_aula"])) . "</th>";
                        }

                        ?>
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

                            foreach($aulas as $aula) {
                                $stmt = $conn->prepare("SELECT * FROM corvo_presencas WHERE aluno = :aluno AND aula = :aula AND presenca = 1");
                                $stmt->bindParam(":aluno", $aluno["usuario"]);
                                $stmt->bindParam(":aula", $aula["id"]);
                                $stmt->execute();

                                $presenca = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($presenca) {
                                    echo "<td><span class='badge bg-danger text-white p-2 px-3'>Falta</span></td>";
                                } else {
                                    echo "<td><span class='badge bg-success text-white p-2 px-3'>Presente</span></td>";
                                }
                            }

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
        </form>
        </div>

    </main>


    <?php require_once "assets/includes/footer.php"; ?>
    <?php require_once "assets/includes/scripts.php"; ?>
</body>

</html>