<?php

include '../../session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create
    if (isset($_POST['create'])) {
        $siglaTurma = $_POST['siglaTurma'];
        $nomeAula = $_POST['nomeAula'];
        $data_aula = $_POST['data_aula'];
        $conteudo = $_POST['conteudo'];

        $stmt = $conn->prepare("INSERT INTO corvo_aulas (siglaTurma, nomeAula, data_aula, conteudo) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $siglaTurma);
        $stmt->bindParam(2, $nomeAula);
        $stmt->bindParam(3, $data_aula);
        $stmt->bindParam(4, $conteudo);

        if ($stmt->execute()) {
            echo "Novo registro criado com sucesso!";
        } else {
            echo "Erro: " . $stmt->errorInfo()[2];
        }
    }

    // Update
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $siglaTurma = $_POST['siglaTurma'];
        $nomeAula = $_POST['nomeAula'];
        $data_aula = $_POST['data_aula'];
        $conteudo = $_POST['conteudo'];

        $stmt = $conn->prepare("UPDATE corvo_aulas SET siglaTurma=?, nomeAula=?, data_aula=?, conteudo=? WHERE id=?");
        $stmt->bindParam(1, $siglaTurma);
        $stmt->bindParam(2, $nomeAula);
        $stmt->bindParam(3, $data_aula);
        $stmt->bindParam(4, $conteudo);
        $stmt->bindParam(5, $id);

        if ($stmt->execute()) {
            echo "Registro atualizado com sucesso!";
        } else {
            echo "Erro: " . $stmt->errorInfo()[2];
        }
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM corvo_aulas WHERE id=?");
    $stmt->bindParam(1, $id);

    if ($stmt->execute()) {
        echo "Registro deletado com sucesso!";
    } else {
        echo "Erro: " . $stmt->errorInfo()[2];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../assets/includes/head.php"; ?>
    <title>CRUD Aulas - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../assets/includes/header_instituicao.php"; ?>
    <main class="container mt-4">

        <div class="card mb-4 p-5">
            <!-- Formulário de Inserção/Atualização -->
            <?php
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE id=?");
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $row = $stmt->fetch();

                if ($row) {
                    $siglaTurma = $row['siglaTurma'];
                    $nomeAula = $row['nomeAula'];
                    $data_aula = $row['data_aula'];
                    $conteudo = $row['conteudo'];
                }
            } else {
                $siglaTurma = '';
                $nomeAula = '';
                $data_aula = '';
                $conteudo = '';
            }
            ?>
            <h2>Criar aula:</h2>
            <form method="POST" action="">
                <div class="form-group">
                <input class="form-control" type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                <label>Sigla Turma:</label><br>
                <input class="form-control" type="text" name="siglaTurma" value="<?php echo $siglaTurma; ?>"><br>
                <label>Nome Aula:</label><br>
                <input class="form-control" type="text" name="nomeAula" value="<?php echo $nomeAula; ?>"><br>
                <label>Data Aula:</label><br>
                <input class="form-control" type="date" name="data_aula" value="<?php echo $data_aula; ?>"><br>
                <label>Conteúdo:</label><br>
                <textarea name="conteudo" class="form-control"><?php echo $conteudo; ?></textarea><br>
                <?php if (isset($id)) { ?>
                    <input type="submit" name="update" value="Atualizar Aula" class="btn btn-warning">
                <?php } else { ?>
                    <input type="submit" name="create" value="Criar Aula" class="btn btn-primary">
                <?php } ?>
                </div>
            </form>

            <!-- Formulário de Busca -->
            <h2>Buscar aulas</h2>
            <form method="GET" action="">
                <label>Buscar por Sigla Turma:</label><br>
                <input type="text" class="form-control" name="searchSiglaTurma" value="<?php echo isset($_GET['searchSiglaTurma']) ? $_GET['searchSiglaTurma'] : ''; ?>"><br>
                <input type="submit" value="Buscar" class="btn btn-secondary">
            </form>

            <!-- Tabela de Resultados -->
            <?php
            if (isset($_GET['searchSiglaTurma'])) {
                $searchSiglaTurma = $_GET['searchSiglaTurma'];
                $stmt = $conn->prepare("SELECT * FROM corvo_aulas WHERE siglaTurma=?");
                $stmt->bindParam(1, $searchSiglaTurma);
                $stmt->execute();
                $result = $stmt->fetchAll();

                if ($result) {
                    echo "<table class='table table-hover table-bordered'><tr><th>Sigla Turma</th><th>Nome Aula</th><th>Data Aula</th><th>Conteúdo</th><th>Ações</th></tr>";
                    foreach ($result as $row) {
                        echo "<tr>
                                <td>{$row['siglaTurma']}</td>
                                <td>{$row['nomeAula']}</td>
                                <td>{$row['data_aula']}</td>
                                <td>{$row['conteudo']}</td>
                                <td>
                                    <a href='?edit={$row['id']}' class='btn btn-primary'>Editar</a>
                                    <a href='?delete={$row['id']}&searchSiglaTurma=$searchSiglaTurma' class='btn btn-danger'>Deletar</a>
                                </td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Nenhum resultado encontrado para a sigla da turma: $searchSiglaTurma";
                }
            }
            ?>
        </div>
    </main>
    <?php require_once "../../assets/includes/footer.php"; ?>
    <?php require_once "../../assets/includes/scripts.php"; ?>
</body>

</html>
