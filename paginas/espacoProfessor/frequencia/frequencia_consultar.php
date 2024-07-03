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
    <title>Controle de Frequência - <?= $turma['nome'] ?> - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../../assets/includes/header.php"; ?>
    <main class="container mt-4">
        <?php require_once "../../../assets/includes/card.php"; ?>

        <div class="card mb-4 p-5">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="javascript:history.go(-1)" class="btn btn-outline-primary mx-1">Voltar</a>
            </div>
            <h2 class="h4">Controle de Frequência</h2>

            <hr class="my-3">
            <form action="javascript:frequencia.consultar();">
                
                <div class="form-group row">
                    <label for="aula" class="col-sm-2 col-form-label">Aula</label>
                    <div class="col-sm-10">
                        <select name="aula" id="aula" class="form-control">
                            <?php

                            $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE id NOT IN (SELECT aula FROM corvo_presencas) AND siglaTurma = :turma AND status = 1");
                            $stmt->bindParam(":turma", $turma['siglaTurma']);
                            $stmt->execute();

                            $aulas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($aulas as $key => $aula) {
                                $numAula = $key + 1;
                                $dataAula = date("d/m/Y", strtotime($aula['data_aula']));
                                if($dataAula == "30/11/-0001") {
                                    echo "<option value='{$aula['id']}'>{$aula['nomeAula']}</option>";    
                                } else {
                                    echo "<option value='{$aula['id']}'>{$aula['nomeAula']} - {$dataAula}</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>

            </form>
        </div>

    </main>

    <?php require_once "../../../assets/includes/footer.php"; ?>
    <?php require_once "../../../assets/includes/scripts.php"; ?>

    <script>
        var frequencia = {
            consultar: function() {
                var aula = document.getElementById("aula").value;
                window.location.href = `<?= $link ?>/turmas/<?= $_GET['turma'] ?>/frequencia/${aula}/registrar`;
            }
        }
    </script>
</body>

</html>