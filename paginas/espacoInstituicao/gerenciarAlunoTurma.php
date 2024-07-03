<?php 
include "../../config_mysqli.php"; 
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once "../../assets/includes/head.php"; ?>
    <title>Gerenciamento de Turmas - Corvo</title>
</head>

<body class="bg-light">
    <?php require_once "../../assets/includes/header_instituicao.php"; ?>
    <?php 

if ($_SERVER["REQUEST_METHOD"] == "POST"){

$siglaTurma = $_POST['siglaTurmaAdd'];
$siglaCurso = $_POST['siglaCursoAdd'];

}

$sql = "SELECT * FROM corvo_usuarios_turma WHERE siglaTurma='$siglaTurma'";
$result = $conn->query($sql);

?>
    <main class="container mt-4">

        <div class="card mb-4 p-5">
            <h2 class="h4">Gerenciamento de Turmas</h2>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Sigla do Curso</th>
                        <th>Sigla da Turma</th>
                        <th>Nome</th>
                        <th>Matricula</th>
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
                                    <td>{$row['nome']}</td>
                                    <td>{$row['matricula']}</td>
                                    <td>
                                        <form method='POST' action='gerenciarAlunoTurma.php' style='display:inline;' id='deleteForm{$row['id']}'>
                                            <input type='hidden' name='delete' value='{$row['id']}'>
                                            <input type='hidden' name='siglaTurmaAdd' value='{$row['siglaTurma']}'>
                                            <input type='hidden' name='siglaCursoAdd' value='{$row['siglaCurso']}'>
                                            <button type='button' class='btn btn-danger btn-sm' onclick='submitDeleteForm({$row['id']})'>Deletar</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Não há alunos nessa turma </td></tr>";
                    }

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                        $id = $_POST['delete'];
                        $sql = "DELETE FROM corvo_usuarios_turma WHERE id=$id";
                        if ($conn->query($sql) === TRUE) {
                            $message = "Aluno deletado com sucesso!";
                        } else {
                            $message = "Erro: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    ?>

    <p id="msg"></p>

    <h3 class="h5 mt-4">Adicionar Aluno</h3>

    <form id="formAlterar" style="display: none;" class="mt-3">

        <div class="form-group">
        <label for="siglaCurso">Sigla do Curso:</label>
        <input type="text" class="form-control" id="siglaCurso" value="<?php echo $siglaCurso; ?>" readonly>
        </div>
        <div class="form-group">
        <label for="siglaTurma">Sigla da Turma:</label>
        <input type="text" class="form-control" id="siglaTurma"  value="<?php echo $siglaTurma; ?>" readonly>
        </div>
        <div class="form-group">
        <label for="matricula">Matricula:</label>
        <select name="matricula" id="matricula" class="form-select form-input">
        <?php
            $stmt = $conn->query("SELECT * FROM corvo_usuarios WHERE matricula NOT IN (SELECT professor FROM corvo_turmas WHERE siglaTurma = '".$siglaTurma."') AND matricula NOT IN (SELECT DISTINCT matricula FROM corvo_usuarios_turma WHERE siglaTurma = '".$siglaTurma."') AND unidade = 0");
            

            while($usuario = $stmt->fetch_assoc()) {
                echo "<option value='".$usuario['matricula']."'>".$usuario['nome']. " (" . $usuario['matricula']. ")" . "</option>";
            }
        ?>
        </select>
        <!-- <input type="email" class="form-control" id="matricula" required> -->
        </div>
        <button type="button" class="btn btn-primary mt-2" onclick="adicionarAluno()">Adicionar Aluno</button>
    </form>

    <h3 class="h5 mt-4">Lista de Alunos na Turma</h3>
        </div>
    </main>
    <?php require_once "../../assets/includes/footer.php"; ?>
    <script>

    function adicionarAluno(){

        let siglaCurso = document.getElementById("siglaCurso").value;
        let siglaTurma = document.getElementById("siglaTurma").value;
        let matricula = document.getElementById("matricula").value;

        let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("msg").innerHTML = "Adicionado";
        }
      };
      xmlhttp.open("POST", "adicionarAlunoTurma.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("siglaCurso=" + siglaCurso + "&siglaTurma=" + siglaTurma + "&matricula=" + matricula);

      setTimeout(function(){
            location.reload();
        }, 500); 
    }

    function submitDeleteForm(id) {
        document.getElementById('deleteForm' + id).submit();
    }
   
</script>
</body>

</html>
