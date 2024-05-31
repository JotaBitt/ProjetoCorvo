<!doctype html>
<html lang="pt-BR">

<head>
    <?php include 'assets/includes/head.php'; ?>
    <title>Instalação - Corvo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(/assets/background/background-corvo.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin: auto;
            margin-top: 100px;
            -webkit-box-shadow: 1px 5px 28px 6px rgba(0, 0, 0, 1);
            -moz-box-shadow: 1px 5px 28px 6px rgba(0, 0, 0, 1);
            box-shadow: 1px 5px 28px 6px rgba(0, 0, 0, 1);
        }

        .container h2 {
            margin-bottom: 20px;
        }

        .container input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container .half-width {
            display: flex;
            border-radius: 5px;
            width: 100%;
        }

        #num {
            
        }

        .container .row {
            display: flex;
            justify-content: space-between;
        }

        .container button {
            width: 48%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container button.cancel {
            background-color: #ccc;
        }

        .container button.confirm {
            background-color: #3a416f;
            color: white;
        }

        header {
            display: flex;
            align-items: center;
            margin: auto;
            justify-content: space-between;
            border-bottom: 1px solid black;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container">
        <a href="/">
            <img src="/img/corvo-logo.png" alt="Logo" style="width: 50px" />
        </a>
        <h2>Cadastre-se</h2>
        <form action="Cadastro.php" method="post">
            <input type="text" name="nome" placeholder="Nome da Unidade" required />
            <input type="text" name="cnpj" placeholder="CNPJ (Somente Numeros)" required />
            <input type="text" name="endereco" placeholder="Endereço" required />
            <div class="half-width">
                <input id="num" type="text" name="numero" placeholder="Número (Somente Numeros)" required />
                <input type="text" name="cep" placeholder="CEP (Somente Numeros)" required />
            </div>
            <input type="text" name="bairro" placeholder="Bairro" required />
            <div class="row">
                <button type="button" class="cancel">Cancelar</button>
                <button type="submit" class="confirm">Confirmar</button>
            </div>
        </form>
    </div>

    <?php include 'assets/includes/scripts.php'; ?>
</body>

</html>