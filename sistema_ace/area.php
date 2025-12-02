<?php
require "init.php"; // conexão com o banco (ajuste o caminho conforme seu projeto)

// Consulta principal
$sql = "
    SELECT * FROM `area` ORDER by nome_area ASC;
";

$result = $conn->query($sql);
$areas = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $areas[] = $row;
  }
}


$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Áreas</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* melhora responsividade: box-sizing para todos os elementos */
    *, *::before, *::after { box-sizing: border-box; }
    /* === Centralização geral === */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #ffffff;
      margin: 0;
    }

    .container {
      background: #fff;
      width: 95%;
      max-width: 900px;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .container:hover {
      transform: translateY(-5px);
      box-shadow: 0px 12px 35px rgba(0, 0, 0, 0.25);
    }

    h2 {
      text-align: center;
      color: #006666;
      font-size: 20px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      border-bottom: 1px solid #ddd;
      text-align: left;
      padding: 10px;
      font-size: 14px;
      vertical-align: middle;
    }

    th {
      color: #006666;
      font-weight: bold;
      background: #f2f2f2;
    }

    tr:hover {
      background: #f9f9f9;
    }

    /* === Botões === */
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
      margin-top: 10px;
      text-decoration: none;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .btn-trabalhar {
      background: #009688;
      color: white;
    }

    .btn-trabalhar:hover {
      background: #00796b;
    }

    .btn-voltar {
      background: #1976d2;
      color: white;
    }

    .btn-voltar:hover {
      background: #1565c0;
    }

    .back-btn {
      background: #1976d2;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      padding: 10px 15px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      margin-bottom: 15px;
    }

    .back-btn:hover {
      background: #1565c0;
      transform: translateY(-2px);
    }

    @media (max-width: 700px) {
      .container {
        width: 96%;
        padding: 16px;
      }

      th,
      td {
        font-size: 13px;
        padding: 8px;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <div style="font-size:12px; color:#666; margin-bottom:16px;">
      <a href="index.php" style="color:#1976d2; text-decoration:none;">Home</a> &gt; <span style="color:#333; font-weight:600;">Áreas</span>
    </div>
    <h2>Áreas Cadastradas</h2>

    <table>
      <thead>
        <tr>
          <th>Código</th>
          <th>Zona</th>
          <th>Nome da Área</th>
          <th>Qtd. Quarteirões</th>
          <th>Qtd. Habitantes</th>
          <th>Qtd. Cães</th>
          <th>Qtd. Gatos</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($areas)): ?>
          <tr>
            <td colspan="8" style="text-align:center;">Nenhuma área encontrada.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($areas as $a): ?>
            <tr>
              <td><?php echo htmlspecialchars($a['cod_area']); ?></td>
              <td><?php echo htmlspecialchars($a['cod_zona']); ?></td>
              <td><?php echo htmlspecialchars($a['nome_area']); ?></td>
              <td><?php echo htmlspecialchars($a['qtd_quarteiroes']); ?></td>
              <td><?php echo htmlspecialchars($a['qtd_habitantes']); ?></td>
              <td><?php echo htmlspecialchars($a['qtd_caes']); ?></td>
              <td><?php echo htmlspecialchars($a['qtd_gatos']); ?></td>
              <td>
                <form action="rg.php?cod_area=<?php echo $a['cod_area']; ?>" method="post">
                  <button type="submit" class="btn btn-trabalhar" onclick="trabalhar('<?php echo addslashes($a['nome_area']); ?>')">Trabalhar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <a href="index.php" class="btn btn-voltar">Voltar</a>
  </div>

  <script>
    function trabalhar(area) {
      alert("Iniciando trabalho na área: " + area);
      // Exemplo: window.location.href = "rg.php?area=" + encodeURIComponent(area);
    }
  </script>

</body>

</html>