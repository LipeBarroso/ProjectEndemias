<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Visita Domiciliar</title>
    <style>
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
            padding: 30px 20px;
            width: 100%;
            max-width: 450px;
            border-radius: 16px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
        }
        .breadcrumb {
            font-size: 12px;
            color: #666;
            margin-bottom: 16px;
        }
        .breadcrumb a {
            color: #1976d2;
            text-decoration: none;
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
        .btn-finalizar {
            background: #388e3c;
            color: white;
        }
        .btn-finalizar:hover {
            background: #2e7d32;
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
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .deposito-lista {
            margin-top: 15px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }
        .deposito-lista h4 {
            margin-top: 0;
            color: #006666;
        }
        .deposito-lista-item {
            background: white;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #009688;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .deposito-lista-item a {
            background: #d32f2f;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
        }
        .deposito-lista-item a:hover {
            background: #c62828;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="breadcrumb">
            <a href="?action=dashboard">Home</a> &gt; <a href="?action=area-index">Áreas</a> &gt; <a href="?action=quarteirao-list&cod_area=<?php echo urlencode($dados_quarteirao['cod_area']); ?>">Quarteirões</a> &gt; <a href="?action=imovel-list&id_quarteirao=<?php echo $id_quarteirao; ?>">Imóveis</a> &gt; <span style="color:#333; font-weight:600;">Visita</span>
        </div>
        <h2><?php echo htmlspecialchars($dados_quarteirao['nome_area'] . " - Quarteirão " . $dados_quarteirao['numero_quarteirao']); ?></h2>

        <?php if (isset($_GET['ok'])): ?>
            <div class="message">✅ Depósito adicionado com sucesso!</div>
        <?php endif; ?>
        <?php if (isset($_GET['removed'])): ?>
            <div class="message">✅ Depósito removido com sucesso!</div>
        <?php endif; ?>
        <?php if (isset($_GET['erro'])): ?>
            <div class="message error">❌ <?php echo htmlspecialchars($_GET['erro']); ?></div>
        <?php endif; ?>

        <form method="post" action="?action=visita-add-deposito">
            <input type="hidden" name="id_imovel" value="<?php echo (int)$id_imovel; ?>">
            <input type="hidden" name="id_visita" value="<?php echo (int)$id_visita; ?>">

            <label for="cod">Código da Área</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_quarteirao['cod_area']); ?>" readonly>

            <label for="zona">Zona</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_quarteirao['cod_zona']); ?>" readonly>

            <label for="logradouro">Logradouro</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_imovel['nome_rua']); ?>" readonly>

            <label for="numero">Número</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_imovel['numero_imovel']); ?>" readonly>

            <label for="tipo">Tipo</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_imovel['tipo_imovel']); ?>" readonly>

            <label for="habitantes">Habitantes</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_imovel['qtd_habitantes']); ?>" readonly>

            <label for="caes">Cães</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_imovel['qtd_caes']); ?>" readonly>

            <label for="gatos">Gatos</label>
            <input type="text" value="<?php echo htmlspecialchars($dados_imovel['qtd_gatos']); ?>" readonly>

            <label for="tipo_deposito">Tipo de Depósito *</label>
            <select name="tipo_deposito" id="tipo_deposito">
                <option value="">Selecione...</option>
                <option value="A1">A1</option>
                <option value="A2">A2</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <label for="foco">Foco?</label>
            <select name="foco" id="foco">
                <option value="">Selecione...</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>

            <label for="tratado">Tratado?</label>
            <select name="tratado" id="tratado">
                <option value="">Selecione...</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>

            <label for="qtd_larvicida">Quantidade de Larvicida</label>
            <input type="number" name="qtd_larvicida" id="qtd_larvicida" min="0" step="0.5">

            <label for="amostra">Amostra</label>
            <input type="text" name="amostra" id="amostra">

            <button type="submit" class="btn btn-salvar">Adicionar Depósito</button>
            <button type="button" onclick="abrirDepositosLista()" class="btn btn-cancelar">Ver Depósitos</button>
        </form>

        <?php if (!empty($depositos)): ?>
            <div class="deposito-lista">
                <h4>Depósitos Registrados</h4>
                <?php foreach ($depositos as $dep): ?>
                    <div class="deposito-lista-item">
                        <span>
                            <strong><?php echo htmlspecialchars($dep['tipo']); ?></strong> - 
                            Foco: <?php echo $dep['foco'] ? 'Sim' : 'Não'; ?> | 
                            Tratado: <?php echo $dep['tratado'] ? 'Sim' : 'Não'; ?> | 
                            Larvicida: <?php echo $dep['qtd_larvicida'] ?? '-'; ?>
                        </span>
                        <a href="?action=visita-remove-deposito&id_deposito=<?php echo (int)$dep['id_deposito']; ?>&id_imovel=<?php echo (int)$id_imovel; ?>">Remover</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="?action=imovel-list&id_quarteirao=<?php echo $id_quarteirao; ?>" class="btn btn-cancelar">Cancelar</a>
        <a href="?action=visita-finish&id_visita=<?php echo $id_visita; ?>" class="btn btn-finalizar" style="margin-top: 10px;">Finalizar Visita</a>
    </div>

    <script>
        function abrirDepositosLista() {
            alert("Depósitos registrados para esta visita!");
        }
    </script>
</body>
</html>
