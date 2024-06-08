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
            <h2 class="card-title">Curso</h2>
            <p class="card-text">Adicione os Usuarios aos Cursos</p>
        </div>

                
                
<h2>Listar Alunos</h2>

<form action="javascript:listarAluno();" method="POST" id="formListarAlunos" style="display:block;">

    <button>Listar Alunos</button>

</form>

<h2>Listar Professor</h2>

<form action="javascript:listarProfessor();" method="POST" id="formListarProfessor" style="display:block;">

    <button>Listar Professor</button>

</form>

<h2>Listar Cursos</h2>

<form action="javascript:listarCurso();" method="POST" id="formListarCurso" style="display:block;">

    <button>Listar Curso</button>

</form>

<h3>Adicionar Curso</h3>

<form action="javascript:exibirAdicionarCurso();" method="POST" id="formExibirAdicionar" style="display:block;">

    <button>Adicionar Curso</button>

</form>


<table id="tabela" class="table table-striped">
  
</table>
<h4 id="msg"></h4>
<br>

<form action="" method="POST" id="formAdicionarCurso" style="display: none;">

    Sigla do Curso: <input type="text" name="siglaCursoADC" id="siglaCursoADC"><br><br>
    Unidade : <input type="text" name="unidadeADC" id="unidadeADC"><br><br>
    nome: <input type="text" name="nomeADC" id="nomeADC"><br><br>
    Carga Horaria(Somente numeros): <input type="text" name="carga_horariaADC" id="carga_horariaADC"><br><br>
    
    <input type="button" value="inserir" id="inserir" onclick="adicionarCurso()">

    
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

    function exibirAdicionarCurso(){

      document.getElementById("formAdicionarCurso").style.display = "inline-block";
      document.getElementById("tabela").style.display = "none"; 

    }


// Terminar
    function adicionarCurso(){


    let siglaCursoADC = document.getElementById("siglaCursoADC").value;
    let unidadeADC = document.getElementById("unidadeADC").value;
    let nomeADC = document.getElementById("nomeADC").value;
    let carga_horariaADC = document.getElementById("carga_horariaADC").value;

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
    xmlhttp.open("POST", "adicionarAluno.php");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("&siglaCursoADC=" + siglaCursoADC + "&unidadeADC=" + unidadeADC + "&nomeADC=" + nomeADC + "&carga_horariaADC=" + carga_horariaADC );
    console.log("Enviado");

    document.getElementById("msg").innerHTML = "Adicionado";

    document.getElementById("formAdicionar").style.display = "none";

    }
    function listarAluno() {

      document.getElementById("tabela").innerHTML = "";
      document.getElementById("tabela").style.display = "inline-block";
      
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
            CriarLinhaTabelaAluno(objReturnJSON[$i]);
          }
        } else
        if (this.readyState < 4) {
          console.log("3: " + this.readyState);
        } else
          console.log("Requisicao falhou: " + this.status);
      }
      console.log("4");
      xmlhttp.open("POST", "listarAluno.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send();
      console.log("enviei request get");
      console.log("5");
      CriarCabecalhoTabelaAluno();
    }

    function listarProfessor() {

      document.getElementById("tabela").innerHTML = "";
      document.getElementById("tabela").style.display = "inline-block";

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
            CriarLinhaTabelaProfessor(objReturnJSON[$i]);
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
      CriarCabecalhoTabelaProfessor();
      }

      function listarCurso() {

      document.getElementById("tabela").innerHTML = "";
      document.getElementById("tabela").style.display = "inline-block";

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
            CriarLinhaTabelaCurso(objReturnJSON[$i]);
          }
        } else
        if (this.readyState < 4) {
          console.log("3: " + this.readyState);
        } else
          console.log("Requisicao falhou: " + this.status);
      }
      console.log("4");
      xmlhttp.open("POST", "listarCursos.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send();
      console.log("enviei request get");
      console.log("5");
      CriarCabecalhoTabelaCurso();
      }

      function CriarCabecalhoTabelaCurso(){

        let table = document.getElementById("tabela");

        let tr = document.createElement("tr");

        let th1 = document.createElement("th");
        th1.textContent = "nome";
        tr.appendChild(th1);

        let th2 = document.createElement("th");
        th2.textContent = "Sigla do Curso";
        tr.appendChild(th2);

        let th3 = document.createElement("th");
        th3.textContent = "unidade";
        tr.appendChild(th3);

        let th4 = document.createElement("th");
        th4.textContent = "Carga Horaria";
        tr.appendChild(th4);

        let th5 = document.createElement("th");
        th5.textContent = "Excluir";
        tr.appendChild(th5);

        table.appendChild(tr);

        }

        
    function CriarLinhaTabelaCurso(pobjReturnJSON) {

      let table = document.getElementById("tabela");
      document.getElementById("tabela").style = "display: inline-block;  border: solid black 1px;"
      let tr = document.createElement("tr");
      table.appendChild(tr);

      let td = document.createElement("td");
      let textNode = document.createTextNode(pobjReturnJSON.nome);
      td.appendChild(textNode);
      tr.appendChild(td);

      let td2 = document.createElement("td"); 
      textnode = document.createTextNode(pobjReturnJSON.siglaCurso);
      td2.appendChild(textnode);
      tr.appendChild(td2); 

      let td3 = document.createElement("td"); 
      textnode = document.createTextNode(pobjReturnJSON.unidade);
      td3.appendChild(textnode);
      tr.appendChild(td3); 

      let td4 = document.createElement("td"); 
      textnode = document.createTextNode(pobjReturnJSON.carga_horaria);
      td4.appendChild(textnode);
      tr.appendChild(td4); 

      let td5 = document.createElement("td");

      let btnExcluir = document.createElement("button");
      btnExcluir.textContent = "Excluir";

      btnExcluir.addEventListener("click", function(){

        excluirCurso(pobjReturnJSON.siglaCurso);
      });
      td5.appendChild(btnExcluir);
      tr.appendChild(td5);


      }

      function excluirCurso(siglaCurso){

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
      xmlhttp.open("POST", "excluirCurso.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      console.log(siglaCurso);
      xmlhttp.send("&siglaCurso=" + siglaCurso );
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Excluido";

    }



    function exibirAdicionar(){

      document.getElementById("formAdicionar").style.display = "inline-block";
      document.getElementById("tabela").style.display = "none";
      document.getElementById("formAlterar").style.display = "none";
      
    }

    function adicionarCursoAluno(nome, matricula, siglaCurso ){
      
      let rank = "aluno";

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
      xmlhttp.open("POST", "adicionarUsuarioCurso.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      console.log(nome, matricula, rank, siglaCurso )
      
      xmlhttp.send("&nome=" + nome + "&matricula=" + matricula + "&rank=" + rank + "&siglaCurso=" + siglaCurso );
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Adicionado";

    }

    function adicionarCursoProfessor(nome, matricula, siglaCurso ){
      
      let rank = "professor";

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
      xmlhttp.open("POST", "adicionarUsuarioCurso.php");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("&nome=" + nome + "&matricula=" + matricula + "&rank=" + rank + "&siglaCurso=" + siglaCurso );
      console.log("Enviado");

      document.getElementById("msg").innerHTML = "Adicionado";

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


    function CriarCabecalhoTabelaAluno(){

      let table = document.getElementById("tabela");

      let tr = document.createElement("tr");

      let th1 = document.createElement("th");
      th1.textContent = "nome";
      tr.appendChild(th1);

      let th2 = document.createElement("th");
      th2.textContent = "matricula";
      tr.appendChild(th2);

      let th3 = document.createElement("th");
      th3.textContent = "email";
      tr.appendChild(th3);

      let th4 = document.createElement("th");
      th4.textContent = "cpf";
      tr.appendChild(th4);

      let th5 = document.createElement("th");
      th5.textContent = "telefone";
      tr.appendChild(th5);

      let th6 = document.createElement("th");
      th6.textContent = "Data de Nascimento";
      tr.appendChild(th6);


      let th7 = document.createElement("th");
      th7.textContent = "Adicionar";
      tr.appendChild(th7);

      table.appendChild(tr);

    }

    function CriarCabecalhoTabelaProfessor(){

      let table = document.getElementById("tabela");

      let tr = document.createElement("tr");

      let th1 = document.createElement("th");
      th1.textContent = "nome";
      tr.appendChild(th1);

      let th2 = document.createElement("th");
      th2.textContent = "matricula";
      tr.appendChild(th2);

      let th3 = document.createElement("th");
      th3.textContent = "email";
      tr.appendChild(th3);

      let th4 = document.createElement("th");
      th4.textContent = "cpf";
      tr.appendChild(th4);

      let th5 = document.createElement("th");
      th5.textContent = "telefone";
      tr.appendChild(th5);

      let th6 = document.createElement("th");
      th6.textContent = "Data de Nascimento";
      tr.appendChild(th6);

      let th7 = document.createElement("th");
      th7.textContent = "Data de Contratação";
      tr.appendChild(th7);


      let th8 = document.createElement("th");
      th8.textContent = "Adicionar";
      tr.appendChild(th8);

      table.appendChild(tr);

      }
    function CriarLinhaTabelaAluno(pobjReturnJSON) {

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
    textnode = document.createTextNode(pobjReturnJSON.email);
    td3.appendChild(textnode);
    tr.appendChild(td3); 

    let td4 = document.createElement("td"); 
    textnode = document.createTextNode(pobjReturnJSON.cpf);
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
      
    let textbox = document.createElement("input");
    textbox.type = "text";
    textbox.id = "inputTextBox";
    td7.appendChild(textbox);

   
    let btnAdicionar = document.createElement("button");
    btnAdicionar.textContent = "Adicionar";

    btnAdicionar.addEventListener("click", function(){

      let siglaCurso = textbox.value;
      adicionarCursoAluno(pobjReturnJSON.nome, pobjReturnJSON.matricula, siglaCurso);
    });
    td7.appendChild(btnAdicionar);
    tr.appendChild(td7);


    }

    function CriarLinhaTabelaProfessor(pobjReturnJSON) {

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
      textnode = document.createTextNode(pobjReturnJSON.email);
      td3.appendChild(textnode);
      tr.appendChild(td3); 

      let td4 = document.createElement("td"); 
      textnode = document.createTextNode(pobjReturnJSON.cpf);
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
        
      let textbox = document.createElement("input");
      textbox.type = "text";
      textbox.id = "inputTextBox";
      td8.appendChild(textbox);


      let btnAdicionar = document.createElement("button");
      btnAdicionar.textContent = "Adicionar";

      btnAdicionar.addEventListener("click", function(){

        let siglaCurso = textbox.value;
        adicionarCursoProfessor(pobjReturnJSON.nome, pobjReturnJSON.matricula, siglaCurso);
      });
      td8.appendChild(btnAdicionar);
      tr.appendChild(td8);

      }


    function alterarDados(){

      document.getElementById("formAlterar").style.display = "none";
      document.getElementById("tabela").style.display = "none";

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

    }

  </script>
</body>
</html>