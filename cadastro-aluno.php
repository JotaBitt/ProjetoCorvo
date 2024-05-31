<!doctype html>
<html lang="pt-BR">

<head>
    <?php include 'assets/includes/head.php'; ?>
    <title>Cadastro - Corvo</title>
    <style>
        html {
            min-height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url(/assets/background/background-corvo.png);
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
        <div class="card card-body col-4 p-5">
            <div class="d-flex align-items-center flex-column mb-3">
                <a href="index.html">
                    <img src="/img/corvo-logo.png" alt="Logo" width="100px" />
                </a>
                <h1 class="h4">Cadastre-se</h1>
            </div>
            <form action="/assets/php/cadastrarAluno.php" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="usuario" class="form-label">Usuário <span class="required">*</span></label>
                    <input type="text" name="usuario" placeholder="aluno.0000000000001" required class="form-control" />
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">E-mail <span class="required">*</span></label>
                    <input type="email" name="email" placeholder="aluno.0000000000001@escola.edu.br" required class="form-control" />
                </div>
                <div class="form-group mb-4">
                    <label for="senha" class="form-label">Senha <span class="required">*</span></label>
                    <input type="password" name="senha" placeholder="************" required class="form-control" />
                </div>
                <div class="form-group mb-4">
                    <label for="confirmar_senha" class="form-label">Confirmar senha <span class="required">*</span></label>
                    <input type="password" name="confirmar_senha" placeholder="************" required class="form-control" />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary d-block px-3">Cadastrar</button>
                </div>


            </form>
        </div>
    </div>
    <?php include 'assets/includes/scripts.php'; ?>
</body>
</html>