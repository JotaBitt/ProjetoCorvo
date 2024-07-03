<?php

include '../../session.php';

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
    <div class="row justify-content-center" style="margin-top: 200px">
      <div class="col-3 mb-2">
        <a href="crudAluno.php">
          <div class="card h-75 w-100  mb-3 p-3 px-4" style="
              background-repeat: no-repeat;
              background-size: cover;
            ">
            <div class="card-body position-relative">
              <h2 class="card-title materia-title">
                Aluno
              </h2>
            </div>
          </div>
      </div>
      <div class="col-3 mb-2">
        <a href="crudProfessor.php">
          <div class="card h-75 w-100  mb-3 p-3 px-4" style="
              background-repeat: no-repeat;
              background-size: cover;
            ">
            <div class="card-body position-relative">
              <h2 class="card-title materia-title">
                Professor
              </h2>
            </div>
          </div>
      </div>
      <div class="col-3 mb-2">
        <a href="crudCurso.php">
          <div class="card h-75 w-100  mb-3 p-3 px-4" style="
              background-repeat: no-repeat;
              background-size: cover;
            ">
            <div class="card-body position-relative">
              <h2 class="card-title materia-title">
                Curso
              </h2>
            </div>
          </div>
      </div>
      <div class="col-3 mb-2">
        <a href="crudTurma.php">
          <div class="card h-75 w-100  mb-3 p-3 px-4" style="
                  background-repeat: no-repeat;
                  background-size: cover;
                ">
            <div class="card-body position-relative">
              <h2 class="card-title materia-title">
                Turma
              </h2>
            </div>
          </div>
      </div>
      <div class="col-3 mb-2">
        <a href="crudAula.php">
          <div class="card h-75 w-100  mb-3 p-3 px-4" style="
                  background-repeat: no-repeat;
                  background-size: cover;
                ">
            <div class="card-body position-relative">
              <h2 class="card-title materia-title">
                Aula
              </h2>
            </div>
          </div>
      </div>
  </main>
  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>
  <?php include '../../assets/includes/footer.php'; ?>
</body>

</html>