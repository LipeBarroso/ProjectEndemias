<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Imóvel</title>
    <link rel="stylesheet" href="/sistema_ace/style.css">
    <style>
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
        }
        h2 {
            text-align: center;
            color: #006666;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastrar Imóvel</h2>

        <?php if (!empty($erro)): ?>
            <div class="message error">❌ <?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <form method="POST" action="?action=imovel-store&id_quarteirao=<?php echo $id_quarteirao ?>">

            <label for="id_quarteirao">Quarteirão</label>
            <input type="text" readonly id="id_quarteirao"
                value="<?php echo htmlspecialchars($quarteirao['nome_area'] . ' - ' . $quarteirao['numero_quarteirao']); ?>">

            <label for="nome_rua">Nome da Rua *</label>
            <input type="text" name="nome_rua" id="nome_rua" required>

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

        <a href="?action=imovel-list&id_quarteirao=<?php echo $id_quarteirao ?>" class="btn btn-voltar">Cancelar</a>
    </div>
</body>
</html>
