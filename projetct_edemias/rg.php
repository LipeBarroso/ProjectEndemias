<?php
require "../init.php"; // conexão com o banco (ajuste o caminho conforme seu projeto)

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
  <title><?php echo $quarteiroes[0] ? $quarteiroes[0]['nome_area'] : 'Área'; ?></title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <div class="card">
    <button class="back-btn" onclick="history.back()">←</button>
    <h2><?php echo strtoupper($quarteiroes[0]['nome_area'] ?? 'N/A'); ?></h2>

    <div class="info">
      <span>COD: <a><?php echo $quarteiroes[0]['cod_area'] ?? '-'; ?></a></span>
      <span>ZONA: <a><?php echo $quarteiroes[0]['cod_zona'] ?? '-'; ?></a></span>
     
    </div>

    <table>
      <thead>
        <tr>
          <th>QUARTEIRAO</th>
          <th>IMÓVEIS</th>
          <th>RES.</th>
          <th>COM.</th>
          <th>HAB.</th>
          <th>CÃES</th>
          <th>GATOS</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($quarteiroes as $q):
  
        ?>
          <tr>
            <td><?php echo $q['numero_quarteirao']; ?></td>
            <td><?php echo $q['qtd_imoveis']; ?></td>
            <td><?php echo $q['qtd_residencia']; ?></td>
            <td><?php echo $q['qtd_comercio']; ?></td>
            <td><?php echo $q['qtd_habitantes']; ?></td>
            <td><?php echo $q['qtd_caes']; ?></td>
            <td><?php echo $q['qtd_gatos']; ?></td>
            <td><button class="btn" onclick="alert('Iniciando trabalho no quarteirão selecionado!')">Trabalhar</button> </td>

          </tr>

        <?php 
        endforeach;
        ?>  
        
      </tbody>
    </table>

   
  </script>
</body>
</html>
