<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto-corvo";
$id = 1; // ID do aluno que você quer buscar

try {
    // Criar conexão PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Configurar PDO para lançar exceções em caso de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Preparar a consulta SQL
    $sql = "SELECT atividade, nota FROM corvo_notas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    
    // Ligar parâmetros
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Executar a consulta
    $stmt->execute();
    
    // Pegar todos os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        foreach ($resultados as $resultado) {
            $atividade = $resultado['atividade']; 
            $nota = $resultado['nota'];
            $media = 0;
        }
    } else {
        echo "Nenhum resultado encontrado para o aluno com ID $id.";
    }
}
catch(PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
}

// Fechar a conexão
$conn = null;
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
        <link rel="stylesheet" href="../../turma.css" />
        <link
            rel="shortcut icon"
            href="../../assets/img/corvo-logo.ico"
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
                        src="../../img/corvo-logo.png"
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
        <main class="container mt-4">
                    <div
                        class="card mb-4 p-5 d-flex justify-content-start align-items-end"
                        style="
                            background-image: url(/assets/cards/marketing-digital.png);
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
                                src="../../img/vegetti.png"
                                alt="foto professor"
                            />
                            <span>Pablo Vegetti</span>
                        </div>
                    </div>

                    <nav class="nav justify-content-center mb-4">
                        <a class="nav-link btn btn-outline-primary mx-1" href="marketing.php"
                            >Mural</a
                        >
                        <a class="nav-link btn btn-primary mx-1" href="notas.php"
                            >Notas</a
                        >
                        <a class="nav-link btn btn-outline-primary mx-1" href="presenca.php"
                            >Presença</a
                        >
                    </nav>

                    <table class="table table-dark table-hover">
                        <thead>
                            <th>Atividade</th>
                            <th>Nota</th>
                            <th>Media</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $atividade ?></td>
                                <td><?php echo $nota ?></td>
                                <td><?php echo $media ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="espaco"></div>
                </main>

                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                <script
                    src="https://kit.fontawesome.com/387cf5e4a4.js"
                    crossorigin="anonymous"
                ></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <footer class="rodape espaco">
                    &copy; Copyright 2024 Todos os direitos reservados à Jota's Corp
                </footer>
            </body>
        </html>