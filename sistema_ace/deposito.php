<?php
require "init.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_visita = isset($_GET['id_visita']) ? intval($_GET['id_visita']) : 0;

if ($id_visita < 0) {
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
unset($_SESSION['visita_id']);

// ===========================
// INSERIR MÚLTIPLOS DEPÓSITOS
// ===========================

$a1_array = isset($_POST['a1']) ? $_POST['a1'] : [];
$focos_a1_array = isset($_POST['focos_a1']) ? $_POST['focos_a1'] : [];
$larvicida_array = isset($_POST['larvicida']) ? $_POST['larvicida'] : [];

// Preparar statement para inserção de depósitos
$sql_deposito = "INSERT INTO deposito (id_visita, tipo, foco, qtd_larvicida) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_deposito);

if (!$stmt) {
    die("Erro ao preparar a query: " . $conn->error);
}

// Inserir cada depósito
for ($i = 0; $i < count($a1_array); $i++) {
    $a1 = isset($a1_array[$i]) ? intval($a1_array[$i]) : 0;
    $focos = isset($focos_a1_array[$i]) ? intval($focos_a1_array[$i]) : 0;
    $larvicida = isset($larvicida_array[$i]) ? floatval($larvicida_array[$i]) : 0;

    // Se todos os campos estão vazios, pula este item
    if ($a1 == 0 && $focos == 0 && $larvicida == 0) {
        continue;
    }

    // A1 é o tipo (A1, A2, etc)
    // focos define se tem foco (true/false)
    $tipo = "A" . $a1;
    $foco = $focos > 0 ? 1 : 0;

    $stmt->bind_param("isid", $id_visita, $tipo, $foco, $larvicida);
    
    if (!$stmt->execute()) {
        echo "Erro ao inserir depósito " . ($i + 1) . ": " . $stmt->error . "<br>";
    }
}

$stmt->close();

// ===========================

$id_quarteirao = $_POST['id_quarteirao'];

// Fecha conexão DEPOIS do header
$conn->close();

// Set a flash message in session instead of echoing JS (prevents output-before-headers)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['flash'] = 'Registro salvo com sucesso!';

header("Location: imoveis.php?id_quarteirao=$id_quarteirao");
exit();
?>