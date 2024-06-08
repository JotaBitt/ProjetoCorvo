<?php 
include '../../session.php';
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <?php require_once "../../assets/includes/head.php"; ?>
  <title>Corvo - Gerenciamento</title>
  <style>
    .materia-title {
      position: relative;
      bottom: 0;
      left: 0;
    }
  </style>
  <script>
    function listarProfessores() {
      document.getElementById("tabela-body").innerHTML = "";
      document.getElementById("tabela").style.display = "table";
      document.getElementById("formAlterar").style.display = "none";
      document.getElementById("formAdicionar").style.display = "none";
      
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          let objReturnJSON = JSON.parse(this.responseText);
          for (let i = 0; i < objReturnJSON.length; i++) {
            CriarLinhaTabela(objReturnJSON[i]);
          }
        }
      };
      xmlhttp.open("POST", "listarProfessor.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send();
    }

    function exibirAdicionar() {
      document.getElementById("formAdicionar").style.display = "block";
      document.getElementById("tabela").style.display = "none";
      document.getElementById("formAlterar").style.display = "none";
    }

    function adicionarProfessor() {
      let cpfAd = document.getElementById("cpfAd").value;
      let nomeAd = document.getElementById("nomeAd").value;
      let matriculaAd = document.getElementById("matriculaAd").value;
      let emailAd = document.getElementById("emailAd").value;
      let telefoneAd = document.getElementById("telefoneAd").value;
      let data_nascimentoAd = document.getElementById("data_nascimentoAd").value;
      let data_contratacaoAd = document.getElementById("data_contratacaoAd").value;

      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("msg").innerHTML = "Adicionado";
          listarProfessores();
        }
      };
      xmlhttp.open("POST", "adicionarProfessor.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("cpf=" + cpfAd + "&nome=" + nomeAd + "&matricula=" + matriculaAd + "&email=" + emailAd + "&telefone=" + telefoneAd + "&data_nascimento=" + data_nascimentoAd + "&data_contratacao=" + data_contratacaoAd);
    }

    function exibirFormularioAlterar(cpf, nome, matricula, email, telefone, data_nascimento, data_contratacao) {
      document.getElementById("formAlterar").style.display = "block";
      document.getElementById("cpf").value = cpf;
      document.getElementById("nome").value = nome;
      document.getElementById("matricula").value = matricula;
      document.getElementById("email").value = email;
      document.getElementById("telefone").value = telefone;
      document.getElementById("data_nascimento").value = data_nascimento;
      document.getElementById("data_contratacao").value = data_contratacao;
    }

    function excluirProfessores(cpf) {
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("msg").innerHTML = "Excluido";
          listarProfessores();
        }
      };
      xmlhttp.open("POST", "excluirProfessor.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("cpf=" + cpf);
    }

    function CriarCabecalhoTabela() {
      let table = document.getElementById("tabela-head");
      let tr = document.createElement("tr");
      let headers = ["Nome", "Matricula", "CPF", "Email", "Telefone", "Data de Nascimento", "Data de Contratação", "Alterar", "Excluir"];
      headers.forEach(header => {
        let th = document.createElement("th");
        th.textContent = header;
        th.scope = "col";
        tr.appendChild(th);
      });
      table.appendChild(tr);
    }

    function CriarLinhaTabela(professor) {
      let table = document.getElementById("tabela-body");
      document.getElementById("tabela").style = "display: table;";
      let tr = document.createElement("tr");

      let campos = ["nome", "matricula", "cpf", "email", "telefone", "data_nascimento", "data_contratacao"];
      campos.forEach(campo => {
        let td = document.createElement("td");
        td.textContent = professor[campo];
        tr.appendChild(td);
      });

      let tdAlterar = document.createElement("td");
      let btnAlterar = document.createElement("button");
      btnAlterar.className = "btn btn-warning";
      btnAlterar.textContent = "Alterar Dados";
      btnAlterar.addEventListener("click", function() {
        exibirFormularioAlterar(professor.cpf, professor.nome, professor.matricula, professor.email, professor.telefone, professor.data_nascimento, professor.data_contratacao);
      });
      tdAlterar.appendChild(btnAlterar);
      tr.appendChild(tdAlterar);

      let tdExcluir = document.createElement("td");
      let btnExcluir = document.createElement("button");
      btnExcluir.className = "btn btn-danger";
      btnExcluir.textContent = "Excluir";
      btnExcluir.addEventListener("click", function() {
        excluirProfessores(professor.cpf);
      });
      tdExcluir.appendChild(btnExcluir);
      tr.appendChild(tdExcluir);

      table.appendChild(tr);
    }

    function alterarDados() {
      let cpf = document.getElementById("cpf").value;
      let nome = document.getElementById("nome").value;
      let matricula = document.getElementById("matricula").value;
      let email = document.getElementById("email").value;
      let telefone = document.getElementById("telefone").value;
      let data_nascimento = document.getElementById("data_nascimento").value;
      let data_contratacao = document.getElementById("data_contratacao").value;

      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("msg").innerHTML = "Alterado";
          listarProfessores();
        }
      };
      xmlhttp.open("POST", "alterarDadosProfessor.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("cpf=" + cpf + "&nome=" + nome + "&matricula=" + matricula + "&email=" + email + "&telefone=" + telefone + "&data_nascimento=" + data_nascimento + "&data_contratacao=" + data_contratacao);
    }

    window.onload = function() {
      CriarCabecalhoTabela();
    };
  </script>
</head>

<body class="bg-light">

<header class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom"><a
      href="index.html">
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
  
  <main class="container mt-4">
    <div class="card card-body">
      <div class="container my-3">
        <h2 class="card-title">Professores</h2>
        <p class="card-text">Gerencie os professores de sua unidade</p>
      </div>
      <div class="container my-3">
        <h1>Listar Professores</h1>
        <button class="btn btn-primary my-2" onclick="listarProfessores()">Listar Todos os Professores</button>
        <button class="btn btn-secondary my-2" onclick="exibirAdicionar()">Adicionar Professores</button>
        <table id="tabela" class="table table-striped mt-3" style="display:none;">
          <thead id="tabela-head"></thead>
          <tbody id="tabela-body"></tbody>
        </table>
        <h4 id="msg"></h4>
        <form id="formAlterar" style="display: none;" class="mt-3">
          <input type="hidden" id="cpf">
          <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome">
          </div>
          <div class="form-group">
            <label for="matricula">Matricula:</label>
            <input type="text" class="form-control" id="matricula">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" id="telefone">
          </div>
          <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nascimento">
          </div>
          <div class="form-group">
            <label for="data_contratacao">Data de Contratação:</label>
            <input type="date" class="form-control" id="data_contratacao">
          </div>
          <button type="button" class="btn btn-primary mt-2" onclick="alterarDados()">Alterar Dados</button>
        </form>
        <form id="formAdicionar" style="display: none;" class="mt-3">
          <div class="form-group">
            <label for="nomeAd">Nome:</label>
            <input type="text" class="form-control" id="nomeAd">
          </div>
          <div class="form-group">
            <label for="matriculaAd">Matricula:</label>
            <input type="text" class="form-control" id="matriculaAd">
          </div>
          <div class="form-group">
            <label for="cpfAd">CPF:</label>
            <input type="text" class="form-control" id="cpfAd">
          </div>
          <div class="form-group">
            <label for="emailAd">Email:</label>
            <input type="email" class="form-control" id="emailAd">
          </div>
          <div class="form-group">
            <label for="telefoneAd">Telefone:</label>
            <input type="text" class="form-control" id="telefoneAd">
          </div>
          <div class="form-group">
            <label for="data_nascimentoAd">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nascimentoAd">
          </div>
          <div class="form-group">
            <label for="data_contratacaoAd">Data de Contratação:</label>
            <input type="date" class="form-control" id="data_contratacaoAd">
          </div>
          <button type="button" class="btn btn-primary mt-2" onclick="adicionarProfessor()">Adicionar Professor</button>
        </form>
      </div>
    </div>
  </main>

  
  <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
         <div class="container">
             <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
         </div>
    </footer>
 
</body>

</html>
