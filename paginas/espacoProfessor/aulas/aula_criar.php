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

$professor = $stmt->fetch();

if (!$professor) {
    echo "Professor não encontrado.";
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
    <title>Adicionar aula - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>    

        <div class="card mb-4 p-5">
            <form action="javascript:aula.adicionar();" method="POST">
                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <h1 class="h3">Nova aula</h1>
                    <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
                </div>
                <div class="form-group mt-4">
                    <label for="aula">Aula: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="aula" name="aula" required>
                </div>
                <div class="form-group mt-4">
                    <label for="data_entrega">Data da aula: <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="data_aula" name="data_aula" required>
                </div>
                <div class="form-group mt-4">
                    <label for="conteudo">Conteúdo: <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="13" required></textarea>
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
        var aula = {
            adicionar: function() {

                var formData = new FormData();
                
                formData.append("aula", $("#aula").val());
                formData.append("conteudo", $("#conteudo").val());
                formData.append("data_aula", $("#data_aula").val());
                formData.append("turma_id", $("input[name='turma_id']").val());
                formData.append("arquivo", $("#arquivo")[0].files[0]);


                $.ajax({
                    url: "<?= $link ?>/paginas/espacoProfessor/php/aula_criar.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if(response != "erro") {
                            alert("Aula adicionada com sucesso.");
                            console.log(response);
                            window.location.href = "<?= $link ?>/turmas/" + $("input[name='turma_id']").val() + "/aulas";
                        } else {
                            alert("Ocorreu um erro ao adicionar a aula.");
                        }
                    }
                });

            }

            
        }
    </script>
</body>

</html>