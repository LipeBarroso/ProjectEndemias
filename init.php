<?php
  $host = "localhost";
  $usuario = "root";
  $senha = "";
  $db = "sistema_ace";
  $port = 3306;

  $conn = new mysqli($host,$usuario,$senha,$db,$port);

  if($conn){
    echo '<script>console.log("Conectado")</script>';
  }else{
    echo '<script>console.log("Não Conectado")</script>';
  }

  session_start();

?>



