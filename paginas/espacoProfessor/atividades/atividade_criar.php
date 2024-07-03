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

if(!$turma) {
    echo 'Turma não encontrada.';
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
    <title>Adicionar atividade - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    

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
                <div class="form-group mt-4">
                    <label for="arquivo">Arquivos:</label>
                    <input type="file" class="form-control" id="arquivo" name="arquivo" multiple> 
                </div>

                <input type="hidden" name="turma_id" value="<?= $turma['idTurma'] ?>">

                <button type="submit" class="btn btn-primary mt-4 px-3 py-2"><i class="fa-solid fa-floppy-disk mr-2"></i> Salvar</button>
            </form>
        </div>

    </main>

    <?php require_once "../../../assets/includes/scripts.php"; ?>

    
    <script>
        var atividade = {
            adicionar: function() {

                var formData = new FormData();

                formData.append("atividade", $("#atividade").val());
                formData.append("descricao", $("#descricao").val());
                formData.append("data_entrega", $("#data_entrega").val());
                formData.append("nota_maxima", $("#nota_maxima").val());
                formData.append("turma_id", $("input[name='turma_id']").val());
                

                // para cada arquivo, adicionar ao formData
                var arquivos = $("#arquivo")[0].files;

                for (var i = 0; i < arquivos.length; i++) {
                    formData.append("arquivos[]", arquivos[i]);
                }

                

                if (!atividade || !descricao || !nota_maxima) {
                    alert("Preencha todos os campos obrigatórios.");
                    return;
                }

                $.ajax({
                    url: "<?= $link ?>/paginas/espacoProfessor/php/atividade_criar.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response != "erro") {
                            alert("Atividade adicionada com sucesso.");
                            console.log(response);
                            window.location.href = "<?= $link ?>/turmas/" + $("input[name='turma_id']").val() + "/atividades/" + response + "/ver";
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