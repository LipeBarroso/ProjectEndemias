<?php
  $host = "localhost";
  $usuario = "root";
  $senha = "";
  $db = "sistema_ace";
  $port = 3306;

  $conn = new mysqli($host, $usuario, $senha, $db, $port);

  if ($conn->connect_error) {
    error_log("MySQL connection failed: " . $conn->connect_error);
    // Do not echo or print here — keep output-free to avoid header/session issues.
  }

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

?>



