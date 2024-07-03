<?php
include 'session.php';

// Verificando se é dia, tarde, noite ou madrugada
date_default_timezone_set('America/Sao_Paulo');

$hora = date('H');

if ($hora >= 6 && $hora < 12) {
  $hello = "Bom dia,";
} elseif ($hora >= 12 && $hora < 18) {
  $hello = "Boa tarde,";
} elseif ($hora >= 18 && $hora < 24) {
  $hello = "Boa noite,";
} else {
  $hello = "Boa madrugada,";
}

// Preparar a consulta SQL
$stmt = $conn->prepare("SELECT * FROM corvo_usuarios_turma JOIN corvo_cursos ON corvo_usuarios_turma.siglaCurso = corvo_cursos.siglaCurso WHERE usuario = :usuario");

// Ligar parâmetros
$stmt->bindParam(':usuario', $_SESSION['usuario'], PDO::PARAM_INT);

// Executar a consulta
$stmt->execute();

// Pegar todos os resultados
$usuariosTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Para cada resultado, conectar com as turmas
foreach ($usuariosTurma as $key => $turma) {
  $stmt = $conn->prepare("SELECT * FROM corvo_turmas WHERE corvo_turmas.id = :id");

  $stmt->bindParam(':id', $turma['turma'], PDO::PARAM_INT);

  $stmt->execute();

  $turma = $stmt->fetch();
}


// Fechar a conexão
$conn = null;
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <?php include 'assets/includes/head.php'; ?>
  <title>Corvo - Início</title>
  <link rel="stylesheet" href="<?= $link ?>/assets/css/index.css" />
</head>

<body class="bg-light">
  <?php include 'assets/includes/header.php'; ?>
  <main class="container text-center py-4">
    <h1 class="mb-4"><?= $hello ?> <?= $_SESSION['nome_usuario'] ?></h1>
    <hr />
    <div class="row justify-content-center">
      <?php

      if ($usuariosTurma) {
        foreach ($usuariosTurma as $key => $turma) {

          if($key % 3 == 0) {
            echo '<div class="row justify-content-center">';
          } 
          echo '<div class="col">
          <a href="paginas/espacoAluno/marketing.php">
          <div
            class="card h-75 w-100 text-white mb-3"
            style="
              background-image: url(./assets/cards/marketing-digital.png);
              background-repeat: no-repeat;
              background-size: cover;
            ">
            
            <div class="card-body position-relative">
              <div class="fotoProf">
                <img src="./img/vegetti.png" alt="foto professor"/>
                <span class="nomeProfessor">Pablo Vegetti</span>
              </div>
                
              <h2
                class="card-title materia-title"
              >
                Marketing Digital
              </h2>
            </div>
          </div>
          </a>
        </div>';
          
          if($key % 3 == 2) {
            echo '</div>';
          }
        }
      } else {
        echo '<div class="col-12">
          <p>Você ainda não está matriculado em nenhuma turma.</p>
        </div>';
      }

      ?>
    </div>
  </main>
  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>
  <footer class="rodape">
    &copy; Copyright 2024 Todos os direitos reservados à Jota's Corp
  </footer>
</body>

</html>