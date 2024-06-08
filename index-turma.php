<?php
    
    require_once "config.php";

    if(!isset($_GET['turma'])) {
        echo 'Turma não informada.';
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM corvo_turmas JOIN corvo_cursos ON corvo_turmas.curso = corvo_cursos.id WHERE corvo_turmas.id = :turma");
    $stmt->bindParam(":turma", $_GET["turma"]);
    $stmt->execute();

    $turma = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$turma) {
        echo 'Turma não encontrada.';
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

<!doctype html>
<html lang="pt-BR">
    <head>
        <?php require_once "assets/includes/head.php"; ?>
        <title><?= $turma['nome'] ?> - Corvo</title>
    </head>
    <body class="bg-light">
        <?php require_once "assets/includes/header.php"; ?>

        <!-- Main Content -->
        <main class="container mt-4">
            <?php require_once "assets/includes/card.php"; ?>

            <div class="row">
                <div class="col-3 mb-4">
                    <div class="card">
                        <div class="card-body bg-light">
                            <h5 class="card-title">Próximas atividades</h5>
                            <p class="text-muted">Não há atividades para a próxima semana</p>
                        </div>
                    </div>
                </div>
                <div class="col-9 mb-4">
                    <div class="card p-2">
                        <?php

                            $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE turma = :turma");
                            $stmt->bindParam(":turma", $_GET["turma"]);
                            $stmt->execute();

                            $aulas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            echo '<div class="card-body"><h5 class="card-title">Aulas</h5>';

                            if(!$aulas) {
                                echo '<div class="card-body bg-light"><h5 class="card-title">Aulas</h5><p class="text-muted">Não há aulas cadastradas para esta turma.</p></div>';
                            } else {
                                
                                echo '<ul class="list-group list-group-flush">';

                                foreach($aulas as $aula) {
                                    echo '<div class="list-group">';
                                    echo '<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">';
                                        echo '<div class="rounded-circle bg-primary d-flex justify-content-center align-items-center mr-3" style="width: 40px; height: 40px;">';
                                        echo '<i class="fas fa-book text-white"></i>';
                                        echo '</div>';
                                        echo '<div class="ms-3">';
                                            echo '<p class="mb-1 card-title"><strong>'. $aula["nome"] .'</strong></p>';
                                            echo '<small class="text-muted">'. $aula["data_aula"].'</small>';
                                        echo '</div>';
                                    echo '</a>';
                                echo '</div>';
                                }

                                echo '</ul></div>';
                            }
                        ?>

                    </div>
                </div>
            </div>
        </main>

        <?php require_once "assets/includes/footer.php"; ?>

        <?php require_once "assets/includes/scripts.php"; ?>
        
    </body>
</html>
