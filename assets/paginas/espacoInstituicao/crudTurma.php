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
  <!-- <link rel="stylesheet" href="style.css" /> -->
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
  <main class="container text-center py-4">
    <div class="card card-body">

        <div class="container my-3">
            <h2 class="card-title">Turmas</h2>
            <p class="card-text">Gerencie os turmas de sua unidade</p>
        </div>
        <!-- Menu de Opções -->

        <!-- Tabela de Notas -->
        <!-- <div class="container my-3"> -->
            <!-- Menu de Opções -->

            <!-- Tabela de Notas -->
            <!-- <div class="container my-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Pesquisar turma"
                        aria-label="Pesquisar turma" aria-describedby="button-addon2">
                    <button class="btn btn-secondary" type="button" id="button-addon2">Pesquisar</button>
               </div>  -->
                
                
<h1>Listar Usuarios </h1>

<form action="javascript:listarUsuarios();" method="POST" id="formSiglaCurso" style="display:block;">

    Digite a Sigla do Curso: <input type="text" name="siglaCurso" id="siglaCurso"><br><br>

    <button>Listar Usuarios </button>

</form>


<!-- <button onclick="listarUsuarios()">uaua</button>
<br><br>
<button onclick="exibirAdicionar()">Adicionar Turmas</button>
<br><br> -->

<table id="tabela" class="table table-striped">
  
</table>
<h4 id="msg"></h4>
<br>

  <!-- <form action="" method="POST" id="formAlterar" style="display: none;">
  
  <input type="hidden" name="cpf" id="cpf">

  Nome: <input type="text" name="nome" id="nome"><br><br>
  Matricula: <input type="text" name="matricula" id="matricula"><br><br>
  Email: <input type="text" name="email" id="email"><br><br>
  Telefone: <input type="text" name="telefone" id="telefone"><br><br>
  Data de nascimento: <input type="date" name="data_nascimento" id="data_nascimento"><br><br>

    <input type="button" value="Alterar" id="Alterar" onclick="alterarDados()">
  </form>

  <form action="" method="POST" id="formAdicionar" style="display: none;">

    Nome: <input type="text" name="nome" id="nome"><br><br>
    Matricula: <input type="text" name="matricula" id="matricula"><br><br>
    Sigla Curso: <input type="text" name="codTurma" id="codTurma"><br><br>
    Sigla Turma: <input type="text" name="codSigla" id="codSigla"><br><br>
    Rank: <br>
          <input type="radio" name="rank" id="Professor" value="Professor">
            <label for="Professor">Professor</label><br>
          <input type="radio" name="rank" id="Aluno" value="Aluno">
            <label for="Aluno">Aluno</label><br>


    <input type="button" value="inserir" id="inserir" onclick="adicionarTurma()"> -->

    
  </form>


        </div>
    </div>
  </main>

  <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
         <div class="container">
             <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
         </div>
  </footer>

  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>

    <script>
    function listarUsuarios() {

      let siglaCurso = document.getElementById("siglaCurso").value;

      document.getElementById("tabela").innerHTML = "";
      document.getElementById("tabela").style.display = "inline-block";
      document.getElementById("formSiglaCurso").style.display = "none";
      
      let xmlhttp = new XMLHttpRequest();
      console.log("1");
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Chegou a resposta OK: " + this.responseText);
          console.log("2");
          let objReturnJSON = JSON.parse(this.responseText);
          console.log("Resposta: " + this.responseText);
          for ($i=0; $i<objReturnJSON.length; $i++) {
            let $linha = objReturnJSON[$i];
            CriarLinhaTabela(objReturnJSON[$i]);
          }
        } else
        if (this.readyState < 4) {
          console.log("3: " + this.readyState);
        } else
          console.log("Requisicao falhou: " + this.status);
      }
      console.log("4");
      xmlhttp.open("POST", "listarUsuariosCurso.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&siglaCurso=" + siglaCurso);
      console.log("enviei request get");
      console.log("5");
      CriarCabecalhoTabela();
    }

    function exibirAdicionar(){

      document.getElementById("formAdicionar").style.display = "inline-block";
      document.getElementById("tabela").style.display = "none";
      document.getElementById("formAlterar").style.display = "none";
      
    }

    function adicionarTurma(matricula, siglaTurma, nome, rank, siglaCurso){

      let xmlhttp = new XMLHttpRequest();
      console.log("1");
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Chegou a resposta OK: " + this.responseText);
          console.log("2");
        } else
        if (this.readyState < 4) {
          console.log("3: " + this.readyState);
        } else
          console.log("Requisicao falhou: " + this.status);
      }
      console.log("4");
      xmlhttp.open("POST", "adicionarAlunoTurma.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
      xmlhttp.send("&matricula=" + matricula + "&nome=" + nome + "&siglaTurma=" + siglaTurma +"&rank=" + rank + "&siglaCurso=" + siglaCurso);
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Adicionado";

      document.getElementById("formAdicionar").style.display = "none";
      listarUsuarios();

    }

    function exibirFormularioAlterar(cpf, nome, matricula, email, telefone, data_nascimento){

      document.getElementById("formAlterar").style.display = "block";

      document.getElementById("cpf").value = cpf;
      document.getElementById("nome").value = nome;
      document.getElementById("matricula").value = matricula;
      document.getElementById("email").value = email;
      document.getElementById("telefone").value = telefone;
      document.getElementById("data_nascimento").value = data_nascimento;
    }

    function excluirTurmas(cpf2){
      
      let xmlhttp = new XMLHttpRequest();
      console.log("1");
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Chegou a resposta OK: " + this.responseText);
          console.log("2");
        } else
        if (this.readyState < 4) {
          console.log("3: " + this.readyState);
        } else
          console.log("Requisicao falhou: " + this.status);
      }
      console.log("4");
      xmlhttp.open("POST", "excluirTurma.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&cpf=" + cpf2);
      console.log(xmlhttp);
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Excluido";
      listarUsuarios();

    }


    function CriarCabecalhoTabela(){

      let table = document.getElementById("tabela");

      let tr = document.createElement("tr");

      let th1 = document.createElement("th");
      th1.textContent = "nome";
      tr.appendChild(th1);

      let th2 = document.createElement("th");
      th2.textContent = "matricula";
      tr.appendChild(th2);

      let th3 = document.createElement("th");
      th3.textContent = "rank";
      tr.appendChild(th3);

      let th4 = document.createElement("th");
      th4.textContent = "siglaCurso";
      tr.appendChild(th4);

      let th7 = document.createElement("th");
      th7.textContent = "Adicionar";
      tr.appendChild(th7);

      table.appendChild(tr);

    }
    function CriarLinhaTabela(pobjReturnJSON) {

    let table = document.getElementById("tabela");
    document.getElementById("tabela").style = "display: inline-block;  border: solid black 1px;"
    let tr = document.createElement("tr");
    table.appendChild(tr);

    let td = document.createElement("td");
    let textNode = document.createTextNode(pobjReturnJSON.nome);
    td.appendChild(textNode);
    tr.appendChild(td);

    let td2 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.matricula);
    td2.appendChild(textnode);
    tr.appendChild(td2); 

    let td3 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.rank);
    td3.appendChild(textnode);
    tr.appendChild(td3); 

    let td4 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.siglaCurso);
    td4.appendChild(textnode);
    tr.appendChild(td4); 


    let td7 = document.createElement("td");
      
    let textbox = document.createElement("input");
    textbox.type = "text";
    textbox.id = "inputTextBox";
    td7.appendChild(textbox);

   
    let btnAdicionar = document.createElement("button");
    btnAdicionar.textContent = "Adicionar";

    btnAdicionar.addEventListener("click", function(){

      let siglaTurma = textbox.value;
      adicionarTurma(pobjReturnJSON.matricula, siglaTurma, pobjReturnJSON.nome, pobjReturnJSON.rank, pobjReturnJSON.siglaCurso);
    });
    td7.appendChild(btnAdicionar);
    tr.appendChild(td7);


    }


    function alterarDados(){

      document.getElementById("formAlterar").style.display = "none";
      document.getElementById("tabela").style.display = "none";
      document.getElementById("formAdicionar").style.display = "none";
      

      let cpf = document.getElementById("cpf").value;
      let nome = document.getElementById("nome").value;
      let matricula = document.getElementById("matricula").value;
      let email = document.getElementById("email").value;
      let telefone = document.getElementById("telefone").value;
      let data_nascimento = document.getElementById("data_nascimento").value;

      let xmlhttp = new XMLHttpRequest();
      console.log("1");
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Chegou a resposta OK: " + this.responseText);
          console.log("2");
        } else
        if (this.readyState < 4) {
          console.log("3: " + this.readyState);
        } else
          console.log("Requisicao falhou: " + this.status);
      }
      console.log("4");
      xmlhttp.open("POST", "alterarDados.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&cpf=" + cpf + "&nome=" + nome + "&matricula=" + matricula + "&email=" + email + "&telefone=" + telefone + "&data_nascimento=" + data_nascimento);
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Alterado";

      listarUsuarios();

    }

  </script>
</body>
</html>