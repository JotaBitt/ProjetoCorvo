<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "4ads";
$idTurma = 1; // ID do aluno que você quer buscar

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Define a query SQL para buscar os dados da tabela "corvo_atividades"
$sql = "SELECT atividade, data_entrega FROM corvo_atividades WHERE turma = 1";

// Executa a query e pega o resultado
$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Output dos dados de cada linha
} else {
    echo "0 resultados";
}

// Fecha a conexão
$conn->close();

?>

<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Marketing Digital - Corvo</title>
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        />
        <link rel="stylesheet" href="turma.css" />
        <link
            rel="shortcut icon"
            href="../../img/corvo-logo.ico"
            type="image/x-icon"
        />
    </head>
    <body class="bg-light">
        <!-- Header -->
        <header
            class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom"
        >
            <div class="logo">
                <a href="/">
                    <img
                        src="../../../img/corvo-logo.png"
                        width="70px"
                        alt="logo Corvo"
                        class="img-fluid"
                    />
                </a>
            </div>
            <div class="user-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mt-4">
            <div
                class="card mb-4 p-5 d-flex justify-content-start align-items-end"
                style="
                    background-image: url(../../cards/marketing-digital.png);
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
                    border-radius: 1rem;
                "
            >
                <div class="text-white">
                    <h2 class="card-title">Marketing Digital</h2>
                    <img
                        class="fotoProfessor"
                        src="../../../img/vegetti.png"
                        alt="foto professor"
                    />
                    <span>Pablo Vegetti</span>
                </div>
            </div>

            <nav class="nav justify-content-center mb-4">
                <a class="nav-link btn btn-primary mx-1" href="marketing.php"
                    >Mural</a
                >
                <a class="nav-link btn btn-outline-primary mx-1" href="notas.php"
                    >Notas</a
                >
                <a class="nav-link btn btn-outline-primary mx-1" href="presenca.php"
                    >Presença</a
                >
            </nav>

            <div class="row">
                <div class="col-3 mb-4">
                    <div class="card">
                        <div class="card-body bg-light">
                            <h6>Meet</h6>
                            <button type="button" class="btn btn-outline-success">Entrar em chamada</button>
                        </div>
                        <div class="card-body bg-light mt-4">
                            <h6>Atividades:</h6>
                            <p class="descricao">Não há atividades para a próxima semana</p>
                        </div>
                    </div>
                </div>
                <div class="col-9 mb-4">
                    <?php
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                        echo"
                        <div class='d-flex justify-content-between alert alert-dark'>
                            <span>". $row["atividade"] ."</span>
                            <span>". $row["data_entrega"] ."</span>
                        </div>";
                        } 
                    } else {
                        echo "0 resultados";
                    }

                    ?>
                </div>
            </div>
        </main>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script
            src="https://kit.fontawesome.com/387cf5e4a4.js"
            crossorigin="anonymous"
        ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <footer class="rodape">
            &copy; Copyright 2024 Todos os direitos reservados à Jota's Corp
        </footer>
    </body>
</html>
