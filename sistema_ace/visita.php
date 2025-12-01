<?php
require "init.php"; // conexão com o banco

// Verifica se veio ID pela URL
$id_imovel = isset($_GET['id_imovel']) ? (int) $_GET['id_imovel'] : 0;

if ($id_imovel == 0) {
    echo '<script>alert("Erro: ID do imóvel não informado."); window.location.href = "index.php";</script>';
    exit;
}

// Consulta dados do imóvel
$sql_1 = "SELECT * 
          FROM imovel 
          WHERE id_imovel = ?";

$stmt_1 = $conn->prepare($sql_1);
$stmt_1->bind_param("i", $id_imovel);
$stmt_1->execute();
$resultado = $stmt_1->get_result();

if ($resultado->num_rows == 0) {
    echo '<script>alert("Erro: Imóvel não encontrado."); window.location.href = "index.php";</script>';
    exit;
}

$dados_imovel = $resultado->fetch_assoc();
$stmt_1->close();

// Criando a visita para poder alterá-la ou salvar
$tipo = isset($dados_imovel['tipo_imovel']) ? htmlspecialchars($dados_imovel['tipo_imovel']) : '';

$sql_2 = "INSERT INTO visita(id_imovel, tipo) VALUES(?, ?)";
$stmt_insert = $conn->prepare($sql_2);
$stmt_insert->bind_param("is", $id_imovel, $tipo);
$stmt_insert->execute();
$id_visita = $conn->insert_id;
$stmt_insert->close();




// Se o formulário for enviado
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_imovel = (int) $_POST['id'];
    $nome_rua = $_POST['logradouro'] ?? '';
    $numer_imovel = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $qtd_habitantes = (int) ($_POST['h'] ?? 0);
    $qtd_caes = (int) ($_POST['c'] ?? 0);
    $qtd_gatos = (int) ($_POST['g'] ?? 0);

    $sql = "UPDATE imovel 
            SET nome_rua = ?, 
                numero_imovel = ?, 
                tipo_imovel = ?, 
                qtd_habitantes = ?, 
                qtd_caes = ?, 
                qtd_gatos = ? 
            WHERE id_imovel = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiii", $nome_rua, $numero_imovel, $tipo, $qtd_habitantes, $qtd_caes, $qtd_gatos, $id_imovel);
    
    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Dados atualizados com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>❌ Erro ao atualizar: " . $conn->error . "</p>";
    }

    $stmt->close();
}
*/
$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Visita Domiciliar</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* === Centralização e layout geral === */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #ffffff;
      margin: 0;
      padding: 50px;
      margin-top: 20px;
    }

    .form-container {
      background: #fff;
      padding: 40px 30px;
      width: 380px;
      max-width: 95%;
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
      margin-bottom: 20px;
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

    /* === Responsividade === */
    @media (max-width: 768px) {
      .form-container {
        width: 90%;
        padding: 50px 25px;
      }

      h2 {
        font-size: 18px;
      }

      label {
        font-size: 13px;
      }

      input,
      select {
        font-size: 13px;
        padding: 9px;
      }

      .btn {
        font-size: 15px;
        padding: 11px;
      }
    }

    @media (max-width: 480px) {
      body {
        align-items: flex-start;
        padding-top: 30px;
      }

      .form-container {
        width: 100%;
        padding: 25px 18px;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
      }

      .campo {
        position: relative;
        display: inline-block;
      }

      .campo input {
        width: 10%;
      }

      h2 {
        font-size: 17px;
      }

      label {
        font-size: 13px;
      }

      input,
      select {
        font-size: 13px;
      }

      .btn {
        font-size: 15px;
      }
    }

    @media (min-width: 1200px) {
      .form-container {
        width: 450px;
      }
    }
  </style>
</head>

<body>

  <div class="form-container">
    <h2>🏠 Registrar Visita Domiciliar</h2>

    <form method="post" action="deposito.php?id_visita=<?php echo htmlspecialchars($id_visita); ?>">
      <label for="logradouro">Logradouro</label>
      <input value="<?php echo htmlspecialchars($dados_imovel['nome_rua'] ?? ''); ?>" type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Palmeiras" readonly>

      <label for="numero">Número</label>
      <input value="<?php echo htmlspecialchars($dados_imovel['numer_imovel'] ?? ''); ?>" type="text" id="numero" name="numero" placeholder="Ex: 25" readonly>

      <label for="tipo">Tipo de Imóvel</label>
      <input value="<?php echo htmlspecialchars($dados_imovel['tipo_imovel'] ?? ''); ?>" type="text" id="tipo" name="tipo" placeholder="Ex: Residencial" readonly>

      <label for="h">Habitantes</label>
      <input value="<?php echo htmlspecialchars($dados_imovel['qtd_habitantes'] ?? ''); ?>" type="number" id="h" name="h" placeholder="Ex: 5" readonly>

      <label for="c">Cães</label>
      <input value="<?php echo htmlspecialchars($dados_imovel['qtd_caes'] ?? ''); ?>" type="number" id="c" name="c" placeholder="Quantidade" readonly>

      <label for="g">Gatos</label>
      <input value="<?php echo htmlspecialchars($dados_imovel['qtd_gatos'] ?? ''); ?>" type="number" id="g" name="g" placeholder="Quantidade" readonly>

      <label for="visita">Tipo de Visita</label>
      <select id="visita" name="visita" required>
        <option value="">Selecione...</option>
        <option value="Normal">Normal</option>
        <option value="Repasse">Repasse</option>
      </select>

      <label for="hora">Hora da Visita</label>
      <input type="time" id="hora" name="hora" required>

      <button type="submit" class="btn btn-salvar">Próximo: Registrar Depósitos →</button>
      <a href="javascript:window.history.back()" class="btn btn-cancelar">← Voltar</a>
    </form>
  </div>

  <script>
    function voltar() {
      window.history.back();
    }
  </script>

</body>

</html>