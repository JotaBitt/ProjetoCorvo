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
        function listarAlunos() {
            document.getElementById("tabela").innerHTML = "";
            document.getElementById("tabela").style.display = "inline-block";
            document.getElementById("formAlterar").style.display = "none";
            document.getElementById("formAdicionar").style.display = "none";

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let objReturnJSON = JSON.parse(this.responseText);
                    for (let i = 0; i < objReturnJSON.length; i++) {
                        CriarLinhaTabela(objReturnJSON[i]);
                    }
                } else if (this.readyState < 4) {
                    console.log("Carregando: " + this.readyState);
                } else {
                    console.log("Requisição falhou: " + this.status);
                }
            };
            xmlhttp.open("POST", "listarAluno.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send();
            CriarCabecalhoTabela();
        }

        function exibirAdicionar() {
            document.getElementById("formAdicionar").style.display = "inline-block";
            document.getElementById("tabela").style.display = "none";
            document.getElementById("formAlterar").style.display = "none";
        }

        function adicionarAluno() {
            let cpfAd = document.getElementById("cpfAd").value;
            let nomeAd = document.getElementById("nomeAd").value;
            let matriculaAd = document.getElementById("matriculaAd").value;
            let emailAd = document.getElementById("emailAd").value;
            let telefoneAd = document.getElementById("telefoneAd").value;
            let data_nascimentoAd = document.getElementById("data_nascimentoAd").value;

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("Resposta OK: " + this.responseText);
                } else if (this.readyState < 4) {
                    console.log("Carregando: " + this.readyState);
                } else {
                    console.log("Requisição falhou: " + this.status);
                }
            };
            xmlhttp.open("POST", "adicionarAluno.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`cpf=${cpfAd}&nome=${nomeAd}&matricula=${matriculaAd}&email=${emailAd}&telefone=${telefoneAd}&data_nascimento=${data_nascimentoAd}`);
            document.getElementById("msg").innerHTML = "Adicionado";
            document.getElementById("formAdicionar").style.display = "none";
            listarAlunos();
        }

        function exibirFormularioAlterar(cpf, nome, matricula, email, telefone, data_nascimento) {
            document.getElementById("formAlterar").style.display = "block";
            document.getElementById("cpf").value = cpf;
            document.getElementById("nome").value = nome;
            document.getElementById("matricula").value = matricula;
            document.getElementById("email").value = email;
            document.getElementById("telefone").value = telefone;
            document.getElementById("data_nascimento").value = data_nascimento;
        }

        function excluirAlunos(cpf2) {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("Resposta OK: " + this.responseText);
                } else if (this.readyState < 4) {
                    console.log("Carregando: " + this.readyState);
                } else {
                    console.log("Requisição falhou: " + this.status);
                }
            };
            xmlhttp.open("POST", "excluirAluno.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`cpf=${cpf2}`);
            document.getElementById("msg").innerHTML = "Excluído";
            listarAlunos();
        }

        function CriarCabecalhoTabela() {
            let table = document.getElementById("tabela");
            let tr = document.createElement("tr");

            let th1 = document.createElement("th");
            th1.textContent = "Nome";
            tr.appendChild(th1);

            let th2 = document.createElement("th");
            th2.textContent = "Matrícula";
            tr.appendChild(th2);

            let th3 = document.createElement("th");
            th3.textContent = "CPF";
            tr.appendChild(th3);

            let th4 = document.createElement("th");
            th4.textContent = "Email";
            tr.appendChild(th4);

            let th5 = document.createElement("th");
            th5.textContent = "Telefone";
            tr.appendChild(th5);

            let th6 = document.createElement("th");
            th6.textContent = "Data de Nascimento";
            tr.appendChild(th6);

            let th7 = document.createElement("th");
            th7.textContent = "Alterar";
            tr.appendChild(th7);

            let th8 = document.createElement("th");
            th8.textContent = "Excluir";
            tr.appendChild(th8);

            table.appendChild(tr);
        }

        function CriarLinhaTabela(pobjReturnJSON) {
            let table = document.getElementById("tabela");
            document.getElementById("tabela").style = "display: inline-block; border: solid black 1px;";
            let tr = document.createElement("tr");
            table.appendChild(tr);

            let td = document.createElement("td");
            td.textContent = pobjReturnJSON.nome;
            tr.appendChild(td);

            let td2 = document.createElement("td");
            td2.textContent = pobjReturnJSON.matricula;
            tr.appendChild(td2);

            let td3 = document.createElement("td");
            td3.textContent = pobjReturnJSON.cpf;
            tr.appendChild(td3);

            let td4 = document.createElement("td");
            td4.textContent = pobjReturnJSON.email;
            tr.appendChild(td4);

            let td5 = document.createElement("td");
            td5.textContent = pobjReturnJSON.telefone;
            tr.appendChild(td5);

            let td6 = document.createElement("td");
            td6.textContent = pobjReturnJSON.data_nascimento;
            tr.appendChild(td6);

            let td7 = document.createElement("td");
            let btnAlterar = document.createElement("button");
            btnAlterar.textContent = "Alterar Dados";
            btnAlterar.addEventListener("click", function() {
                exibirFormularioAlterar(pobjReturnJSON.cpf, pobjReturnJSON.nome, pobjReturnJSON.matricula, pobjReturnJSON.email, pobjReturnJSON.telefone, pobjReturnJSON.data_nascimento);
            });
            td7.appendChild(btnAlterar);
            tr.appendChild(td7);

            let td8 = document.createElement("td");
            let btnExcluir = document.createElement("button");
            btnExcluir.textContent = "Excluir";
            btnExcluir.addEventListener("click", function() {
                excluirAlunos(pobjReturnJSON.cpf);
            });
            td8.appendChild(btnExcluir);
            tr.appendChild(td8);
        }

        function alterarDados() {
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
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("Resposta OK: " + this.responseText);
                } else if (this.readyState < 4) {
                    console.log("Carregando: " + this.readyState);
                } else {
                    console.log("Requisição falhou: " + this.status);
                }
            };
            xmlhttp.open("POST", "alterarDadosAluno.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`cpf=${cpf}&nome=${nome}&matricula=${matricula}&email=${email}&telefone=${telefone}&data_nascimento=${data_nascimento}`);
            listarAlunos();
        }
    </script>
</head>

<body onload="listarAlunos()">

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

    <div class="container">
        <header class="d-flex justify-content-between align-items-center mt-4">
            <h1 class="materia-title">Gerenciamento de Alunos</h1>
            <button type="button" class="btn btn-primary" onclick="exibirAdicionar()">Adicionar Aluno</button>
        </header>

        <div class="mt-4">
            <form id="formAdicionar" class="formulario" style="display: none;">
                <h2>Adicionar Aluno</h2>
                <label for="cpfAd">CPF:</label>
                <input type="text" id="cpfAd" name="cpf" class="form-control mb-2">
                <label for="nomeAd">Nome:</label>
                <input type="text" id="nomeAd" name="nome" class="form-control mb-2">
                <label for="matriculaAd">Matrícula:</label>
                <input type="text" id="matriculaAd" name="matricula" class="form-control mb-2">
                <label for="emailAd">Email:</label>
                <input type="text" id="emailAd" name="email" class="form-control mb-2">
                <label for="telefoneAd">Telefone:</label>
                <input type="text" id="telefoneAd" name="telefone" class="form-control mb-2">
                <label for="data_nascimentoAd">Data de Nascimento:</label>
                <input type="date" id="data_nascimentoAd" name="data_nascimento" class="form-control mb-2">
                <button type="button" class="btn btn-success" onclick="adicionarAluno()">Adicionar</button>
            </form>

            <form id="formAlterar" class="formulario" style="display: none;">
                <h2>Alterar Aluno</h2>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" class="form-control mb-2" readonly>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control mb-2">
                <label for="matricula">Matrícula:</label>
                <input type="text" id="matricula" name="matricula" class="form-control mb-2">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control mb-2">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" class="form-control mb-2">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" class="form-control mb-2">
                <button type="button" class="btn btn-success" onclick="alterarDados()">Alterar</button>
            </form>

            <div id="msg" class="mt-3"></div>
            <table id="tabela" class="table table-striped mt-4"></table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
         <div class="container">
             <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
         </div>
    </footer>
</body>

</html>
