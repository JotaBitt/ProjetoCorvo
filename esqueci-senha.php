<?php

include 'config.php';

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?php include 'assets/includes/head.php'; ?>
    <title>Esqueci senha - Corvo</title>
    <style>
        html {
            min-height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url(assets/background/background-corvo.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
        }

        span.required {
            color: red;
        }

        h2 {
            font-weight: bold;
        }

        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        margin: auto;
        margin-top: 100px;
        /* -webkit-box-shadow: 1px 5px 28px 6px rgba(0,0,0,1);
                -moz-box-shadow: 1px 5px 28px 6px rgba(0,0,0,1);
                box-shadow: 1px 5px 28px 6px rgba(0,0,0,1); 

            }
            .container h2 {
                margin-bottom: 20px;
            }
            .container input[type="text"],
            .container input[type="password"] {
                width: calc(100% - 22px);
                padding: 10px;
                margin: 5px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .container .row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .container .row input[type="checkbox"] {
                margin-right: 5px;
            }
            .container .row a {
                color: #3a416f;
                text-decoration: none;
            }
            .container button {
                width: 100%;
                padding: 10px;
                margin-top: 20px;
                border: none;
                border-radius: 5px;
                background-color: #3a416f;
                color: white;
                cursor: pointer;
            }
            header{
                display: flex; 
                align-items: center; 
                margin: auto; 
                justify-content: space-between;
                border-bottom: 1px solid black;
            } */
    </style>
</head>

<body class="p-5">
    <!-- <div class="row d-flex align-items-center justify-content-center ">
        <div class="card card-body col-sm-10 col-lg-6 col-xl-4 p-5">
            <div class="container">
                <img src="assets/img/corvo-logo.png" alt="Logo" style="width: 50px;">
                <h2>Redefinir Senha</h2>
                
            </div>
        </div>
    </div> -->

    <div class="row d-flex align-items-center justify-content-center ">
        <div class="card card-body col-sm-10 col-lg-6 col-xl-4 p-5">
            <div class="d-flex align-items-center flex-column mb-3">
                <img src="<?= $link ?>/assets/img/corvo-logo.png" alt="Logo" width="100px" />
                <h1 class="h4">Redefinir senha</h1>
                <p>Lembrou sua senha? <a href="<?= $link ?>/login">Faça login!</a></p>
            </div>
            <!-- <form action="<?= $link ?>/assets/php/verificarLogin.php" method="POST">
                <div class="form-group mb-3">
                    <label for="usuario" class="form-label">Usuário <span class="required">*</span></label>
                    <input type="text" name="usuario" placeholder="aluno.0000000000001" required class="form-control" />
                </div>
                <div class="form-group mb-4">
                    <label for="senha" class="form-label">Senha <span class="required">*</span></label>
                    <input type="password" name="senha" placeholder="************" required class="form-control" />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= $link ?>/esqueci-senha" class="mb-3">Esqueceu sua senha?</a>
                    <button type="submit" class="btn btn-primary d-block px-3">Entrar</button>
                </div>
            </form> -->

            <form action="enviarEmail.php" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="Email">Digite seu email para recuperar a senha: <span class="required">*</span></label>
                    <input type="text" name="Email" placeholder="aluno@corvo.edu.br" required class="form-control">
                </div>
                <button type="submit" class=" btn btn-primary d-block px-3">Enviar código</button>
            </form>
        </div>
    </div>
    <?php include 'assets/includes/scripts.php'; ?>
</body>

</html>