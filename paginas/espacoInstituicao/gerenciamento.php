<?php

include '../../session.php';

$stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE id = :id");
$stmt->bindParam(":id", $_SESSION['id_usuario']);
$stmt->execute();

$usuario = $stmt->fetch();

if(!$usuario) {
  http_response_code(403);
  exit;
}



// Unidades registradas
// $stmt = $conn->prepare("SELECT * FROM corvo_unidades WHERE instituicao = :instituicao");
// $stmt->bindParam(":instituicao", $instituicao['id']);
$stmt = $conn->prepare("SELECT * FROM corvo_unidades");
$stmt->execute();
$quantidadeUnidades = $stmt->rowCount();
$unidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cursos registrados
// $stmt = $conn->prepare("SELECT * FROM corvo_cursos INNER JOIN corvo_unidades ON corvo_cursos.unidade = corvo_unidades.id WHERE corvo_unidades.instituicao = :instituicao");
// $stmt->bindParam(":instituicao", $instituicao['id']);
$stmt = $conn->prepare("SELECT * FROM corvo_cursos");
$stmt->execute();
$quantidadeCursos = $stmt->rowCount();
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Usuários registrados
$stmt = $conn->prepare("SELECT * FROM corvo_usuarios");
$stmt->execute();
$quantidadeUsuarios = $stmt->rowCount() - 1;


?>

<!doctype html>
<html lang="pt-BR">

<head>
  <title>Corvo - Gerenciamento</title>
  <?php include '../../assets/includes/head.php'; ?>
</head>

<body class="bg-light">
  <?php include '../../assets/includes/header_instituicao.php'; ?>
  <main class="container text-center py-4">
    <h1>Olá, <?= $_SESSION['nome_usuario'] ?></h1>
    <hr>
    <div class="card text-left mb-4 p-5">
      <div class="d-grid gap-2 d-md-flex justify-content-md-between">
        <h2 class="h4">Dados da instituição</h2>
      </div>
      <p class="text-muted">Aqui estão algumas informações sobre a sua instituição.</p>

      <div class="row mb-3">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title h2"><?= $quantidadeCursos ?></h5>
              <p class="card-text">cursos registrados</p>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title h2"><?= $quantidadeUsuarios ?></h5>
              <p class="card-text">usuários registrados</p>
            </div>
          </div>
        </div>
      </div>


      <hr class="my-3">

      <!-- <h3 class="h4 mb-3">Atividades dos alunos</h3>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Aluno</th>
            <th>Nota</th>
            <th>Entregue em</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table> -->
    </div>
  </main>
  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>
  <?php include '../../assets/includes/footer.php'; ?>
</body>

</html>