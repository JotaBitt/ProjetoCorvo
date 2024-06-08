<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "4ads";

// Conexão com o banco de dados corvo_aluno
$conn_corvo = new mysqli($servername, $username, $password, $database );
if ($conn_corvo->connect_error) {
    die("Falha na conexão com o banco de dados corvo_aluno: " . $conn_corvo->connect_error);
}


// Matrícula do aluno a ser verificada e adicionada
$matricula = $_POST['matricula']; // Supondo que a matrícula seja enviada via POST
    $nome = $_POST["nome"];
    $rank = $_POST["rank"];
    $siglaCurso = $_POST["siglaCurso"];  // Código do curso a ser adicionado

// Verificar se a matrícula existe no banco de dados corvo_aluno
$sql_verifica = "SELECT * FROM corvo_aluno WHERE matricula = '$matricula'";
$stmt_verifica = $conn_corvo->prepare($sql_verifica);
// $stmt_verifica->bind_param("s", $matricula);
$stmt_verifica->execute();
$result_verifica = $stmt_verifica->get_result();

if ($result_verifica->num_rows > 0) {
    // Matrícula existe, então obter os dados do aluno
    $aluno = $result_verifica->fetch_assoc();

    // Preparar os dados para inserção no banco de dados curso

    

    // Adicione outros atributos conforme necessário

    // Inserir o aluno no banco de dados curso
    $sql_insere = "INSERT INTO corvo_curso_usuarios ( matricula, nome, rank, siglaCurso) VALUES ('$matricula', '$nome' , '$rank', '$siglaCurso')";
    $stmt_insere = $conn_corvo->prepare($sql_insere);
    // $stmt_insere->bind_param("ssss", $cpf, $nome, $matricula, $email, $telefone, $data_nascimento, $cod_curso);

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

?>
