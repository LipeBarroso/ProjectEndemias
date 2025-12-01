<?php
require "init.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_visita = isset($_GET['id_visita']) ? intval($_GET['id_visita']) : 0;

if ($id_visita <= 0) {
    die("ID da visita inválido.");
}

// ===========================
// DADOS DO IMÓVEL
// ===========================

$id_imovel   = $_POST['id'];
$logradouro  = $_POST['logradouro'];
$numero      = $_POST['numero'];
$tipo        = $_POST['tipo'];
$habitantes  = $_POST['h'];
$caes        = $_POST['c'];
$gatos       = $_POST['g'];

// Atualizando dados do imóvel
$sql_atualiza_imovel = "
    UPDATE imovel 
    SET nome_rua = '$logradouro',
        numero_imovel = '$numero',
        tipo_imovel = '$tipo',
        qtd_habitantes = $habitantes,
        qtd_caes = $caes,
        qtd_gatos = $gatos
    WHERE id_imovel = $id_imovel
";

$conn->query($sql_atualiza_imovel);

// ===========================
// DADOS DA VISITA
// ===========================

$visita_tipo = $_POST['visita'];
$hora        = $_POST['hora'];

// se o formulário não tem input data, usa a data atual
if (!empty($_POST['data'])) {
    $data = $_POST['data']; // data do formulário
} else {
    $data = date("Y-m-d");  // data atual
}

// Atualizando visita
$sql_atualiza_visita = "
    UPDATE visita
    SET tipo = '$visita_tipo',
        hora = '$hora',
        data = '$data',
        estado = 0
    WHERE id_visita = $id_visita
";

$conn->query($sql_atualiza_visita);

// ===========================

$id_quarteirao = $_POST['id_quarteirao'];

// Fecha conexão DEPOIS do header
$conn->close();

echo "<script>alert('Registro salvo com sucesso!');</script>";

header("Location: imoveis.php?id_quarteirao=$id_quarteirao");
exit();
