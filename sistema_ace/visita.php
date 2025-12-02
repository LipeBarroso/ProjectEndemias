<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "init.php"; // conexão com o banco

// Verifica se veio ID pela URL
$id_imovel = isset($_GET['id_imovel']) ? (int) $_GET['id_imovel'] : 0;

if ($id_imovel <= 0) {
  die("Erro: ID do imóvel inválido ou não recebido. Volte e tente novamente.");
}


// Consulta dados do imóvel
$sql_1 = "SELECT * 
          FROM imovel 
          WHERE id_imovel = $id_imovel";

$dados_imovel = $conn->query($sql_1);
$dados_imovel = $dados_imovel->fetch_assoc();
$id_quarteirao = $dados_imovel['id_quarteirao'];

//consulta dados do quarteirao

$sql_registro_geografico = "SELECT 
                                id_quarteirao,
                                numero_quarteirao,
                                cod_area,
                                nome_area,
                                cod_zona
                            FROM registro_geografico
                            WHERE id_quarteirao = $id_quarteirao
                            LIMIT 1";

$dados_quarteirao = $conn->query($sql_registro_geografico);
$dados_quarteirao = $dados_quarteirao->fetch_assoc();

unset($_SESSION['visita_id']);
// verificando se existe visita em andamento
if (!isset($_SESSION['visita_id'])) {

  //verifica se a visita existe para esse imóvel e está em estado aberto, ou seja foi criada mas não finalizada estado = 1 (visita aberta), estado = 0 (visita finalizada)

  $sql_verifica = "SELECT id_visita
                   FROM visita
                   WHERE id_imovel = $id_imovel AND estado = 1 
                   LIMIT 1";

  $resultado_verifica = $conn->query($sql_verifica);

  if ($resultado_verifica->num_rows > 0) {
    //existe a visita e vamos utilizá-la
    $linha = $resultado_verifica->fetch_assoc();

    $_SESSION['visita_id'] = $linha['id_visita'];
  } else { // A visita não existe então vamos criala

    $sql_cria_visita = "INSERT INTO visita(id_imovel, tipo, estado) VALUES (?, 'Normal', 1)";
    $stmt = $conn->prepare($sql_cria_visita);
    
    if ($stmt) {
      $stmt->bind_param("i", $id_imovel);
      
      if ($stmt->execute()) {
        $_SESSION['visita_id'] = $stmt->insert_id;
        $stmt->close();
        
        if (!$_SESSION['visita_id'] || $_SESSION['visita_id'] == 0) {
          die("Erro ao criar visita: ID inválido");
        }
      } else {
        die("Erro ao executar query: " . $stmt->error);
      }
    } else {
      die("Erro ao preparar query: " . $conn->error);
    }
  }
}



$id_visita = $_SESSION['visita_id'];

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Visita Domiciliar</title>
  <style>
    /* === Centralização e layout geral === */
      /* Global box-sizing para layout previsível em dispositivos móveis */
      *, *::before, *::after { box-sizing: border-box; }
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
      padding: 30px 20px;
      width: 100%;
      max-width: 450px;
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

    #depositos {
      display: none;
      padding: 15px;
      border-radius: 8px;
      margin-top: 15px;
      border: 1px solid #ddd;
        width: 100%;
    }

    .deposito-item {
      background: white;
      padding: 12px;
      margin-bottom: 12px;
      border-radius: 6px;
      border-left: 4px solid #009688;
    }

    .btn-adicionar {
      background: #388e3c !important;
    }

    .btn-adicionar:hover {
      background: #2e7d32 !important;
    }

    .btn-remover {
      background: #d32f2f !important;
    }

    .btn-remover:hover {
      background: #c62828 !important;
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
          width: 96%;
          padding: 20px 14px;
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
    <div style="font-size:12px; color:#666; margin-bottom:12px;">
      <a href="index.php" style="color:#1976d2; text-decoration:none;">Home</a> &gt; <a href="area.php" style="color:#1976d2; text-decoration:none;">Áreas</a> &gt; <a href="rg.php?cod_area=<?php echo urlencode($dados_quarteirao['cod_area'] ?? ''); ?>" style="color:#1976d2; text-decoration:none;">Quarteirões</a> &gt; <a href="imoveis.php?id_quarteirao=<?php echo urlencode($id_quarteirao ?? ''); ?>" style="color:#1976d2; text-decoration:none;">Imóveis</a> &gt; <span style="color:#333; font-weight:600;">Visita</span>
    </div>
    <h2><?php echo $dados_quarteirao['nome_area'] . " - " . $dados_quarteirao['numero_quarteirao'] ?></h2>

    <form method="post" action="deposito.php?id_visita=<?php echo $id_visita ?>">
      <label for="id"></label>
      <input value="<?php echo $id_imovel ?>" type="hidden" id="id" name="id">

      <label for="id_quarteirao"></label>
      <input value="<?php echo $dados_quarteirao['id_quarteirao'] ?>" type="hidden" id="id_quarteirao" name="id_quarteirao">

      <label for="cod">Código</label>
      <input value="<?php echo $dados_quarteirao['cod_area'] ?>" type="text" id="cod" name="cod" required>

      <label for="zona">Zona</label>
      <input value="<?php echo $dados_quarteirao['cod_zona'] ?>" type="text" id="zona" name="zona" required>

      <label for="logradouro">Logradouro</label>
      <input value="<?php echo $dados_imovel['nome_rua'] ?>" type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Palmeiras" required>

      <label for="numero">Número</label>
      <input value="<?php echo $dados_imovel['numero_imovel'] ?>" type="text" id="numero" name="numero" required>

      <label for="tipo">Tipo</label>
      <input value="<?php echo $dados_imovel['tipo_imovel'] ?>" type="text" id="tipo" name="tipo" required>

      <label for="h">Habitantes</label>
      <input value="<?php echo $dados_imovel['qtd_habitantes'] ?>" type="number" id="h" name="h">

      <label for="c">Cães</label>
      <input value="<?php echo $dados_imovel['qtd_caes'] ?>" type="number" id="c" name="c" placeholder="Quantidade">

      <label for="g">Gatos</label>
      <input value="<?php echo $dados_imovel['qtd_gatos'] ?>" type="number" id="g" name="g" placeholder="Quantidade">

      <label for="visita">Visita</label>
      <select id="visita" name="visita" required>
        <option value="">Selecione</option>
        <option value="Normal">Normal</option>
        <option value="Repasse">Repasse</option>
      </select>

      <label for="data">Data</label>
      <input type="date" id="data" name="data" required>

      <label for="hora">Hora</label>
      <input type="time" id="hora" name="hora" required>

      <button type="button" onclick="mostrar()" class="btn btn-cancelar">Depósitos</button>

      <div id="depositos">
        <div id="depositos-container">
          <div class="deposito-item">
            <label for="a1_1">A1</label>
            <input type="number" class="a1" name="a1[]" placeholder="Digite A1">
            <label for="focos_a1_1">Focos A1</label>
            <input type="number" class="focos_a1" name="focos_a1[]" placeholder="Quantos possuem foco">
            <label for="larvicida_1">Larvicida</label>
            <input type="number" class="larvicida" name="larvicida[]" placeholder="Qtd Larvicida" min="0" step="0.5">
            <button type="button" onclick="removerDeposito(this)" class="btn btn-remover" style="background: #d32f2f; font-size: 14px; padding: 8px; margin-top: 10px;">Remover</button>
          </div>
        </div>
        <button type="button" onclick="adicionarDeposito()" class="btn btn-adicionar" style="background: #388e3c; font-size: 14px; margin-top: 10px;">+ Adicionar Depósito</button>
      </div>

      <button type="submit" class="btn btn-salvar">Salvar</button>
      <button type="submit" onclick="voltar()" class="btn btn-cancelar">Cancelar</button>
    </form>
  </div>

  <script>
    function voltar() {
      window.location.href = 'imoveis.php?id_quarteirao=<?php echo urlencode($id_quarteirao ?? ''); ?>';
    }

    function mostrar() {
      let div = document.getElementById("depositos");

      if (div.style.display === "none") {
        div.style.display = "block";
      } else {
        div.style.display = "none";
      }
    }

    function adicionarDeposito() {
      const container = document.getElementById("depositos-container");
      const items = container.querySelectorAll(".deposito-item").length;
      const novoId = items + 1;

      const novoItem = document.createElement("div");
      novoItem.className = "deposito-item";
      novoItem.innerHTML = `
        <label for="a1_${novoId}">A1</label>
        <input type="number" class="a1" name="a1[]" placeholder="Digite A1">
        <label for="focos_a1_${novoId}">Focos A1</label>
        <input type="number" class="focos_a1" name="focos_a1[]" placeholder="Quantos possuem foco">
        <label for="larvicida_${novoId}">Larvicida</label>
        <input type="number" class="larvicida" name="larvicida[]" placeholder="Qtd Larvicida" min="0" step="0.5">
        <button type="button" onclick="removerDeposito(this)" class="btn btn-remover" style="background: #d32f2f; font-size: 14px; padding: 8px; margin-top: 10px;">Remover</button>
      `;

      container.appendChild(novoItem);
    }

    function removerDeposito(btn) {
      btn.parentElement.remove();
    }
  </script>

</body>

</html>