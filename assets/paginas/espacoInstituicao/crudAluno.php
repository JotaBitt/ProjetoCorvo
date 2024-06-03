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

     <script>
        function listarCandidatos() {
          let xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              let objReturnJSON = JSON.parse(this.responseText);
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
         
          xmlhttp.open("GET", "listarAluno.php");
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send();
        }
        function CriarLinhaTabela(pobjReturnJSON) {
          let tr = document.createElement("tr");
          let td = document.createElement("td");
          let textNode = document.createTextNode(pobjReturnJSON.nome);
          td.appendChild(textNode);
          tr.appendChild(td);

          let td2 = document.createElement("td"); 
          textnode = document.createTextNode(pobjReturnJSON.matricula);
          td2.appendChild(textnode);

          let td3 = document.createElement("td");
          textnode = document.createTextNode(pobjReturnJSON.identidade);
          td2.appendChild(textnode); 
          tr.appendChild(td3);

          let td4 = document.createElement("td");
          textnode = document.createTextNode(pobjReturnJSON.email);
          td2.appendChild(textnode); 
          tr.appendChild(td4);

          let td5 = document.createElement("td");
          textnode = document.createTextNode(pobjReturnJSON.data_nascimento);
          td2.appendChild(textnode); 
          tr.appendChild(td5);

          let td6 = document.createElement("td");
          textnode = document.createTextNode(pobjReturnJSON.sexo);
          td2.appendChild(textnode); 
          tr.appendChild(td6);

          var tr_fim = document.getElementById("ultimalinha");
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
            <h2 class="card-title">Alunos</h2>
            <p class="card-text">Gerencie os alunos de sua unidade</p>
        </div>
        <!-- Menu de Opções -->

        <!-- Tabela de Notas -->
        <div class="container my-3">
            <!-- Menu de Opções -->

            <!-- Tabela de Notas -->
            <div class="container my-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Pesquisar aluno"
                        aria-label="Pesquisar aluno" aria-describedby="button-addon2">
                    <button class="btn btn-secondary" type="button" id="button-addon2">Pesquisar</button>
               </div> 

                <form action="" method=POST name="formSala" id="formSala">
                  <input type="button" value="Listar" id='btnList' onclick="listarCandidatos();">
                </form>
                <br>
                <table id="lst">
                  <tr id="ultimaLinha">
                    <td colspan="6"></td>
                  </tr>
                </table>
                
                
                 <!-- <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">Data de nascimento</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Sexo</th>
                            
                            
                          Adicione mais colunas conforme o número de atividades 
                        </tr>
                    </thead>
                    <tbody>
                            Aqui você pode adicionar as linhas representando cada aluno 
                        <tr>
                            <th scope="row" class="text-secondary">João da Silva</th>
                            <td>22204700 </td>
                            <td>22/05/1990</td>
                            <td>fulano@gmail.com </td>
                            <td>21204700</td>
                            <td>Masculino</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-secondary">Maria Oliveira</th>
                            <td>2220470830 </td>
                            <td>23/05/1990</td>
                            <td>ciclano@gmail.com </td>
                            <td>2120470830</td>
                            <td>Femea</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-secondary">José Santos</th>
                            <td>222048571 </td>
                            <td>24/05/1990</td>
                            <td>beltrano@gmail.com </td>
                            <td>212048571</td>
                            <td>Masculino</td>
                        </tr>
                    </tbody>
                </table>
                <p class="card-text">Exibindo <span id="contador-alunos"></span> alunos</p>
            </div> -->

        </div>
    </div>
  </main>
  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/387cf5e4a4.js" crossorigin="anonymous"></script>
    <script>
        // Função para pesquisar o aluno
        $(document).ready(function () {

            // Função para contar o número de alunos que estão sendo exibidos
            var contador = $("tbody tr:visible").length;
            $("#contador-alunos").text(contador);

            $("#button-addon2").click(function () {
                var value = $("input").val().toLowerCase();
                $("tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

                // Função para contar o número de alunos que estão sendo exibidos
                var contador = $("tbody tr:visible").length;
                $("#contador-alunos").text(contador);

            });
        });
    </script>
    <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
         <div class="container">
             <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
         </div>
    </footer>
</body>
</html>