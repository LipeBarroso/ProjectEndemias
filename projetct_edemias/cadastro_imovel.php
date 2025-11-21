<?php
require "../init.php"; // conexão com o banco

// Buscar quarteirões existentes
$sql_quarteiroes = "SELECT id_quarteirao, numero_quarteirao, nome_area 
                    FROM registro_geografico 
                    ORDER BY numero_quarteirao ASC";
$result_quarteiroes = $conn->query($sql_quarteiroes);

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_quarteirao = intval($_POST['id_quarteirao']);
    $nome_rua = trim($_POST['nome_rua']);
    $numer_imovel = trim($_POST['numer_imovel']);
    $tipo_imovel = trim($_POST['tipo_imovel']);
    $qtd_habitantes = $_POST['qtd_habitantes'] !== '' ? intval($_POST['qtd_habitantes']) : null;
    $qtd_caes = $_POST['qtd_caes'] !== '' ? intval($_POST['qtd_caes']) : null;
    $qtd_gatos = $_POST['qtd_gatos'] !== '' ? intval($_POST['qtd_gatos']) : null;

    $sql = "INSERT INTO imovel (id_quarteirao, nome_rua, numer_imovel, tipo_imovel, qtd_habitantes, qtd_caes, qtd_gatos)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // 'i' = inteiro, 's' = string
    $stmt->bind_param("isssiii", $id_quarteirao, $nome_rua, $numer_imovel, $tipo_imovel, $qtd_habitantes, $qtd_caes, $qtd_gatos);

    if ($stmt->execute()) {
        $mensagem = "✅ Imóvel cadastrado com sucesso!";
    } else {
        $mensagem = "❌ Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Imóvel</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .form-container {
      background: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    label {
      font-weight: 500;
      margin-top: 10px;
      display: block;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      background-color: #0066cc;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background-color: #004999;
    }
    .mensagem {
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
    }
    a.voltar {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #0066cc;
      text-decoration: none;
    }
    a.voltar:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Cadastrar Imóvel</h2>

    <?php if (!empty($mensagem)): ?>
      <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="id_quarteirao">Quarteirão</label>
      <select name="id_quarteirao" id="id_quarteirao" required>
        <option value="">Selecione...</option>
        <?php if ($result_quarteiroes->num_rows > 0): ?>
          <?php while ($q = $result_quarteiroes->fetch_assoc()): ?>
            <option value="<?php echo $q['id_quarteirao']; ?>">
              <?php echo $q['numero_quarteirao'] . " - " . $q['nome_area']; ?>
            </option>
          <?php endwhile; ?>
        <?php endif; ?>
      </select>

      <label for="nome_rua">Nome da Rua</label>
      <input type="text" name="nome_rua" id="nome_rua" required>

      <label for="numer_imovel">Número do Imóvel</label>
      <input type="text" name="numer_imovel" id="numer_imovel" required>

      <label for="tipo_imovel">Tipo do Imóvel</label>
      <select name="tipo_imovel" id="tipo_imovel" required>
        <option value="">Selecione...</option>
        <option value="Residencial">Residencial</option>
        <option value="Comercial">Comercial</option>
        <option value="Terreno Baldio">Terreno Baldio</option>
        <option value="Ponto Estratégico">Ponto Estratégico</option>
        <option value="Outro">Outro</option>
      </select>

      <label for="qtd_habitantes">Qtd. Habitantes</label>
      <input type="number" name="qtd_habitantes" id="qtd_habitantes" min="0">

      <label for="qtd_caes">Qtd. Cães</label>
      <input type="number" name="qtd_caes" id="qtd_caes" min="0">

      <label for="qtd_gatos">Qtd. Gatos</label>
      <input type="number" name="qtd_gatos" id="qtd_gatos" min="0">

      <button type="submit">Cadastrar</button>
    </form>

    <a href="index.php" class="voltar">← Voltar</a>
  </div>
</body>
</html>
