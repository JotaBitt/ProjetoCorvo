<?php
    
    include "session.php";

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

?>

<!doctype html>
<html lang="pt-BR">
    <head>
        <?php include "assets/includes/head.php"; ?>
        <title><?= $turma['nome'] ?> - Corvo</title>
    </head>
    <body class="bg-light">
        <?php include "assets/includes/header.php"; ?>

        <!-- Main Content -->
        <main class="container mt-4">
            <?php include "assets/includes/card.php"; ?>

            <div class="row">
                <div class="col-3 mb-4">
                    <div class="card">
                        <div class="card-body bg-light">
                            <h5 class="card-title">Google Meet</h5>
                            <p class="card-text">Acesse a sala de aula virtual da turma.</p>
                            <a href="<?= $turma['linkMeet'] ?>" class="btn btn-outline-success" target="_blank"><i class="fa-solid fa-video mx-1"></i> Google Meet</a>
                            <?php if($verificarProfessor) { ?>
                            <a href="javascript:turma.configuracoes();" class="btn btn-secondary"><i class="fa-solid fa-cog"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-9 mb-4">
                    <div class="card p-2">
                        <?php

                            if($verificarProfessor) {

                                $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE siglaTurma = :turma");
                                $stmt->bindParam(":turma", $turma['siglaTurma']);
                                $stmt->execute();

                            } else {
                                $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE siglaTurma = :turma AND status = true");
                                $stmt->bindParam(":turma", $turma['siglaTurma']);
                                $stmt->execute();
                            }                            

                            $aulas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if(!$aulas) {
                                echo '<div class="card-body"><h5 class="card-title">Aulas</h5><p class="text-muted">Não há aulas disponíveis para esta turma.</p></div>';
                                
                            } else {
                                
                                echo '<div class="card-body"><h5 class="card-title">Aulas</h5>';
                                echo '<ul class="list-group list-group-flush">';

                                foreach($aulas as $aula) {
                                    echo '<div class="list-group mb-3">';
                                    echo '<a href="'.$link.'/turmas/'.$turma['idTurma'].'/aulas/'.$aula['id'].'" class="list-group-item list-group-item-action d-flex align-items-center">';

                                        if($aula['status'] == 0) {
                                            echo '<div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center mr-3" style="width: 40px; height: 40px;">';
                                        } else {
                                            echo '<div class="rounded-circle bg-primary d-flex justify-content-center align-items-center mr-3" style="width: 40px; height: 40px;">';

                                        }
                                        echo '<i class="fas fa-book text-white"></i>';
                                        echo '</div>';
                                        echo '<div class="ms-3">';
                                            echo '<p class="mb-1 card-title"><strong>'. $aula["nomeAula"] .'</strong></p>';
                                            if($aula['data_aula'] != "0000-00-00") {
                                                echo '<small class="text-muted">'. date("d/m/Y", strtotime($aula["data_aula"])).'</small>';
                                            }
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

        <?php include "assets/includes/footer.php"; ?>

        <?php include "assets/includes/scripts.php"; ?>

        <!-- Chamada de SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php if($verificarProfessor) { ?>

            <script>
                var turma = {
                    configuracoes: function() {


                        Swal.fire({
                            title: 'Configurações da turma',
                            html: '<form action="<?= $link ?>/assets/ajax/turma.php"><div class="form-group"><label for="codigoMeet">Código do Google Meet</label><input type="text" class="form-control" id="codigoMeet" name="meet" value="<?php if(isset($turma['linkMeet'])) { echo $turma['linkMeet']; } else { echo ""; } ?>"><input type="hidden" name="turma" value="<?= $_GET['turma'] ?>"></div></form>',
                            showCancelButton: true,
                            confirmButtonText: 'Salvar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            // Fazer requisição AJAX para salvar as configurações
                            $.ajax({
                                url: "<?= $link ?>/assets/ajax/turma.php",
                                type: "POST",
                                data: {
                                    meet: $("#codigoMeet").val(),
                                    turma: <?= $_GET['turma'] ?>
                                },
                                success: function(data) {
                                    if(data == "1") {
                                        Swal.fire({
                                            title: 'Sucesso!',
                                            text: 'Configurações salvas com sucesso.',
                                            icon: 'success'
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Erro!',
                                            text: 'Ocorreu um erro ao salvar as configurações.',
                                            icon: 'error'
                                        });
                                        console.log(data);
                                    }
                                }
                            });
                        });
                    }
                }
            </script>

        <?php } ?>
    </body>
</html>
