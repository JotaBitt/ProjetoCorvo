<?php

include "../../../session.php";

if (!isset($_GET["turma"], $_GET['aula'])) {
    echo "Turma e/ou aula não informada.";
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

$stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE id = :aula");
$stmt->bindParam(":aula", $_GET["aula"]);
$stmt->execute();

$aula = $stmt->fetch();

if (!$aula) {
    echo "Aula não encontrada.";
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
    <?php require_once "../../../assets/includes/head.php"; ?>
    <title><?= $aula['nomeAula'] ?> - Corvo</title>
</head>

<body class="bg-light">
<?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    
        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h2 class="h4"><?= $aula['nomeAula'] ?></h2>
                    <div>
                        <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                        <?php if($verificarProfessor) { ?>
                        <a class="btn btn-warning mx-1" href="<?= $link . "/turmas/{$turma['idTurma']}/aulas/{$aula['id']}/editar" ?>"><i class='fa-solid fa-pen-to-square'></i></a>
                        <a class="btn btn-danger mx-1" href="<?= $link . "/turmas/{$turma['idTurma']}/aulas/{$aula['id']}/excluir" ?>"><i class='fa-solid fa-trash-can'></i></a>
                        <?php } ?>
                    </div>
                </div>
            <p class="text-muted m-0">Turma: <strong><?= $turma['nome'] ?></strong></p>
            <p class="text-muted">Data da aula:
                <strong><?= ($aula['data_aula'] != "0000-00-00" ? date("d/m/Y", strtotime($aula['data_aula'])) : "---") ?></strong>
            </p>
            <?php if (empty($aula['conteudo'])) { ?>
            <div class="alert alert-warning" role="alert">
                Nenhum conteúdo foi adicionado a esta aula.
            </div>
            <?php } else { ?>
            <div class="card px-3">
                <p class="text-muted p-4"><?= $aula['conteudo'] ?></p>
            </div>
            <?php } ?>
            <?php

            $stmt = $conn->prepare("SELECT * FROM corvo_aulas_arquivos WHERE idAula = :aula");
            $stmt->bindParam(":aula", $aula['id']);
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

                    // Atribuir permissão de visualização para o arquivo
                    $permission = new Google_Service_Drive_Permission();
                    $permission->setRole('reader');
                    $permission->setType('anyone');
                    $permission->setAllowFileDiscovery(false);

                    $driveService->permissions->create($file->getId(), $permission);

                    $fileUrl = "https://drive.google.com/file/d/{$file->getId()}/view";

                    echo "<a href='{$fileUrl}' class='list-group
                    list-group-item list-group-item-action' target='_blank'>{$file->getName()}</a>";


                }
                echo "</div>";
            }

            ?>
            
            
        </div>
    </main>
    <?php require_once "../../../assets/includes/scripts.php"; ?>
</body>

</html>