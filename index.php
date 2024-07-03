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

// Preparar a consulta SQL com JOIN entre as tabelas corvo_usuarios_turma, corvo_cursos e corvo_turmas
$stmt = $conn->prepare("SELECT *, corvo_turmas.id AS idTurma FROM corvo_usuarios_turma INNER JOIN corvo_cursos ON corvo_usuarios_turma.siglaCurso = corvo_cursos.siglaCurso INNER JOIN corvo_turmas ON corvo_usuarios_turma.siglaTurma = corvo_turmas.siglaTurma WHERE matricula = :matricula");

// Ligar parâmetros
$stmt->bindParam(':matricula', $_SESSION['matricula']);

// Executar a consulta
$stmt->execute();

// Pegar todos os resultados
$usuariosTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Para cada resultado, conectar com as turmas
foreach ($usuariosTurma as $key => $turma) {

  $stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :matricula");

  $stmt->bindParam(':matricula', $turma['professor']);

  $stmt->execute();

  $professor = $stmt->fetch();

  $usuariosTurma[$key]["professor"] = $professor['nome'];
  $usuariosTurma[$key]["idTurma"] = $turma['idTurma'];
}

$stmt = $conn->prepare("SELECT * FROM corvo_turmas WHERE professor = :professor");
$stmt->bindParam(":professor", $_SESSION['matricula']);
$stmt->execute();

$professorTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($professorTurma as $key => $turma) {

  $stmt = $conn->prepare("SELECT * FROM corvo_cursos WHERE siglaCurso = :siglaCurso");
  $stmt->bindParam(":siglaCurso", $turma['siglaCurso']);
  $stmt->execute();

  $curso = $stmt->fetch();

  $stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :matricula");
  $stmt->bindParam(":matricula", $turma['professor']);

  $stmt->execute();

  $professor = $stmt->fetch();

  $curso['professor'] = $professor['nome'];
  $curso['idTurma'] = $turma['id'];

  array_push($usuariosTurma, $curso);
}

$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :matricula");
$stmt->bindParam(":matricula", $_SESSION['matricula']);
$stmt->execute();


$usuario = $stmt->fetch();


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
          echo '<div class="col">';
          echo '  <a href="'. $link .'/turmas/'.$turma['idTurma'].'">';
          echo '    <div';
          echo '      class="card h-75 pr-5 pl-3 py-4 w-100 text-white mb-3"';
          echo '      style="';
          echo '        background-image: url('.$turma['background'].');';
          echo '        background-repeat: no-repeat;';
          echo '        background-size: cover;';
          echo '      ">';
          echo '      <div class="card-body d-flex align-items-left flex-column position-relative">';
          echo '        <div class="fotoProf d-flex align-items-left">';
          echo '          <span class="nomeProfessor d-block">'.$turma['professor'].'</span>';
          echo '        </div>';
          echo '        <p class="card-title text-left materia-title h4">'.$turma['nome'].'</p>';
          echo '      </div>';
          echo '    </div>';
          echo '  </a>';
          echo '</div>';
          
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
  <?php require_once $link . '/assets/includes/footer.php'; ?>
</body>
</html>