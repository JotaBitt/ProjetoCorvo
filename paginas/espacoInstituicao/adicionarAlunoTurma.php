<?php
include '../../config_mysqli.php';

// Matrícula do aluno a ser verificada e adicionada
$matricula = $_POST['matricula'];  // Supondo que a matrícula seja enviada via POST
$siglaTurma = $_POST['siglaTurma'];  // Supondo que o código da turma seja enviado via POST       
$siglaCurso = $_POST["siglaCurso"];

// Verificar se a matrícula existe no banco de dados corvo_aluno
$sql_verifica = "SELECT * FROM corvo_usuarios WHERE matricula = '$matricula'";
$stmt_verifica = $conn->prepare($sql_verifica);
// $stmt_verifica->bind_param("s", $matricula);
$stmt_verifica->execute();
$result_verifica = $stmt_verifica->get_result();

if ($result_verifica->num_rows > 0) {
    // Matrícula existe, então obter os dados do aluno
    $aluno = $result_verifica->fetch_assoc();

    $nome = $aluno['nome'];

    // Preparar os dados para inserção no banco de dados turma
    
    // Adicione outros atributos conforme necessário

    // Inserir o aluno no banco de dados turma
    $sql_insere = "INSERT INTO corvo_usuarios_turma (siglaTurma, siglaCurso, nome, matricula) VALUES  ( '$siglaTurma', '$siglaCurso' , '$nome', '$matricula')";
    $stmt_insere = $conn->prepare($sql_insere);
    
    if ($stmt_insere->execute()) {
        echo "Aluno adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar o aluno: " . $stmt_insere->error;
    }

    $stmt_insere->close();
} else {
    // Matrícula não existe
    echo "A matrícula fornecida não existe no banco de dados.";
}

$stmt_verifica->close();
$conn->close();

?>
