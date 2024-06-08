
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
                <p class="card-text">Adicione os Usuários aos Cursos</p>
            </div>

            <h2>Listar Alunos</h2>
            <form action="javascript:listarAluno();" method="POST" id="formListarAlunos" style="display:block;">
                <button class="btn btn-primary">Listar Alunos</button>
            </form>

            <h2>Listar Professores</h2>
            <form action="javascript:listarProfessor();" method="POST" id="formListarProfessor" style="display:block;">
                <button class="btn btn-primary">Listar Professores</button>
            </form>

            <h2>Listar Cursos</h2>
            <form action="javascript:listarCurso();" method="POST" id="formListarCurso" style="display:block;">
                <button class="btn btn-primary">Listar Cursos</button>
            </form>

            <h3>Adicionar Curso</h3>
            <form action="javascript:exibirAdicionarCurso();" method="POST" id="formExibirAdicionar" style="display:block;">
                <button class="btn btn-success">Adicionar Curso</button>
            </form>

            <table id="tabela" class="table table-striped"></table>
            <h4 id="msg"></h4>
            <br>

            <form action="javascript:adicionarCurso();" method="POST" id="formAdicionarCurso" style="display: none;">
                Sigla do Curso: <input type="text" name="siglaCursoADC" id="siglaCursoADC" class="form-control"><br>
                Unidade: <input type="text" name="unidadeADC" id="unidadeADC" class="form-control"><br>
                Nome: <input type="text" name="nomeADC" id="nomeADC" class="form-control"><br>
                Carga Horária (Somente números): <input type="text" name="carga_horariaADC" id="carga_horariaADC" class="form-control"><br>
                <button type="submit" class="btn btn-primary">Inserir</button>
            </form>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
         <div class="container">
             <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
         </div>
    </footer>

    <?php require_once "../../assets/includes/scripts.php"; ?>

    <script>
        function exibirAdicionarCurso() {
            document.getElementById("formAdicionarCurso").style.display = "block";
            document.getElementById("tabela").style.display = "none";
        }

        function adicionarCurso() {
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
            xmlhttp.open("POST", "adicionarCurso.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("&siglaCursoADC=" + siglaCursoADC + "&unidadeADC=" + unidadeADC + "&nomeADC=" + nomeADC + "&carga_horariaADC=" + carga_horariaADC );
            console.log("Enviado");

            document.getElementById("formAdicionarCurso").style.display = "none";
        }

        function listarAluno() {
            document.getElementById("tabela").innerHTML = "";
            document.getElementById("tabela").style.display = "inline-block";

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let objReturnJSON = JSON.parse(this.responseText);
                    CriarCabecalhoTabelaAluno();
                    objReturnJSON.forEach(aluno => {
                        CriarLinhaTabelaAluno(aluno);
                    });
                }
            }
            xmlhttp.open("POST", "listarAluno.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send();
        }

        function listarProfessor() {
            document.getElementById("tabela").innerHTML = "";
            document.getElementById("tabela").style.display = "inline-block";

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let objReturnJSON = JSON.parse(this.responseText);
                    CriarCabecalhoTabelaProfessor();
                    objReturnJSON.forEach(professor => {
                        CriarLinhaTabelaProfessor(professor);
                    });
                }
            }
            xmlhttp.open("POST", "listarProfessor.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send();
        }

        function listarCurso() {
            document.getElementById("tabela").innerHTML = "";
            document.getElementById("tabela").style.display = "inline-block";

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let objReturnJSON = JSON.parse(this.responseText);
                    CriarCabecalhoTabelaCurso();
                    objReturnJSON.forEach(curso => {
                        CriarLinhaTabelaCurso(curso);
                    });
                }
            }
            xmlhttp.open("POST", "listarCursos.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send();
        }

        function CriarCabecalhoTabelaCurso() {
            let table = document.getElementById("tabela");

            let tr = document.createElement("tr");
            ["Nome", "Sigla do Curso", "Unidade", "Carga Horária", "Excluir"].forEach(text => {
                let th = document.createElement("th");
                th.textContent = text;
                tr.appendChild(th);
            });
            table.appendChild(tr);
        }

        function CriarLinhaTabelaCurso(curso) {
            let table = document.getElementById("tabela");
            let tr = document.createElement("tr");
            table.appendChild(tr);

            ["nome", "siglaCurso", "unidade", "carga_horaria"].forEach(key => {
                let td = document.createElement("td");
                td.textContent = curso[key];
                tr.appendChild(td);
            });

            let td = document.createElement("td");
            let btnExcluir = document.createElement("button");
            btnExcluir.textContent = "Excluir";
            btnExcluir.className = "btn btn-danger";
            btnExcluir.addEventListener("click", function () {
                excluirCurso(curso.siglaCurso);
            });
            td.appendChild(btnExcluir);
            tr.appendChild(td);
        }

        function excluirCurso(siglaCurso) {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("msg").innerHTML = "Excluído";
                    listarCurso();
                }
            }
            xmlhttp.open("POST", "excluirCurso.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("siglaCurso=" + siglaCurso);
        }

        function CriarCabecalhoTabelaAluno() {
            let table = document.getElementById("tabela");

            let tr = document.createElement("tr");
            ["Nome", "Matrícula", "Email", "CPF", "Telefone", "Data de Nascimento", "Adicionar"].forEach(text => {
                let th = document.createElement("th");
                th.textContent = text;
                tr.appendChild(th);
            });
            table.appendChild(tr);
        }

        function CriarCabecalhoTabelaProfessor() {
            let table = document.getElementById("tabela");

            let tr = document.createElement("tr");
            ["Nome", "Matrícula", "Email", "CPF", "Telefone", "Data de Nascimento", "Data de Contratação", "Adicionar"].forEach(text => {
                let th = document.createElement("th");
                th.textContent = text;
                tr.appendChild(th);
            });
            table.appendChild(tr);
        }

        function CriarLinhaTabelaAluno(aluno) {
            let table = document.getElementById("tabela");
            let tr = document.createElement("tr");
            table.appendChild(tr);

            ["nome", "matricula", "email", "cpf", "telefone", "data_nascimento"].forEach(key => {
                let td = document.createElement("td");
                td.textContent = aluno[key];
                tr.appendChild(td);
            });

            let td = document.createElement("td");

            let textbox = document.createElement("input");
            textbox.type = "text";
            textbox.id = "inputTextBox";
            td.appendChild(textbox);

            let btnAdicionar = document.createElement("button");
            btnAdicionar.textContent = "Adicionar";
            btnAdicionar.className = "btn btn-primary";
            btnAdicionar.addEventListener("click", function () {
                let siglaCurso = textbox.value;
                adicionarAlunoCurso(aluno.nome, aluno.matricula, siglaCurso);
            });
            td.appendChild(btnAdicionar);
            tr.appendChild(td);

        }

        function CriarLinhaTabelaProfessor(professor) {
            let table = document.getElementById("tabela");
            let tr = document.createElement("tr");
            table.appendChild(tr);

            ["nome", "matricula", "email", "cpf", "telefone", "data_nascimento", "data_contratacao"].forEach(key => {
                let td = document.createElement("td");
                td.textContent = professor[key];
                tr.appendChild(td);
            });

            let td = document.createElement("td");

            let textbox = document.createElement("input");
            textbox.type = "text";
            textbox.id = "inputTextBox";
            td.appendChild(textbox);

            let btnAdicionar = document.createElement("button");
            btnAdicionar.textContent = "Adicionar";
            btnAdicionar.className = "btn btn-primary";
            btnAdicionar.addEventListener("click", function () {
                let siglaCurso = textbox.value;
                adicionarProfessorCurso(professor.nome, professor.matricula, siglaCurso);
            });
            td.appendChild(btnAdicionar);
            tr.appendChild(td);
        }

        function adicionarAlunoCurso(nome, matricula, siglaCurso) {

            let rank = "aluno";

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("msg").innerHTML = "Adicionado";
                    listarAluno();
                }
            }
            xmlhttp.open("POST", "adicionarUsuarioCurso.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("$nome=" + nome + "&matricula=" + matricula + "&siglaCurso=" + siglaCurso + "&rank=" + rank);
        }

        function adicionarProfessorCurso(nome, matricula, siglaCurso) {

            let rank = "professor";
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("msg").innerHTML = "Adicionado";
                    listarProfessor();
                }
            }
            xmlhttp.open("POST", "adicionarUsuarioCurso.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("$nome=" + nome + "&matricula=" + matricula + "&siglaCurso=" + siglaCurso + "&rank=" + rank);
        }
    </script>
</body>
</html>
