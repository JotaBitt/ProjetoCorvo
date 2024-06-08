<?php
include '../../session.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require_once "../../assets/includes/head.php"; ?>
    <title>Corvo - Gerenciamento</title>
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

            <h1>Listar Usuários</h1>
            <form action="javascript:listarUsuarios();" method="POST" id="formSiglaCurso" style="display:block;">
                <div class="form-group">
                    <label for="siglaCurso">Digite a Sigla do Curso:</label>
                    <input type="text" name="siglaCurso" id="siglaCurso" class="form-control" required>
                </div>
                <button class="btn btn-primary">Listar Usuários</button>
            </form>

            <table id="tabela" class="table table-striped mt-4"></table>
            <h4 id="msg" class="mt-3"></h4>
        </div>
    </main>
    <footer class="footer mt-auto py-3 text-center bg-dark text-white">
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
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let objReturnJSON = JSON.parse(this.responseText);
                for (let i = 0; i < objReturnJSON.length; i++) {
                    CriarLinhaTabela(objReturnJSON[i]);
                }
            }
        };
        xmlhttp.open("POST", "listarUsuariosCurso.php");
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("siglaCurso=" + siglaCurso);
        CriarCabecalhoTabela();
    }

    function CriarCabecalhoTabela() {
        let table = document.getElementById("tabela");
        let tr = document.createElement("tr");
        let headers = ["Nome", "Matrícula", "Rank", "Sigla Curso", "Adicionar"];
        headers.forEach(header => {
            let th = document.createElement("th");
            th.textContent = header;
            tr.appendChild(th);
        });
        table.appendChild(tr);
    }

    function CriarLinhaTabela(pobjReturnJSON) {
        let table = document.getElementById("tabela");
        let tr = document.createElement("tr");

        ["nome", "matricula", "rank", "siglaCurso"].forEach(attr => {
            let td = document.createElement("td");
            td.textContent = pobjReturnJSON[attr];
            tr.appendChild(td);
        });

        let tdAdd = document.createElement("td");
        let textbox = document.createElement("input");
        textbox.type = "text";
        tdAdd.appendChild(textbox);

        let btnAdicionar = document.createElement("button");
        btnAdicionar.textContent = "Adicionar";
        btnAdicionar.classList.add("btn", "btn-success", "ml-2");
        btnAdicionar.addEventListener("click", function() {
            let siglaTurma = textbox.value;
            adicionarTurma(pobjReturnJSON.matricula, siglaTurma, pobjReturnJSON.nome, pobjReturnJSON.rank, pobjReturnJSON.siglaCurso);
        });
        tdAdd.appendChild(btnAdicionar);
        tr.appendChild(tdAdd);

        table.appendChild(tr);
    }

    function adicionarTurma(matricula, siglaTurma, nome, rank, siglaCurso) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("msg").textContent = "Adicionado";
                listarUsuarios();
            }
        };
        xmlhttp.open("POST", "adicionarAlunoTurma.php");
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`matricula=${matricula}&nome=${nome}&siglaTurma=${siglaTurma}&rank=${rank}&siglaCurso=${siglaCurso}`);
    }
    </script>
</body>
</html>
