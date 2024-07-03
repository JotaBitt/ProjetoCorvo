<?php


include "../../../session.php";

if(!isset($_GET['turma'], $_GET['aula'])) {
    echo 'Turma e/ou aula não informada.';
    exit;
}

$stmt = $conn->prepare("SELECT *, corvo_turmas.id AS idTurma FROM corvo_turmas JOIN corvo_cursos ON corvo_turmas.siglaCurso = corvo_cursos.siglaCurso WHERE corvo_turmas.id = :turma");
$stmt->bindParam(":turma", $_GET["turma"]);
$stmt->execute();

$turma = $stmt->fetch();

if(!$turma) {
    echo 'Turma não encontrada.';
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

$stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE id = :aula");
$stmt->bindParam(":aula", $_GET["aula"]);
$stmt->execute();

$aula = $stmt->fetch();

if (!$aula) {
    echo "Aula não encontrada.";
    exit;
}

$verificarProfessor = ($professor["matricula"] == $_SESSION['matricula']) ? true : false;

if(!$verificarProfessor) {
    echo "Você não tem permissão para acessar essa página.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../../assets/includes/head.php"; ?>
    <title>Excluir <?= $aula['nomeAula'] ?> - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    

        <div class="card mb-4 p-5">
            <form action="javascript:aula.excluir();" method="POST">
                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h1 class="h3">Excluir aula</h1>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                </div>
                <div class="form-group mt-4">
                    <label for="aula">Aula: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="aula" name="aula" required disabled value="<?= $aula['nomeAula'] ?>">
                </div>
                <div class="form-group mt-4">
                    <label for="data_entrega">Data da aula: <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="data_aula" name="data_aula" disabled required value="<?= $aula['data_aula'] ?>">
                </div>
                <div class="form-group mt-4">
                    <label for="conteudo">Conteúdo: <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="13" disabled required><?= $aula['conteudo'] ?></textarea>
                </div>
                
                <input type="hidden" name="turma_id" value="<?= $turma['idTurma'] ?>">
                <input type="hidden" name="aula_id" value="<?= $aula['id'] ?>">

                <small class="d-block">Tem certeza que deseja excluir? Esta ação é irreversível.</small>
                <button type="submit" class="btn btn-danger mt-2 px-3 py-2"><i class="fa-solid fa-trash mr-2"></i> Excluir</button>
            </form>
        </div>

    </main>

    <?php require_once "../../../assets/includes/scripts.php"; ?>

    
    <script>
        var aula = {
            excluir: function() {
                var turma_id = $("input[name='turma_id']").val();
                var aula_id = $("input[name='aula_id']").val();

                $.ajax({
                    url: "<?= $link ?>/paginas/espacoProfessor/php/aula_excluir.php",
                    type: "POST",
                    data: {
                        turma_id: turma_id,
                        aula_id: aula_id
                    },
                    success: function(response) {
                        if(response == "Aula excluída com sucesso!") {
                            alert("Aula excluída com sucesso.");
                            window.location.href = "<?= $link ?>/turmas/" + turma_id + "/aulas";
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