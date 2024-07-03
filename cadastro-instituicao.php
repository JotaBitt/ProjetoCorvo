<?php

include 'config.php'; 

if(!isset($_GET['codigo'])) {
    echo 'Código não informado.';
    exit;

}

$stmt = $conn->prepare("SELECT * FROM corvo_instituicoes WHERE codigo = :codigo");
$stmt->bindParam(":codigo", $_GET['codigo']);
$stmt->execute();

$unidade = $stmt->fetch();

if(!$unidade) {
    echo 'Unidade não encontrada.';
    exit;
}

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?php include 'assets/includes/head.php'; ?>
    <title>Cadastro da Instituição - Corvo</title>


    <style>
        html {
            min-height: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url(<?= $link ?>/assets/background/background-corvo.png);
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

<body class="bg-light">

    <div class="row d-flex align-items-center justify-content-center ">
        <div class="card card-body col-sm-10 col-lg-6 col-xl-4 p-5">
            <div class="d-flex align-items-center flex-column mb-3">
                <img src="<?= $link ?>/assets/img/corvo-logo.png" alt="Logo" width="100px" />
                <h1 class="h4">Cadastro da Instituição</h1>
            </div>
        <form action="<?= $link ?>/Cadastro-backend.php" method="post">
            <div class="form-group mb-3">
                <label for="nome" class="form-label">Nome <span class="required">*</span></label>
                <input type="text" name="nome" placeholder="Nome da Unidade" class="form-control" required <?php if(!empty($unidade['usuario'])) { echo 'value="'.$unidade['usuario'].'"'; } ?>/>
            </div>
            <div class="form-group mb-3">
                <label for="cnpj" class="form-label">CNPJ <span class="required">*</span></label>
                <input type="text" name="cnpj" placeholder="CNPJ (somente números)" class="form-control" required />
            </div>
            <div class="form-group mb-3">
                <label for="endereco" class="form-label">Endereço <span class="required">*</span></label>
                <input type="text" name="endereco" placeholder="Endereço" class="form-control" required />
            </div>
            <div class="form-group mb-3">
                <label for="numero" class="form-label">Número <span class="required">*</span></label>
                <input id="num" type="text" name="numero" placeholder="Número (somente números)" class="form-control" required />
                </div>
                <div class="form-group mb-3">
                    <label for="cep" class="form-label">CEP <span class="required">*</span></label>
                    <input type="text" name="cep" placeholder="CEP (somente números)" class="form-control" required />
                </div>
            <div class="form-group mb-3">
                <label for="bairro" class="form-label">Bairro <span class="required">*</span></label>
                <input type="text" name="bairro" placeholder="Bairro" class="form-control" required /></div>
            <div class="row m-1">
                <button type="button" class="btn btn-danger px-3 mx-2 " style="margin-left: 0;">Cancelar</button>
                <button type="submit" class="btn btn-success px-3 mx-2">Confirmar</button>
            </div>

            <input type="hidden" value="<?= $unidade['id'] ?>" name="instituicao">
        </form>
    </div>

    <?php include 'assets/includes/scripts.php'; ?>
    <?php include 'assets/includes/footer.php'; ?>
</body>

</html>