<?php
   $servidor = "localhost";
   $username = "root";
   $senha = "";
   $database = "4ads";

   $siglaCurso = $_POST["siglaCurso"];

   $conn = new mysqli($servidor,$username,$senha,$database);
   if ($conn->connect_error) {
      die("Conexao falhou, avise o administrador do sistema");
   }
   $comandoSQL = "SELECT * FROM `corvo_curso_usuarios` WHERE siglaCurso = '$siglaCurso'";
   $resultado = $conn->query($comandoSQL);
   $arrPerguntas = array();  // Declare $arrPerguntas here
   $i = 0;
   While ($linha = $resultado->fetch_assoc()){
       $arrPerguntas[$i] = $linha;
       $i++;
   }
   if ($resultado=true){
       $retorno=json_encode($arrPerguntas);
   } else {
       $retorno=json_encode("ERRO");
   }

   echo $retorno;
?>