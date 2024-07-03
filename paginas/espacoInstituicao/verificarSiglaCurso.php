<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname_corvo = "corvo_aluno";
$dbname_curso = "4ads";


// Conexão com o banco de dados curso
$conn_curso = new mysqli($servername, $username, $password, $dbname_curso);
if ($conn_curso->connect_error) {
    die("Falha na conexão com o banco de dados curso: " . $conn_curso->connect_error);
}

$cod_curso = $_POST['cod_curso']; // Código do curso a ser adicionado

// Verificar se a matrícula existe no banco de dados corvo_aluno
$sql_verifica = "SELECT * FROM corvo_cursos WHERE siglaCurso = '$cod_curso'";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("s", $cod_curso);
$stmt_verifica->execute();
$result_verifica = $stmt_verifica->get_result();

if ($result_verifica->num_rows > 0) {
    // Matrícula existe, então obter os dados do aluno
    $aluno = $result_verifica->fetch_assoc();

    // Preparar os dados para inserção no banco de dados curso
    
    $cpf = $aluno["cpf"];
    $nome = $aluno["nome"];
    $matricula = $aluno["matricula"];
    $email = $aluno["email"];
    $telefone = $aluno["telefone"];
    $data_nascimento = $aluno["data_nascimento"];
    // Adicione outros atributos conforme necessário

    // Inserir o aluno no banco de dados curso
    $sql_insere = "INSERT INTO curso (cpf, nome, matricula, email, telefone, data_nascimento, cod_curso) VALUES ('$cpf', '$nome', '$matricula' , '$email', '$telefone', '$data_nascimento', '$cod_curso')";
    $stmt_insere = $conn_curso->prepare($sql_insere);
    $stmt_insere->bind_param("ssss", $cpf, $nome, $matricula, $email, $telefone, $data_nascimento, $cod_curso);

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
$conn_curso->close();
?>
