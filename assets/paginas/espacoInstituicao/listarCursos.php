<?php
   $servidor = "localhost";
   $username = "root";
   $senha = "";
   $database = "4ads";
   $conn = new mysqli($servidor,$username,$senha,$database);
   if ($conn->connect_error) {
      die("Conexao falhou, avise o administrador do sistema");
   }
   $comandoSQL = "SELECT * from `corvo_cursos`";
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