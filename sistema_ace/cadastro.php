<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "init.php"; // conexão com o banco

$id_quarteirao = $_GET['id_quarteirao'];
echo $id_quarteirao;

// Buscar quarteirões existentes
$sql_quarteiroes = "SELECT id_quarteirao, numero_quarteirao, nome_area 
                    FROM registro_geografico 
                    WHERE id_quarteirao = $id_quarteirao
                    LIMIT 1";
$result_quarteiroes = $conn->query($sql_quarteiroes);
$quarteirao = $result_quarteiroes->fetch_assoc();

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Verificar se os campos existem


  $id_quarteirao = intval($_POST['id_quarteirao']);
  $nome_rua = ($_POST['nome_rua']);
  $numero_imovel = ($_POST['numero_imovel']);
  $tipo_imovel = ($_POST['tipo_imovel']);

  $qtd_habitantes = $_POST['qtd_habitantes'] !== '' ? intval($_POST['qtd_habitantes']) : null;
  $qtd_caes       = $_POST['qtd_caes'] !== '' ? intval($_POST['qtd_caes']) : null;
  $qtd_gatos      = $_POST['qtd_gatos'] !== '' ? intval($_POST['qtd_gatos']) : null;

  $sql = "INSERT INTO imovel 
          (id_quarteirao, nome_rua, numero_imovel, tipo_imovel, qtd_habitantes, qtd_caes, qtd_gatos)
          VALUES (?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "isssiii",
    $id_quarteirao,
    $nome_rua,
    $numero_imovel,
    $tipo_imovel,
    $qtd_habitantes,
    $qtd_caes,
    $qtd_gatos
  );

  if ($stmt->execute()) {
    $mensagem = "✅ Imóvel cadastrado com sucesso!";
  } else {
    $mensagem = "❌ Erro ao cadastrar: " . $stmt->error;
  }

  $stmt->close();

  header("Location: imoveis.php?id_quarteirao=$id_quarteirao&ok=1");
  exit;
}




?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Cadastrar Imóvel</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* === Centralização e layout geral === */
    /* Global box-sizing para melhor responsividade */
    *, *::before, *::after { box-sizing: border-box; }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #ffffff;
      margin: 0;
    }

    .form-container {
      background: #fff;
      padding: 30px 20px;
      width: 100%;
      max-width: 450px;
      border-radius: 16px;
      box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .form-container:hover {
      transform: translateY(-5px);
      box-shadow: 0px 12px 35px rgba(0, 0, 0, 0.25);
    }

    h2 {
      text-align: center;
      color: #006666;
      font-size: 20px;
      margin-bottom: 20px;
    }

    .mensagem {
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
      color: #333;
    }

    label {
      font-weight: bold;
      font-size: 14px;
      color: #333;
      display: block;
      margin-top: 12px;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background: #f2f2f2;
      font-size: 14px;
      outline: none;
      transition: border 0.2s;
    }

    input:focus,
    select:focus {
      border-color: #009688;
      background: #fff;
    }

    /* === Botões padronizados === */
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

    .btn-enviar {
      background: #009688;
      color: white;
    }

    .btn-enviar:hover {
      background: #00796b;
    }

    .btn-voltar {
      background: #1976d2;
      color: white;
    }

    .btn-voltar:hover {
      background: #1565c0;
    }

    @media (max-width: 500px) {
      .form-container {
        width: 90%;
        padding: 25px 20px;
      }
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
      <input type="hidden" name="id_quarteirao" value="<?php echo $quarteirao['id_quarteirao'] ?>">
      <input type="text" readonly id="id_quarteirao"
        value="<?php echo $quarteirao['nome_area'] . ' - ' . $quarteirao['numero_quarteirao']; ?>">

      <label for="nome_rua">Nome da Rua</label>
      <input type="text" name="nome_rua" id="nome_rua">

      <label for="numero_imovel">Número do Imóvel</label>
      <input type="text" name="numero_imovel" id="numero_imovel">

      <label for="tipo_imovel">Tipo do Imóvel</label>
      <select name="tipo_imovel" id="tipo_imovel">
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

      <button type="submit" class="btn btn-enviar">Cadastrar</button>

    </form>


    <a href="imoveis.php?id_quarteirao=<?php echo $id_quarteirao ?>" class="btn btn-voltar">
      Cancelar
    </a>

  </div>

</body>

</html>