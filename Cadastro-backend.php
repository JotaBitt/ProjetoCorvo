<?php

include 'Conexao.php';

$stmt = $conn->prepare("INSERT INTO `instituicao` (nome, cnpj, endereco, numero, cep, bairro) VALUES (:nome, :cnpj, :endereco, :numero, :cep, :bairro)");
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":cnpj", $cnpj);
$stmt->bindParam(":endereco", $endereco);
$stmt->bindParam(":numero", $numero);
$stmt->bindParam(":cep", $cep);
$stmt->bindParam(":bairro", $bairro);

var_dump($stmt->execute());

header("Location: Login.html");
exit;