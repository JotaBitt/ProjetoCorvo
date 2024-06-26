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

      <script>
    function listarProfessores() {

      document.getElementById("tabela").innerHTML = "";
      document.getElementById("tabela").style.display = "inline-block";
      document.getElementById("formAlterar").style.display = "none";
      document.getElementById("formAdicionar").style.display = "none";
      
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
      xmlhttp.open("POST", "listarProfessor.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send();
      console.log("enviei request get");
      console.log("5");
      CriarCabecalhoTabela();
    }

    function exibirAdicionar(){

      document.getElementById("formAdicionar").style.display = "inline-block";
      document.getElementById("tabela").style.display = "none";
      document.getElementById("formAlterar").style.display = "none";
      
    }

    function adicionarProfessor(){

      let cpfAd = document.getElementById("cpfAd").value;
      let nomeAd = document.getElementById("nomeAd").value;
      let matriculaAd = document.getElementById("matriculaAd").value;
      let emailAd = document.getElementById("emailAd").value;
      let telefoneAd = document.getElementById("telefoneAd").value;
      let data_nascimentoAd = document.getElementById("data_nascimentoAd").value;
      let data_contratacaoAd = document.getElementById("data_contratacaoAd").value;

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
      xmlhttp.open("POST", "adicionarProfessor.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&cpf=" + cpfAd + "&nome=" + nomeAd + "&matricula=" + matriculaAd + "&email=" + emailAd + "&telefone=" + telefoneAd + "&data_nascimento=" + data_nascimentoAd + "&data_contratacao=" + data_contratacaoAd);
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Adicionado";

      document.getElementById("formAdicionar").style.display = "none";
      listarProfessores();

    }

    function exibirFormularioAlterar(cpf, nome, matricula, email, telefone, data_nascimento, data_contratacao){

      document.getElementById("formAlterar").style.display = "block";

      document.getElementById("cpf").value = cpf;
      document.getElementById("nome").value = nome;
      document.getElementById("matricula").value = matricula;
      document.getElementById("email").value = email;
      document.getElementById("telefone").value = telefone;
      document.getElementById("data_nascimento").value = data_nascimento;
      document.getElementById("data_contratacao").value = data_contratacao;
    }

    function excluirProfessores(cpf2){
      
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
      xmlhttp.open("POST", "excluirProfessor.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&cpf=" + cpf2);
      console.log(xmlhttp);
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Excluido";

      
      listarProfessores();

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
      th3.textContent = "cpf";
      tr.appendChild(th3);

      let th4 = document.createElement("th");
      th4.textContent = "email";
      tr.appendChild(th4);

      let th5 = document.createElement("th");
      th5.textContent = "telefone";
      tr.appendChild(th5);

      let th6 = document.createElement("th");
      th6.textContent = "data_nascimento";
      tr.appendChild(th6);

      let th7 = document.createElement("th");
      th7.textContent = "Data de Contratação";
      tr.appendChild(th7);

      let th8 = document.createElement("th");
      th8.textContent = "Alterar";
      tr.appendChild(th8);

      let th9 = document.createElement("th");
      th9.textContent = "Excluir";
      tr.appendChild(th9);


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
    textnode = document.createTextNode(pobjReturnJSON.cpf);
    td3.appendChild(textnode);
    tr.appendChild(td3); 

    let td4 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.email);
    td4.appendChild(textnode);
    tr.appendChild(td4); 

    let td5 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.telefone);
    td5.appendChild(textnode);
    tr.appendChild(td5); 

    let td6 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.data_nascimento);
    td6.appendChild(textnode);
    tr.appendChild(td6); 

    let td7 = document.createElement("td"); 
      textnode = document.createTextNode(pobjReturnJSON.data_contratacao);
      td7.appendChild(textnode);  
      tr.appendChild(td7); 


    let td8 = document.createElement("td");
    let btnAlterar = document.createElement("button");
    btnAlterar.textContent = "Alterar Dados";

    let td9 = document.createElement("td");
    let btnExcluir = document.createElement("button");
    btnExcluir.textContent = "Excluir";

    
    btnAlterar.addEventListener("click", function(){
    exibirFormularioAlterar(pobjReturnJSON.cpf, pobjReturnJSON.nome, pobjReturnJSON.matricula, pobjReturnJSON.email, pobjReturnJSON.telefone,  pobjReturnJSON.data_nascimento, pobjReturnJSON.data_contratacao);
    });
    td8.appendChild(btnAlterar);
    tr.appendChild(td8);

    btnExcluir.addEventListener("click", function(){
    excluirProfessores(pobjReturnJSON.cpf);
    });
    td9.appendChild(btnExcluir);
    tr.appendChild(td9);

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
      let data_contratacao = document.getElementById("data_contratacao").value;

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
      xmlhttp.open("POST", "alterarDadosProfessor.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&cpf=" + cpf + "&nome=" + nome + "&matricula=" + matricula + "&email=" + email + "&telefone=" + telefone + "&data_nascimento=" + data_nascimento + "&data_contratacao=" + data_contratacao);
      console.log("Enviado");

      console.log(data_contratacao);

      document.getElementById("msg").innerHTML = "Alterado";

      listarProfessores();

    }

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
  <main class="container text-center py-4">
    <div class="card card-body">

        <div class="container my-3">
            <h2 class="card-title">Professores</h2>
            <p class="card-text">Gerencie os professores de sua unidade</p>
        </div>
        <!-- Menu de Opções -->

        <!-- Tabela de Notas -->
        <div class="container my-3">
            <!-- Menu de Opções -->

  
                
<h1>Listar Professores</h1>


<button onclick="listarProfessores()">Listar Todos os Candidados</button>
<br><br>
<button onclick="exibirAdicionar()">Adicionar Professores</button>
<br><br>

<table id="tabela" class="table table-striped">
  
</table>
<h4 id="msg"></h4>
<br>

  <form action="" method="POST" id="formAlterar" style="display: none;">
  
  <input type="hidden" name="cpf" id="cpf">

  Nome: <input type="text" name="nome" id="nome"><br><br>
  Matricula: <input type="text" name="matricula" id="matricula"><br><br>
  Email: <input type="text" name="email" id="email"><br><br>
  Telefone: <input type="text" name="telefone" id="telefone"><br><br>
  Data de nascimento: <input type="date" name="data_nascimento" id="data_nascimento"><br><br>
  Data de contratação: <input type="date" name="data_contratacao" id="data_contratacao"><br><br>

    <input type="button" value="Alterar" id="Alterar" onclick="alterarDados()">
  </form>

  <form action="" method="POST" id="formAdicionar" style="display: none;">

    Nome: <input type="text" name="nomeAd" id="nomeAd"><br><br>
    CPF: <input type="text" name="cpfAd" id="cpfAd"><br><br>
    Matricula: <input type="text" name="matriculaAd" id="matriculaAd"><br><br>
    Email: <input type="text" name="emailAd" id="emailAd"><br><br>
    Telefone: <input type="text" name="telefoneAd" id="telefoneAd"><br><br>
    Data de nascimento: <input type="date" name="data_nascimentoAd" id="data_nascimentoAd"><br><br>
    Data de contratação: <input type="date" name="data_contratacaoAd" id="data_contratacaoAd"><br><br>

    <input type="button" value="inserir" id="inserir" onclick="adicionarProfessor()">

  </form>
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