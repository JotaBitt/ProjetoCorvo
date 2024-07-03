<?php

include '../../session.php';
// include '../../assets/classes/Log.php';
// include '../../assets/classes/Turma.php';
// include '../../assets/classes/Aluno.php';
// include '../../assets/classes/Nota.php';

// // Criar algoritmo para identificar a turma
// $turma = "4ADS";


// log->registrarAcesso($_SESSION['nome_usuario'], "Acesso na página de controle de notas da turma $turma.");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Controle de Notas - Corvo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://replit.com/@JOAODA17/Projeto-Corvo#assets/img/corvo-logo.ico"
        type="image/x-icon" />
    <style>
        /* Add this CSS to move the footer to the bottom */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .materia-title {
            position: relative;
            bottom: 0;
            left: 0;
        }

        .nomeProfessor {
            font-size: 13px;
        }

        .fotoProfessor>img {
            width: 20px;
            height: 20px;
        }

        table {
            table-layout: fixed;
            /* Garante que a largura das colunas será fixa */
            width: 100%;
            /* Ocupará 100% da largura disponível */
        }

        th.atividade {
            max-width: 100px;
            /* Define a largura máxima */
            white-space: nowrap;
            /* Impede quebra de linha */
            overflow: hidden;
            /* Esconde o texto que ultrapassa o tamanho */
            text-overflow: ellipsis;
            /* Adiciona reticências */
        }
    </style>
</head>

<body>
    <header class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom">
        <a href="index.html">
            <div class="logo">
                <img src="../../img/corvo-logo.png" width="70px" alt="logo Corvo"
                    class="img-fluid" />
            </div>
        </a>
        <div class="user-icon">
            <i class="fas fa-user-circle" style="font-size: 36px"></i>
        </div>
    </header>
    <main class="container py-4">

        <div class="card mb-4 p-5 d-flex justify-content-start align-items-end" style="background-image: url(/assets/cards/marketing-digital.png); 
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
                    border-radius: 1rem;
                ">
            <div class="text-white">
                <h2 class="card-title">Marketing Digital</h2>
                <!-- <img class="fotoProfessor" src="img/vegetti.png" alt="Pablo Vegetti" /> -->
                <!-- <span>Pablo Vegetti</span> -->
            </div>
        </div>

        <div class="w-100 m-3">
            <ul class="nav d-flex justify-content-center align-items-center nav-pills">
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="#">Notas</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Presença</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Alunos</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Atividades</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Mural</a>
                </li>
            </ul>
        </div>

        <div class="card card-body">

            <div class="container my-3">
                <h2 class="card-title">Notas</h2>
                <p class="card-text">Gerencie as notas dos alunos da turma</p>
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
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Aluno</th>
                                <th scope="col" class="atividade" style="width: 100px;">Atividade 1</th>
                                <th scope="col" class="atividade" style="width: 100px;">Atividade 2</th>

                                <th scope="col" style="width: 80px">Média</th>
                                <!-- Adicione mais colunas conforme o número de atividades -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aqui você pode adicionar as linhas representando cada aluno -->
                            <tr>
                                <th scope="row" class="text-secondary">João da Silva</th>
                                <td>8.5</td>
                                <td>7.0</td>
                                <td>7.75</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-secondary">Maria Oliveira</th>
                                <td>9.0</td>
                                <td>8.5</td>
                                <td>8.75</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-secondary">José Santos</th>
                                <td>7.0</td>
                                <td>6.5</td>
                                <td>6.75</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="card-text">Exibindo <span id="contador-alunos"></span> alunos</p>
                </div>

            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-center bg-dark text-white mh-30">
        <div class="container">
            <span>Copyright &copy; Todos os direitos reservados a Jota's Corp</span>
        </div>
    </footer>



    <!-- Bibliotecas -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
</body>

</html>