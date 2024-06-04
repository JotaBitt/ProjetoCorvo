<?php 

include 'session.php';

?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Corvo - Início</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="style.css" />
    <!-- Favicon -->
    <link
      rel="shortcut icon"
      href="assets/img/corvo-logo.ico"
      type="image/x-icon"
    />
    <style>
      .materia-title {
        position: relative;
        bottom: 0;
        left: 0;
      }

      .nomeProfessor {
        font-size: 13px;
      }

      .fotoProfessor > img {
        width: 20px;
        height: 20px;
      }
    </style>
  </head>
  <body class="bg-light">
    <header
      class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom"
    ><a href="index.html">
          <div class="logo">
              <img
                  src="img/corvo-logo.png"
                  width="70px"
                  alt="logo Corvo"
                  class="img-fluid"
              />
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
      <h1 class="mb-4">Bom dia, José Wilson!</h1>
      <div class="alert alert-warning p-3" role="alert">
        ⚠️ Você possui atividades pendentes para serem entregues nesta semana.
        <a href="#" class="alert-link">Clique aqui para ver.</a>
      </div>
      <hr />
      <div class="row justify-content-center">
        <div class="col-md-4 mb-2">
          <a href="marketing.php">
          <div
            class="card h-75 w-100 text-white p-3"
            style="
              background-image: url(./assets/cards/marketing-digital.png);
              background-repeat: no-repeat;
              background-size: cover;
            "
          >
            
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
              <span
                class="badge badge-danger position-absolute"
                style="top: -10px; right: -10px; width: 15px"
                >!</span
              >
            </div>
          </div>
          </a>
        </div>
        <div class="col-md-4 mb-2">
          
          <div
            class="card h-75 w-100 text-white mb-3 p-3 px-4"
            style="
              background-image: url(./assets/cards/libras-basico.png);
              background-repeat: no-repeat;
              background-size: cover;
            "
          >
            <div class="card-body position-relative">
              <div class="fotoProf">
                <img src="img/Edmundo.webp" alt="Edmundo" />
                <span class="nomeProfessor">Edmundo</span>
              </div>
              <h2
                class="card-title materia-title"
              >
                Libras (Básico)
              </h2>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-2">
          
          <div
            class="card h-75 w-100 text-white mb-3 p-3 px-4"
            style="
              background-image: url(./assets/cards/programacao-java.png);
              background-repeat: no-repeat;
              background-size: cover;
            "
          >
            <div class="card-body position-relative">
              <div class="fotoProf">
                <img src="img/andreBalada.webp" alt="André Balada" />
                <span class="nomeProfessor">André Balada</span>
              </div>
              <h2
                class="card-title materia-title"
              >
                Programação em Java
              </h2>
            </div>
          </div>
          
          <!-- <div
            class="card h-75 w-100 bg-info text-white mb-3 p-3 px-4"
            style="
              background-image: url(/assets/cards/libras-basico.png);
              background-repeat: no-repeat;
              background-size: cover;
            "
          >
            <div class="card-body">
              <div class="fotoProf">
                <img src="img/Edmundo.webp" alt="foto professor" />
                <span class="nomeProfessor">Edmundo</span>
              </div>
              <h2 class="card-title materia-title">Libras (Básico)</h2>
            </div>
          </div> -->
        </div>
    </main>
    <!-- Scripts -->
    <script
      src="https://kit.fontawesome.com/387cf5e4a4.js"
      crossorigin="anonymous"
    ></script>
    <footer class="rodape">
            &copy; Copyright 2024 Todos os direitos reservados à Jota's Corp
    </footer>
  </body>
</html>
