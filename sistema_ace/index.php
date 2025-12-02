<?php
require "init.php";

// Consulta estatísticas do sistema
$sql_areas = "SELECT COUNT(*) as total FROM area";
$result_areas = $conn->query($sql_areas);
$total_areas = $result_areas->fetch_assoc()['total'];

$sql_imoveis = "SELECT COUNT(*) as total FROM imovel";
$result_imoveis = $conn->query($sql_imoveis);
$total_imoveis = $result_imoveis->fetch_assoc()['total'];

$sql_visitas = "SELECT COUNT(*) as total FROM visita";
$result_visitas = $conn->query($sql_visitas);
$total_visitas = $result_visitas->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema ACE - Endemias</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Resposta: garante box-sizing consistente e melhora comportamento em telas pequenas */
    *, *::before, *::after { box-sizing: border-box; }
    /* === Estilo principal === */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      background: #fff;
      width: 95%;
      max-width: 600px;
      padding: 50px 40px;
      border-radius: 16px;
      box-shadow: 0px 15px 45px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    h1 {
      color: #006666;
      font-size: 28px;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #666;
      font-size: 14px;
      margin-bottom: 40px;
    }

    /* === Cards de estatísticas === */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 15px;
      margin-bottom: 40px;
    }

    .stat-card {
      background: #f0f7ff;
      padding: 20px;
      border-radius: 12px;
      border-left: 4px solid #009688;
    }

    .stat-number {
      font-size: 28px;
      font-weight: bold;
      color: #009688;
    }

    .stat-label {
      font-size: 12px;
      color: #666;
      margin-top: 5px;
      text-transform: uppercase;
    }

    /* === Menu de opções === */
    .menu-container {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      color: white;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
      background: #009688;
    }

    .btn-primary:hover {
      background: #00796b;
    }

    .btn-secondary {
      background: #1976d2;
    }

    .btn-secondary:hover {
      background: #1565c0;
    }

    .btn-info {
      background: #f57c00;
    }

    .btn-info:hover {
      background: #e65100;
    }

    .btn-success {
      background: #388e3c;
    }

    .btn-success:hover {
      background: #2e7d32;
    }

    /* === Responsividade === */
    @media (max-width: 600px) {
      .container {
        width: 96%;
        padding: 24px 16px;
      }

      h1 { font-size: 22px; }

      .btn { font-size: 14px; padding: 12px; }

      /* permitir que os cards se ajustem melhor em telas pequenas */
      .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <h1>🏥 Sistema ACE</h1>
    <p class="subtitle">Área de Controle de Endemias</p>

    <div class="stats-container">
      <div class="stat-card">
        <div class="stat-number"><?php echo $total_areas; ?></div>
        <div class="stat-label">Áreas</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $total_imoveis; ?></div>
        <div class="stat-label">Imóveis</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $total_visitas; ?></div>
        <div class="stat-label">Visitas</div>
      </div>
    </div>

    <div class="menu-container">
      <a href="area.php" class="btn btn-primary">📍 Gerenciar Áreas</a>
      <a href="boletim_diario.php" class="btn btn-info">📋 Boletim Diário</a>
    </div>
  </div>

</body>

</html>