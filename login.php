<?php 

include_once 'config.php';

if(isset($_SESSION['id_usuario'])) {
    header('Location: /');
    exit;
}


?>
<!doctype html>
<html lang="pt-BR">

<head>
    <?php include 'assets/includes/head.php'; ?>
    <title>Login - Corvo</title>
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
    </style>
</head>

<body class="p-5">
    <div class="row d-flex align-items-center justify-content-center ">
        <div class="card card-body col-sm-10 col-lg-6 col-xl-4 p-5">
            <div class="d-flex align-items-center flex-column mb-3">
                <img src="<?= $link ?>/assets/img/corvo-logo.png" alt="Logo" width="100px" />
                <h1 class="h4">Faça login</h1>
            </div>
            <form action="<?= $link ?>/assets/php/verificarLogin.php" method="POST">
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
            </form>
        </div>
    </div>
    <?php include 'assets/includes/scripts.php'; ?>
</body>
</html>