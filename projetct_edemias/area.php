<?php
require "../init.php"; // conexão com o banco (ajuste o caminho conforme seu projeto)

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
  <title>Areas</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <div class="card">
    <button class="back-btn" onclick="history.back()">←</button>


    <table>
      <thead>
        <tr>
          <th>CODIGO</th>
          <th>ZONA</th>
          <th>NOME DA AREA</th>
          <th>QTD QUARTEIRAO</th>
          <th>QTD HABITANTES</th>
          <th>QTD CAES</th>
          <th>QTD GATOS</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($areas as $a):
  
        ?>
          <tr>
            <td><?php echo $a['cod_area']; ?></td>
            <td><?php echo $a['cod_zona']; ?></td>
            <td><?php echo $a['nome_area']; ?></td>
            <td><?php echo $a['qtd_quarteiroes']; ?></td>
            <td><?php echo $a['qtd_habitantes']; ?></td>
            <td><?php echo $a['qtd_caes']; ?></td>
            <td><?php echo $a['qtd_gatos']; ?></td>
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
