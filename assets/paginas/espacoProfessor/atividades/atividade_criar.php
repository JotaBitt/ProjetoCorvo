<?php

require_once "../../config.php";

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
    <?php require_once "../../assets/includes/head.php"; ?>
    <title>Adicionar atividade - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../assets/includes/card.php"; ?>    

        <div class="card mb-4 p-5">
            <form action="javascript:atividade.adicionar();" method="POST">
                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h1 class="h3">Nova atividade</h1>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                </div>
                <div class="form-group mt-4">
                    <label for="atividade">Atividade: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="atividade" name="atividade">
                </div>
                <div class="form-group mt-4">
                    <label for="descricao">Descrição: <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="5"></textarea>
                </div>
                <div class="form-group mt-4">
                    <label for="data_entrega">Data de entrega: </label>
                    <input type="date" class="form-control" id="data_entrega" name="data_entrega">
                </div>
                <div class="form-group mt-4">
                    <label for="data_entrega">Nota máxima: <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="nota_maxima" name="nota_maxima">
                </div>

                <input type="hidden" name="turma_id" value="<?= $turma['id'] ?>">

                <button type="submit" class="btn btn-primary mt-4 px-3 py-2"><i class="fa-solid fa-floppy-disk mr-2"></i> Salvar</button>
            </form>
        </div>

    </main>

    <?php require_once "../../assets/includes/scripts.php"; ?>

    
    <script>
        var atividade = {
            adicionar: function() {
                var atividade = $("#atividade").val();
                var descricao = $("#descricao").val();
                var data_entrega = $("#data_entrega").val();
                var nota_maxima = $("#nota_maxima").val();
                var turma_id = $("input[name='turma_id']").val();

                if (!atividade || !descricao || !nota_maxima) {
                    alert("Preencha todos os campos obrigatórios.");
                    return;
                }

                $.ajax({
                    url: "<?= $link ?>/espacoProfessor/php/atividade_criar.php",
                    method: "POST",
                    data: {
                        atividade: atividade,
                        descricao: descricao,
                        data_entrega: data_entrega,
                        nota_maxima: nota_maxima,
                        turma_id: turma_id
                    },
                    success: function(response) {
                        if (response != "erro") {
                            alert("Atividade adicionada com sucesso.");
                            console.log(response);
                            window.location.href = "<?= $link ?>/turmas/" + turma_id + "/atividades/" + response + "/ver";
                        } else {
                            alert(response);
                            console.log(response);
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>