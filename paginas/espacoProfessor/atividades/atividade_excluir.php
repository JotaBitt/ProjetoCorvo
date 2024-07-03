<?php

include "../../../session.php";

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

$stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE id = :atividade");
$stmt->bindParam(":atividade", $_GET["atividade"]);
$stmt->execute();

$atividade = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$atividade) {
    echo "Atividade não encontrada.";
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

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../../assets/includes/head.php"; ?>
    <title>Excluir <?= $atividade['atividade'] ?> - Corvo</title>
</head>

<body class="bg-light">
<?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    

        <div class="card mb-4 p-5">
            
            <form action="javascript:atividade.excluir();" method="POST">
                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h2 class="h4">Excluir atividade</h2>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                </div>
                <div class="form-group mt-4">
                    <label for="atividade">Atividade: <span class="text-danger">*</span></label>
                    <input type="text" disabled class="form-control" id="atividade" name="atividade" value="<?= $atividade['atividade'] ?>">
                </div>
                <div class="form-group mt-4">
                    <label for="descricao">Descrição: <span class="text-danger">*</span></label>
                    <textarea class="form-control" disabled id="descricao" name="descricao" rows="5"><?= $atividade['descricao'] ?></textarea>
                </div>
                <div class="form-group mt-4">
                    <label for="data_entrega">Data de entrega: </label>
                    <input type="date" disabled class="form-control" id="data_entrega" name="data_entrega" value="<?= $atividade['data_entrega'] ?>">
                </div>
                <div class="form-group mt-4">
                    <label for="data_entrega">Nota máxima: <span class="text-danger">*</span></label>
                    <input type="number" disabled class="form-control" id="nota_maxima" name="nota_maxima" value="<?= $atividade['nota_maxima'] ?>">
                </div>

                <input type="hidden" name="atividade_id" value="<?= $atividade['id'] ?>">
                <input type="hidden" name="turma_id" value="<?= $turma['idTurma'] ?>">

                <small class="d-block">Tem certeza que deseja excluir? Esta ação é irreversível.</small>
                <button type="submit" class="btn btn-danger mt-2 px-3 py-2"><i class="fa-solid fa-trash mr-2"></i> Excluir</button>
            </form>
        </div>

    </main>
    <?php require_once "../../../assets/includes/scripts.php"; ?>
    <script>
        var atividade = {
            excluir: function() {
                var atividade = document.getElementById("atividade").value;
                var descricao = document.getElementById("descricao").value;
                var data_entrega = document.getElementById("data_entrega").value;
                var atividade_id = document.querySelector("input[name='atividade_id']").value;
                var turma_id = document.querySelector("input[name='turma_id']").value;
                var nota_maxima = document.getElementById("nota_maxima").value;

                $.ajax({
                    url: "<?= $link ?>/paginas/espacoProfessor/php/atividade_excluir.php",
                    type: "POST",
                    data: {
                        atividade_id: atividade_id,
                        turma_id: turma_id
                    },
                    success: function(response) {
                        alert(response);
                        console.log(response);
                        window.location.href = "<?= $link ?>/turmas/" + turma_id + "/atividades";
                    }
                });
            }
        }
    </script>
</body>

</html>