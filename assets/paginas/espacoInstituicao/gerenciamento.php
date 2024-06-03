<?php 

include '../../session.php';

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Corvo - Gerenciamento</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="../../assets/img/corvo-logo.ico" type="image/x-icon" />
  <style>
    .materia-title {
      position: relative;
      bottom: 0;
      left: 0;
    }
  </style>
</head>

<body class="bg-light">
  <header class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom"><a
      href="/">
      <div class="logo">
        <img src="../../img/corvo-logo.png" width="70px" alt="logo Corvo" class="img-fluid" />
      </div>
    </a>
    <div class="d-none">
      <a href="login.php">
        <span>Login</span>
      </a>
      <a href="Cadastro.html">
        <span>Cadastre-se </span>
      </a>
    </div>
    <div class="user-icon">
      <i class="fas fa-user-circle" style="font-size: 36px"></i>
    </div>
  </header>
  <main class="container text-center py-4">
    <div class="row justify-content-center" style="margin-top: 200px">
      <div class="col-3 mb-2">
        <a href="crudAluno.php">
          <div class="card h-75 w-100 text-white p-3" style="
              background-image: url(/assets/cards/marketing-digital.png);
              background-repeat: no-repeat;
              background-size: cover;
            ">
            <div class="card-body position-relative">
              <h2 class="card-title materia-title">
                Aluno
              </h2>
            </div>
          </div>
        </a>
      </div>
      <div class="col-3 mb-2">
        <a href="crudProfessor.php">
        <div class="card h-75 w-100 text-white mb-3 p-3 px-4" style="
              background-image: url(/assets/cards/libras-basico.png);
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
        <div class="card h-75 w-100 text-white mb-3 p-3 px-4" style="
              background-image: url(/assets/cards/programacao-java.png);
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
          <div class="card h-75 w-100 text-white mb-3 p-3 px-4" style="
                  background-image: url(/assets/cards/programacao-java.png);
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
  </main>
  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>
    <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
         <div class="container">
             <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
         </div>
    </footer>
</body>
</html>