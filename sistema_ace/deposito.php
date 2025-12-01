<?php
require "init.php";

// Verifica se veio ID da visita pela URL
$id_visita = isset($_GET['id_visita']) ? (int) $_GET['id_visita'] : 0;

if ($id_visita == 0) {
    echo '<script>alert("Erro: ID da visita não informado."); window.location.href = "index.php";</script>';
    exit;
}

// Consulta dados da visita
$sql_visita = "SELECT v.*, i.* 
               FROM visita v 
               LEFT JOIN imovel i ON v.id_imovel = i.id_imovel 
               WHERE v.id_visita = ?";

$stmt_visita = $conn->prepare($sql_visita);
$stmt_visita->bind_param("i", $id_visita);
$stmt_visita->execute();
$resultado = $stmt_visita->get_result();

if ($resultado->num_rows == 0) {
    echo '<script>alert("Erro: Visita não encontrada."); window.location.href = "index.php";</script>';
    exit;
}

$dados_visita = $resultado->fetch_assoc();
$stmt_visita->close();

// Se o formulário for enviado
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a1 = isset($_POST['a1']) ? (int)$_POST['a1'] : 0;
    $focos_a1 = isset($_POST['focos_a1']) ? (int)$_POST['focos_a1'] : 0;
    $larvicida = isset($_POST['larvicida']) ? floatval($_POST['larvicida']) : 0;

    $sql_update = "INSERT INTO deposito(id_visita, a1, focos_a1, larvicida) 
                   VALUES(?, ?, ?, ?)";
    
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiid", $id_visita, $a1, $focos_a1, $larvicida);
    
    if ($stmt_update->execute()) {
        $mensagem = "✅ Depósitos registrados com sucesso!";
    } else {
        $mensagem = "❌ Erro ao registrar: " . $stmt_update->error;
    }
    
    $stmt_update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Depósitos</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #ffffff;
      margin: 0;
      padding: 20px;
    }

    .form-container {
      background: #fff;
      padding: 40px 30px;
      width: 100%;
      max-width: 500px;
      border-radius: 16px;
      box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .form-container:hover {
      transform: translateY(-3px);
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.25);
    }

    h2 {
      text-align: center;
      color: #006666;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .info-box {
      background: #f0f7ff;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 25px;
      border-left: 4px solid #009688;
    }

    .info-item {
      font-size: 14px;
      color: #333;
      margin: 5px 0;
    }

    .info-item strong {
      color: #006666;
    }

    .mensagem {
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
      padding: 12px;
      border-radius: 8px;
      color: #333;
    }

    .mensagem.sucesso {
      background: #c8e6c9;
      color: #2e7d32;
    }

    .mensagem.erro {
      background: #ffcdd2;
      color: #c62828;
    }

    label {
      font-weight: bold;
      font-size: 14px;
      color: #333;
      display: block;
      margin-top: 15px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background: #f2f2f2;
      font-size: 14px;
      outline: none;
      transition: border 0.2s;
      box-sizing: border-box;
    }

    input:focus, select:focus {
      border-color: #009688;
      background: #fff;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      border: none;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      margin-top: 15px;
      text-decoration: none;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .btn-salvar {
      background: #009688;
      color: white;
    }

    .btn-salvar:hover {
      background: #00796b;
    }

    .btn-cancelar {
      background: #1976d2;
      color: white;
    }

    .btn-cancelar:hover {
      background: #1565c0;
    }

    .btn-group {
      display: flex;
      gap: 10px;
    }

    .btn-group .btn {
      flex: 1;
      margin-top: 0;
    }

    .btn-group .btn:first-child {
      margin-top: 15px;
    }

    @media (max-width: 600px) {
      .form-container {
        width: 95%;
        padding: 25px 20px;
      }

      h2 {
        font-size: 18px;
      }

      label {
        font-size: 13px;
      }

      input, select {
        font-size: 13px;
        padding: 9px;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>📋 Registrar Depósitos</h2>

    <div class="info-box">
      <div class="info-item"><strong>Imóvel:</strong> <?php echo htmlspecialchars($dados_visita['nome_rua'] ?? 'N/A'); ?>, <?php echo htmlspecialchars($dados_visita['numer_imovel'] ?? 'N/A'); ?></div>
      <div class="info-item"><strong>Tipo:</strong> <?php echo htmlspecialchars($dados_visita['tipo_imovel'] ?? 'N/A'); ?></div>
      <div class="info-item"><strong>Habitantes:</strong> <?php echo htmlspecialchars($dados_visita['qtd_habitantes'] ?? '0'); ?></div>
    </div>

    <?php if (!empty($mensagem)): ?>
      <div class="mensagem <?php echo strpos($mensagem, '✅') !== false ? 'sucesso' : 'erro'; ?>">
        <?php echo htmlspecialchars($mensagem); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="a1">Quantidade de A1</label>
      <input type="number" name="a1" id="a1" min="0" value="0" required>

      <label for="focos_a1">Focos de A1 encontrados</label>
      <input type="number" name="focos_a1" id="focos_a1" min="0" value="0" required>

      <label for="larvicida">Quantidade de Larvicida (litros)</label>
      <input type="number" name="larvicida" id="larvicida" min="0" step="0.5" value="0" required>

      <div class="btn-group">
        <button type="submit" class="btn btn-salvar">💾 Salvar Depósitos</button>
        <a href="javascript:window.history.back()" class="btn btn-cancelar">← Voltar</a>
      </div>
    </form>
  </div>

</body>
</html>






?>