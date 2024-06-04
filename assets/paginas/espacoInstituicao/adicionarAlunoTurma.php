<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname_corvo = "corvo_aluno";
$dbname_turma = "4ads";

// Conexão com o banco de dados corvo_aluno
$conn_corvo = new mysqli($servername, $username, $password, $dbname_corvo);
if ($conn_corvo->connect_error) {
    die("Falha na conexão com o banco de dados corvo_aluno: " . $conn_corvo->connect_error);
}

// Conexão com o banco de dados turma
$conn_turma = new mysqli($servername, $username, $password, $dbname_turma);
if ($conn_turma->connect_error) {
    die("Falha na conexão com o banco de dados turma: " . $conn_turma->connect_error);
}

// Matrícula do aluno a ser verificada e adicionada
$matricula = $_POST['matricula'];  // Supondo que a matrícula seja enviada via POST
$cod_turma = $_POST['cod_turma'];  // Supondo que o código da turma seja enviado via POST       

// Verificar se a matrícula existe no banco de dados corvo_aluno
$sql_verifica = "SELECT * FROM curso WHERE matricula = '$matricula'";
$stmt_verifica = $conn_corvo->prepare($sql_verifica);
$stmt_verifica->bind_param("s", $matricula);
$stmt_verifica->execute();
$result_verifica = $stmt_verifica->get_result();

if ($result_verifica->num_rows > 0) {
    // Matrícula existe, então obter os dados do aluno
    $aluno = $result_verifica->fetch_assoc();

    // Preparar os dados para inserção no banco de dados turma
    $cpf = $aluno["cpf"];
    $nome = $aluno["nome"];
    $matricula = $aluno["matricula"];
    $email = $aluno["email"];
    $telefone = $aluno["telefone"];
    $data_nascimento = $aluno["data_nascimento"];
    $cod_curso = $aluno["cod_curso"];
    // Adicione outros atributos conforme necessário

    // Inserir o aluno no banco de dados turma
    $sql_insere = "INSERT INTO turma (cpf, nome, matricula, email, telefone, data_nascimento, cod_curso, cod_turma) VALUES  ('$cpf', '$nome', '$matricula' , '$email', '$telefone', '$data_nascimento', '$cod_curso', '$cod_turma')";
    $stmt_insere = $conn_turma->prepare($sql_insere);
    $stmt_insere->bind_param("ssss", $cpf, $nome, $matricula, $email, $telefone, $data_nascimento, $cod_curso, $cod_turma);

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
$conn_corvo->close();
$conn_turma->close();
?>
