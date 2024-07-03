<?php

include "../../../session.php";

if (!isset($_GET["turma"], $_GET['atividade'], $_GET['entrega'])) {
    echo "Turma, atividade e/ou entrega não informada.";
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

$stmt = $conn->prepare("SELECT * FROM corvo_atividades_entregas WHERE id = :entrega");
$stmt->bindParam(":entrega", $_GET["entrega"]);
$stmt->execute();

$entrega = $stmt->fetch();

if (!$entrega) {
    echo "Entrega não encontrada.";
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

$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :id");
$stmt->bindParam(":id", $entrega["aluno"]);
$stmt->execute();

$aluno = $stmt->fetch();

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit;
}


$verificarProfessor = ($professor["matricula"] == $_SESSION['matricula']) ? true : false;

if(!$verificarProfessor) {
    echo "Você não tem permissão para acessar esta página.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../../assets/includes/head.php"; ?>
    <title>Entrega #<?= $_GET['entrega'] ?> - <?= $atividade['atividade'] ?> - Corvo</title>
</head>

<body class="bg-light">
<?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    
        

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h2 class="h4">Entrega #<?= $_GET['entrega'] ?> - <?= $atividade['atividade'] ?></h2>
                    <div>
                        <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                    </div>
                </div>
            <p class="text-muted"><?= $atividade['descricao'] ?></p>
            <p class="text-muted">Data de entrega:
                <strong><?= ($atividade['data_entrega'] ? date("d/m/Y", strtotime($atividade['data_entrega'])) : "Sem data de entrega") ?></strong>
            </p>
            
            <hr>
            
            <h3 class="h4 mb-3">Atividade do aluno</h3>
            <form action="javascript:atividade.corrigir();" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="aluno" class="form-label">Aluno:</label>
                    <input type="text" class="form-control" id="aluno" name="aluno" value="<?= $aluno['nome'] ?> (<?= $aluno['matricula'] ?>)" disabled>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Arquivos:</label>
                    <?php

                    if(isset($entrega['anexo'])) {
                        
                        include '../../../vendor/autoload.php';
                        
                        // Identificando o tipo do arquivo do Google Drive
                        $client = new Google\Client();

                        $client->setAuthConfig('../../../credenciais.json');

                        $client->addScope("https://www.googleapis.com/auth/drive");

                        $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST']);

                        $client->setAccessType('offline');

                        $client->setIncludeGrantedScopes(true);

                        $driveService = new Google_Service_Drive($client);
                        

                        echo "<div class='list-group'>";

                        $file = $driveService->files->get($entrega['anexo']);

                        $fileUrl = "https://drive.google.com/file/d/{$file->getId()}/view";

                        echo "<a href='{$fileUrl}' class='bg-light list-group
                        list-group-item list-group-item-action' target='_blank'>{$file->getName()}</a>";
                        echo "</div>";

                        } else {
                            echo "<p class='text-muted'>Nenhum arquivo enviado.</p>";
                        }

                    ?>

                </div>
                <div class="mb-3">
                    <label for="observacoes">Observações:</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3" disabled><?= $entrega['resposta']?></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="nota">Nota:</label>
                    <?php if($entrega['nota'] != null) { ?>
                        <input type="number" class="form-control" id="nota" name="nota" value="<?= $entrega['nota'] ?>" disabled>
                    <?php } else { ?>
                        <input type="number" class="form-control" id="nota" name="nota" max="<?= $atividade['nota_maxima'] ?> disabled">
                    <?php } ?>
                </div>
                

                <input type="hidden" name="entrega" value="<?= $_GET['entrega'] ?>">
                <input type="hidden" name="atividade" value="<?= $_GET['atividade'] ?>">

                <?php if($entrega['nota'] == null) { ?>
                    <button type="submit" class="btn btn-primary">Corrigir</button>
                <?php } ?>
            </form>

    </main>

    <?php require_once "../../../assets/includes/scripts.php"; ?>
    <script>
        var atividade = {
            corrigir: function() {
                    
                    var formData = new FormData();
    
                    formData.append("nota", $("#nota").val());
                    formData.append("entrega", <?= $_GET['entrega'] ?>);
                    formData.append("atividade", <?= $_GET['atividade'] ?>);
                    formData.append("aluno", <?= $aluno['matricula'] ?>);
    
                    $.ajax({
                        url: "<?= $link ?>/paginas/espacoProfessor/php/entrega_corrigir.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response == "Nota atribuída com sucesso!") {
                                alert("Nota atribuída com sucesso.");
                                window.location.href = "<?= $link ?>/turmas/<?= $_GET['turma'] ?>/atividades/<?= $_GET['atividade'] ?>/ver";
                            } else {
                                alert(response);
                            }
                        }
                    });
            }
        }

    </script>
    
</body>

</html>