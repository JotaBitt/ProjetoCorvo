<?php

include "../../../session.php";

if (!isset($_GET["turma"], $_GET['atividade'])) {
    echo "Turma e/ou atividade não informada.";
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

$stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE id = :atividade");
$stmt->bindParam(":atividade", $_GET["atividade"]);
$stmt->execute();

$atividade = $stmt->fetch();

if (!$atividade) {
    echo "Atividade não encontrada.";
    exit;
}

// Consultando quantos alunos estão matriculados na turma
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `corvo_usuarios_turma` INNER JOIN `corvo_turmas` ON corvo_turmas.siglaTurma = corvo_usuarios_turma.siglaTurma WHERE corvo_usuarios_turma.siglaTurma = :turma AND `corvo_usuarios_turma`.matricula != :professor");
$stmt->bindParam(":turma", $turma["siglaTurma"]);
$stmt->bindParam(":professor", $turma["professor"]);
$stmt->execute();
$totalAtividadesAtribuidas = $stmt->fetch();

// Consultando quantas atividades foram entregues
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM `corvo_atividades_entregas` WHERE atividade = :atividade");
$stmt->bindParam(":atividade", $atividade["id"]);
$stmt->execute();

$totalAtividadesEntregues = $stmt->fetch();



$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :id");
$stmt->bindParam(":id", $turma["professor"]);
$stmt->execute();

$professor = $stmt->fetch();

if (!$professor) {
    echo "Professor não encontrado.";
    exit;
}

$verificarProfessor = ($professor["matricula"] == $_SESSION['matricula']) ? true : false;

if(!$verificarProfessor) {
    $stmt = $conn->prepare("SELECT * FROM corvo_atividades_entregas WHERE atividade = :atividade AND aluno = :aluno");
    $stmt->bindParam(":atividade", $atividade['id']);
    $stmt->bindParam(":aluno", $_SESSION['matricula']);
    $stmt->execute();

    $entrega = $stmt->fetch();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../../assets/includes/head.php"; ?>
    <title><?= $atividade['atividade'] ?> - Corvo</title>
</head>

<body class="bg-light">
<?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    
        

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h2 class="h4"><?= $atividade['atividade'] ?></h2>
                    <div>
                        <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                        <?php if($verificarProfessor) {?>
                        <a class="btn btn-warning mx-1" href="<?= $link . "/turmas/{$turma['idTurma']}/atividades/{$atividade['id']}/editar" ?>"><i class='fa-solid fa-pen-to-square'></i></a>
                        <a class="btn btn-danger mx-1" href="<?= $link . "/turmas/{$turma['idTurma']}/atividades/{$atividade['id']}/excluir" ?>"><i class='fa-solid fa-trash-can'></i></a>
                        <?php } ?>
                    </div>
                </div>
            <p class="text-muted"><?= $atividade['descricao'] ?></p>
            <p class="text-muted">Data de entrega:
                <strong><?= ($atividade['data_entrega'] ? date("d/m/Y", strtotime($atividade['data_entrega'])) : "Sem data de entrega") ?></strong>
            </p>
            <?php

            $stmt = $conn->prepare("SELECT * FROM corvo_atividades_arquivos WHERE atividade = :atividade");
            $stmt->bindParam(":atividade", $atividade['id']);
            $stmt->execute();

            $arquivos = $stmt->fetchAll();

            if ($arquivos) {
                echo "<h3 class='h5 mt-4'>Arquivos</h3>";
                echo "<div class='list-group'>";
                foreach ($arquivos as $arquivo) {
                    
                    include '../../../vendor/autoload.php';

                    // Identificando o tipo do arquivo do Google Drive
                    $client = new Google\Client();

                    $client->setAuthConfig('../../../credenciais.json');

                    $client->addScope("https://www.googleapis.com/auth/drive");

                    $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST']);

                    $client->setAccessType('offline');

                    $client->setIncludeGrantedScopes(true);

                    $driveService = new Google_Service_Drive($client);

                    $file = $driveService->files->get($arquivo['arquivo']);

                    $fileUrl = "https://drive.google.com/file/d/{$file->getId()}/view";

                    echo "<a href='{$fileUrl}' class='list-group
                    list-group-item list-group-item-action' target='_blank'>{$file->getName()}</a>";


                }
                echo "</div>";
            }

            ?>
            <hr>
            <?php if($verificarProfessor) { ?>
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
                        $stmt = $conn->prepare("SELECT * FROM `corvo_usuarios_turma` JOIN corvo_usuarios ON corvo_usuarios.matricula = `corvo_usuarios_turma`.matricula WHERE `corvo_usuarios_turma`.siglaTurma = :turma AND `corvo_usuarios_turma`.matricula != :professor");
                        $stmt->bindParam(":turma", $turma["siglaTurma"]);
                        $stmt->bindParam(":professor", $professor["matricula"]);
                        $stmt->execute();

                        $alunos = $stmt->fetchAll();

                        foreach ($alunos as $aluno) {
                            // Verificando se o aluno entregou a atividade
                            $stmt = $conn->prepare("SELECT * FROM `corvo_atividades_entregas` WHERE atividade = :atividade AND aluno = :aluno");
                            $stmt->bindParam(":atividade", $atividade["id"]);
                            $stmt->bindParam(":aluno", $aluno["matricula"]);
                            $stmt->execute();

                            $entrega = $stmt->fetch();

                            echo "<tr>";
                            echo "<td>{$aluno['nome']}</td>";
                            echo "<td>" . ($entrega && $entrega['nota'] != NULL ? $entrega['nota'] : "Não avaliado") . "</td>";
                            echo "<td>" . ($entrega && $entrega['data_entrega'] != NULL ? date("d/m/Y H:i", strtotime($entrega['data_entrega'])) : "Não entregue") . "</td>";
                            echo "<td>";
                            if ($entrega) {
                                echo "<a href='". $link . "/turmas/{$turma['idTurma']}/atividades/{$atividade['id']}/entregas/{$entrega['id']}' class='btn btn-primary'><i class='fa-solid fa-eye'></i></a>";

                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
            <h3 class="h4 mb-3">Entregar atividade</h3>
            <?php if(!$entrega) {
                echo "<div class='alert alert-warning'>Você ainda não entregou essa atividade.</div>";
            } else {
                echo "<div class='alert alert-success'>Atividade entregue em " . date("d/m/Y H:i", strtotime($entrega['data_entrega'])) . "</div>";
            } ?>
            <form action="javascript:atividade.entregar();" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Arquivo:</label>
                    <?php

                    
                    if (isset($entrega, $entrega['anexo'])) {

                        $file = $driveService->files->get($entrega['anexo']);

                        $fileUrl = "https://drive.google.com/file/d/{$file->getId()}/view";

                        echo "<a href='{$fileUrl}' class='bg-light list-group
                        list-group-item list-group-item-action' target='_blank'>{$file->getName()}</a>";

                    } else {
                        echo "<input class='form-control' type='file' id='formFile' name='arquivo'>";
                    }
                        

                    ?>
                </div>
                <div class="mb-3">
                    <label for="observacoes">Observações:</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3" <?php if($entrega) { echo 'disabled'; } ?>><?php if(isset($entrega, $entrega['resposta'])) { echo $entrega['resposta']; } ?></textarea>
                </div>
                <?php if($entrega) { ?>
                    <input type="hidden" name="entrega" value="<?= $entrega['id'] ?>">
                <?php } ?>
                <input type="hidden" name="atividade" value="<?= $atividade['id'] ?>">

                <?php if(!$entrega) { ?> <button type="submit" class="btn btn-primary">Entregar</button> <?php } ?>
            </form>
        <?php } ?>
    </main>

    <?php require_once "../../../assets/includes/scripts.php"; ?>
    <script>
        $(document).ready(function() {
            $('#formFile').change(function() {
                var files = $(this)[0].files;
                var names = [];
                for (var i = 0; i < files.length; i++) {
                    names.push(files[i].name);
                }
                $(this).next('.form-text').text(names.join(', '));
            });

            $('#formFile').next('.form-text').text('Nenhum arquivo selecionado');

            
        });
    </script>
    <script>
        var atividade = {
            entregar: function() {
                var formData = new FormData();
                
                var observacoes = $('#observacoes').val();
                var atividade = '<?= $atividade['id'] ?>';
                var turma = '<?= $turma['idTurma'] ?>';
                var files = $('#formFile')[0].files;

                formData.append('observacoes', observacoes);
                formData.append('atividade', atividade);
                formData.append('turma', turma);
                formData.append('arquivo', files[0]);

                $.ajax({
                    url: '<?= $link ?>/paginas/espacoProfessor/php/atividade_entregar.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response);
                        console.log(response);
                    }
                });
            }
        }

    </script>
    
</body>

</html>