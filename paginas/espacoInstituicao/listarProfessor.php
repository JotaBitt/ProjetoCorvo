<?php
   include '../../config_mysqli.php';
   $comandoSQL = "SELECT * from `corvo_professor`";
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