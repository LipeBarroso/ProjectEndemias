<?php
require "init.php"; // conexão com o banco (ajuste o caminho conforme seu projeto)

$cod_area = $_GET['cod_area'];


// Consulta principal
$sql = "
    SELECT 
        id_quarteirao,
        numero_quarteirao,
        cod_area,
        nome_area,
        cod_zona,
        qtd_imoveis,
        qtd_residencia,
        qtd_terrenos_baldio,
        qtd_ponto_estrategico,
        qtd_outro,
        qtd_comercio,
        qtd_habitantes,
        qtd_caes,
        qtd_gatos
    FROM registro_geografico
    WHERE cod_area = $cod_area
    ORDER BY numero_quarteirao ASC
";

$result = $conn->query($sql);
$quarteiroes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quarteiroes[] = $row;
    }
}

$conn->close();


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro Geográfico</title>
<link rel="stylesheet" href="style.css">
<style>
  /* Centralização total */
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
    max-width: 800px;
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
    color: #006666;
    font-size: 18px;
    margin-bottom: 20px;
    text-align: center;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }

  th, td {
    border-bottom: 1px solid #ddd;
    text-align: left;
    padding: 10px;
    font-size: 14px;
  }

  th {
    color: #006666;
    font-weight: bold;
    background: #f2f2f2;
  }

  tr:hover {
    background: #f9f9f9;
  }

  .btn {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    margin-top: 10px;
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

  .info-header {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #333;
    margin-bottom: 10px;
  }

  @media (max-width: 700px) {
    .container {
      width: 90%;
      padding: 20px;
    }
    th, td {
      font-size: 13px;
      padding: 8px;
    }
  }
</style>
</head>
<body>

  <div class="container">
    <h2>Registro Geográfico</h2>

    <div class="info-header">
      <div><strong>Área:</strong> <?php echo htmlspecialchars($quarteiroes[0]['nome_area'] ?? 'N/A'); ?></div>
      <div><strong>Zona:</strong> <?php echo htmlspecialchars($quarteiroes[0]['cod_zona'] ?? 'N/A'); ?></div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Quarteirão</th>
          <th>Imóveis</th>
          <th>Residencia</th>
          <th>Comércio</th>
          <th>Habitantes</th>
          <th>Cães</th>
          <th>Gatos</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($quarteiroes)): ?>
          <tr><td colspan="8" style="text-align:center;">Nenhum registro encontrado.</td></tr>
        <?php else: ?>
          <?php foreach ($quarteiroes as $q): ?>
          <tr>
            <td><?php echo htmlspecialchars($q['numero_quarteirao']); ?></td>
            <td><?php echo htmlspecialchars($q['qtd_imoveis']); ?></td>
            <td><?php echo htmlspecialchars($q['qtd_residencia']); ?></td>
            <td><?php echo htmlspecialchars($q['qtd_comercio']); ?></td>
            <td><?php echo htmlspecialchars($q['qtd_habitantes']); ?></td>
            <td><?php echo htmlspecialchars($q['qtd_caes']); ?></td>
            <td><?php echo htmlspecialchars($q['qtd_gatos']); ?></td>
            <td>
              <form action="imoveis.php?id_quarteirao=<?php echo $q['id_quarteirao'] ?> " method="post">
                <button type="submit" class="btn btn-trabalhar" onclick="trabalhar(<?php echo (int)$q['id_quarteirao']; ?>)">Trabalhar</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <button class="btn btn-voltar" onclick="window.history.back()">Voltar</button>
  </div>

<script>
function trabalhar(id) {
  alert('Iniciando trabalho no quarteirão ID ' + id);
}
</script>

</body>
</html>
