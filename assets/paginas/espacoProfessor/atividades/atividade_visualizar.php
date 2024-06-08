<?php

require_once "../../config.php";

if (!isset($_GET["turma"], $_GET['atividade'])) {
    echo "Turma e/ou atividade não informada.";
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

$stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE id = :atividade");
$stmt->bindParam(":atividade", $_GET["atividade"]);
$stmt->execute();

$atividade = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$atividade) {
    echo "Atividade não encontrada.";
    exit;
}

// Consultando quantos alunos estão matriculados na turma
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `corvo_alunos-turma` WHERE turma = :turma");
$stmt->bindParam(":turma", $turma["id"]);
$stmt->execute();
$totalAtividadesAtribuidas = $stmt->fetch(PDO::FETCH_ASSOC);

// Consultando quantas atividades foram entregues
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `corvo_atividades-entregas` WHERE atividade = :atividade");
$stmt->bindParam(":atividade", $atividade["id"]);
$stmt->execute();

$totalAtividadesEntregues = $stmt->fetch(PDO::FETCH_ASSOC);



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
    <?php require_once "../../assets/includes/head.php"; ?>
    <title><?= $atividade['atividade'] ?> - Corvo</title>
</head>

<body class="bg-light">
<?php require_once "../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../assets/includes/card.php"; ?>    
        

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h2 class="h4"><?= $atividade['atividade'] ?></h2>
                    <div>
                        <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                        <a class="btn btn-warning mx-1" href="<?= $link . "/turmas/{$turma['id']}/atividades/{$atividade['id']}/editar" ?>"><i class='fa-solid fa-pen-to-square'></i></a>
                        <a class="btn btn-danger mx-1" href="<?= $link . "/turmas/{$turma['id']}/atividades/{$atividade['id']}/excluir" ?>"><i class='fa-solid fa-trash-can'></i></a>
                    </div>
                </div>
            <p class="text-muted"><?= $atividade['descricao'] ?></p>
            <p class="text-muted">Data de entrega:
                <strong><?= ($atividade['data_entrega'] ? date("d/m/Y", strtotime($atividade['data_entrega'])) : "Sem data de entrega") ?></strong>
            </p>

            <div class="row mb-3">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title h2"><?= $totalAtividadesAtribuidas['total'] ?></h5>
                            <p class="card-text">atividades atribuídas</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title h2"><?= $totalAtividadesEntregues['total'] ?></h5>
                            <p class="card-text">atividades entregues</p>
                        </div>
                    </div>
                </div>
            </div>

            
            <hr class="my-3">

            <h3 class="h4 mb-3">Atividades dos alunos</h3>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Nota</th>
                        <th>Entregue em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Alunos da turma
                        $stmt = $conn->prepare("SELECT * FROM `corvo_alunos-turma` JOIN corvo_usuarios ON corvo_usuarios.id = `corvo_alunos-turma`.usuario WHERE `corvo_alunos-turma`.turma = :turma");
                        $stmt->bindParam(":turma", $turma["id"]);
                        $stmt->execute();

                        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($alunos as $aluno) {
                            // Verificando se o aluno entregou a atividade
                            $stmt = $conn->prepare("SELECT * FROM `corvo_atividades-entregas` WHERE atividade = :atividade AND aluno = :aluno");
                            $stmt->bindParam(":atividade", $atividade["id"]);
                            $stmt->bindParam(":aluno", $aluno["usuario"]);
                            $stmt->execute();

                            $entrega = $stmt->fetch(PDO::FETCH_ASSOC);

                            echo "<tr>";
                            echo "<td>{$aluno['nome']}</td>";
                            echo "<td>" . ($entrega ? $entrega['nota'] : "Não avaliado") . "</td>";
                            echo "<td>" . ($entrega ? $entrega['data_entrega'] : "Não entregue") . "</td>";
                            echo "<td>";
                            if ($entrega) {
                                echo "<a href='". $link . "/turmas/{$turma['id']}/atividades/{$atividade['id']}/entregas/{$entrega['id']}' class='btn btn-primary'>Visualizar</a>";

                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php require_once "../../assets/includes/scripts.php"; ?>
    
</body>

</html>