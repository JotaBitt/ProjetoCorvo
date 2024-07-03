<?php

include '../../config_mysqli.php';

$conn = new mysqli("localhost", "root", "", "4ads_v1");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['create'])) {
        $siglaCurso = $_POST['siglaCurso'];
        $siglaTurma = $_POST['siglaTurma'];
        $professor = $_POST['professor'];
        $horario = $_POST['horario'];
        $quantAulas = $_POST['quantAulas'];
        $descricao = $_POST['descricao'];

        $sql_verifica = "SELECT * FROM corvo_cursos WHERE siglaCurso = '$siglaCurso'";
        $stmt_verifica = $conn->prepare($sql_verifica);
        $stmt_verifica->execute();
        $result_verifica = $stmt_verifica->get_result();

        if ($result_verifica->num_rows > 0) {
            $sql_verifica1 = "SELECT * FROM corvo_turmas WHERE siglaTurma = '$siglaTurma'";
            $stmt_verifica1 = $conn->prepare($sql_verifica1);
            $stmt_verifica1->execute();
            $result_verifica1 = $stmt_verifica1->get_result();

            if ($result_verifica1->num_rows == 0) {
                $sql_verifica2 = "SELECT * FROM corvo_usuarios_funcao WHERE matricula = '$professor' AND professor ='1'";
                $stmt_verifica2 = $conn->prepare($sql_verifica2);
                $stmt_verifica2->execute();
                $result_verifica2 = $stmt_verifica2->get_result();

                if ($result_verifica2->num_rows > 0) {
                    $sql = "INSERT INTO corvo_turmas (siglaCurso, siglaTurma, professor, horario, quantAulas, descricao) VALUES ('$siglaCurso', '$siglaTurma', '$professor', '$horario', '$quantAulas', '$descricao')";
                    $numAulas = intval($quantAulas);

                    $stmt = $conn->prepare("INSERT INTO corvo_aulas (siglaTurma, nomeAula, data_aula) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $siglaTurma, $nomeAula, $data_aula);
                    $data_aula = '';

                    for ($i = 1; $i <= $numAulas; $i++) {
                        $nomeAula = 'Aula ' . $i . " - " . $siglaCurso;
                        $foi = $stmt->execute();
                    }
                    if ($foi == TRUE) {
                        $i--;
                        echo "$i Nova(s) aula(s) criada(s) com sucesso para a Turma: $siglaTurma<br>";
                    } else {
                        echo "Erro: " . $stmt->error . "<br>";
                    }

                    if ($conn->query($sql) === TRUE) {
                        $message = "Nova turma cadastrada com sucesso!";
                    } else {
                        $message = "Erro: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "O professor não existe no banco de dados.";
                }
            } else {
                echo "A Turma já existe no banco de dados.";
            }
        } else {
            echo "O curso fornecido não existe no banco de dados.";
        }
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $siglaCurso = $_POST['siglaCurso'];
        $siglaTurma = $_POST['siglaTurma'];
        $professor = $_POST['professor'];
        $horario = $_POST['horario'];
        $quantAulas = $_POST['quantAulas'];
        $descricao = $_POST['descricao'];

        $sql = "UPDATE corvo_turmas SET siglaCurso='$siglaCurso', siglaTurma='$siglaTurma', professor='$professor', horario='$horario', quantAulas='$quantAulas', descricao='$descricao' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $message = "Turma atualizada com sucesso!";
        } else {
            $message = "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM corvo_turmas WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Turma deletada com sucesso!";
    } else {
        $message = "Erro: " . $sql . "<br>" . $conn->error;
    }
}



$sql = "SELECT * FROM corvo_turmas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../assets/includes/head.php"; ?>
    <title>Gerenciamento de Turmas - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../assets/includes/header_instituicao.php"; ?>
    <main class="container mt-4">

        <div class="card mb-4 p-5">
            <h2 class="h4">Gerenciamento de Turmas</h2>
            
            <?php if (isset($message)): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <h3 class="h5">Cadastrar Nova Turma</h3>

            <form action="crudTurma.php" method="post">
                <div class="mb-3">
                    <label for="siglaCurso" class="form-label">Sigla do Curso:</label>
                    <input type="text" id="siglaCurso" name="siglaCurso" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="siglaTurma" class="form-label">Sigla da Turma:</label>
                    <input type="text" id="siglaTurma" name="siglaTurma" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="professor" class="form-label">Professor:</label>
                    <select name="professor" id="professor" class="form-select form-input">
                    <?php
                        $stmt = $conn->query("SELECT * FROM corvo_professor");

                        while($usuario = $stmt->fetch_assoc()) {
                            echo "<option value='".$usuario['matricula']."'>".$usuario['nome']. " (" . $usuario['matricula']. ")" . "</option>";
                        }
                    ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="horario" class="form-label">Horário:</label>
                    <input type="text" id="horario" name="horario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="quantAulas" class="form-label">Número de aulas:</label>
                    <input type="text" id="quantAulas" name="quantAulas" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" required>
                </div>
                <button type="submit" name="create" class="btn btn-primary">Cadastrar</button>
            </form>

            <h3 class="h5 mt-4">Lista de Turmas</h3>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Sigla do Curso</th>
                        <th>Sigla da Turma</th>
                        <th>Professor</th>
                        <th>Horário</th>
                        <th>Número de aulas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['siglaCurso']}</td>
                                    <td>{$row['siglaTurma']}</td>
                                    <td>{$row['professor']}</td>
                                    <td>{$row['horario']}</td>
                                    <td>{$row['quantAulas']}</td>
                                    <td>
                                        <a href='crudTurma.php?edit={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                                        <a href='crudTurma.php?delete={$row['id']}' class='btn btn-danger btn-sm'>Deletar</a>
                                        <a href='crudTurma.php?add={$row['id']}' class='btn btn-primary btn-sm'>Gen Aluno</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhuma turma encontrada</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


        <form id="redirectForm" method="POST" action="gerenciarAlunoTurma.php">
            <input type="hidden" name="siglaTurmaAdd" id="siglaTurmaAdd">
            <input type="hidden" name="siglaCursoAdd" id="siglaCursoAdd">
            <!-- Adicione mais campos conforme necessário -->
        </form>

    <script>
        function redirecionarComPost(siglaTurmaAdd, siglaCursoAdd) {
            // Defina os valores dos campos ocultos
            document.getElementById('siglaTurmaAdd').value = siglaTurmaAdd;
            document.getElementById('siglaCursoAdd').value = siglaCursoAdd;
            
            // Submeta o formulário
            document.getElementById('redirectForm').submit();
        }

    </script>

            <?php
            if (isset($_GET['add'])) {
                $id = $_GET['add'];
                $sql = "SELECT * FROM corvo_turmas WHERE id=$id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $siglaTurma = $row['siglaTurma'];
                $siglaCurso = $row['siglaCurso'];

                echo "
                  <script>
                    redirecionarComPost('$siglaTurma', '$siglaCurso');
                  </script>
                ";

            }
            ?>

            <?php
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM corvo_turmas WHERE id=$id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
            ?>
                <h3 class="h5 mt-4">Editar Turma</h3>
                <form action="crudTurma.php" method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <div class="mb-3">
                        <label for="siglaCurso" class="form-label">Sigla do Curso:</label>
                        <input type="text" id="siglaCurso" name="siglaCurso" class="form-control" value="<?= $row['siglaCurso'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="siglaTurma" class="form-label">Sigla da Turma:</label>
                        <input type="text" id="siglaTurma" name="siglaTurma" class="form-control" value="<?= $row['siglaTurma'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="professor" class="form-label">Professor (matrícula):</label>
                        <input type="text" id="professor" name="professor" class="form-control" value="<?= $row['professor'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horário:</label>
                        <input type="text" id="horario" name="horario" class="form-control" value="<?= $row['horario'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantAulas" class="form-label">Número de aulas:</label>
                        <input type="text" id="quantAulas" name="quantAulas" class="form-control" value="<?= $row['quantAulas'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" class="form-control" value="<?= $row['descricao'] ?>" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                </form>
            <?php } ?>

        </div>
    </main>
    <?php require_once "../../assets/includes/footer.php"; ?>
</body>

</html>
