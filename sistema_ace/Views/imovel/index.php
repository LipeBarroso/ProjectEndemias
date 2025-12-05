<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóveis Cadastrados</title>
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
            padding: 40px 0;
        }
        .container {
            background: #fff;
            width: 95%;
            max-width: 950px;
            padding: 22px;
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
            color: #006666;
            font-size: 20px;
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
            padding: 10px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
            background: #009688;
            color: white;
        }
        .btn:hover {
            background: #00796b;
        }
        .btn-trabalhar {
            background: #009688;
            color: white;
        }
        .btn-trabalhar:hover {
            background: #00796b;
        }
        .btn-voltar {
            margin-top: 20px;
            background: #1976d2;
            color: white;
            width: 100%;
            padding: 12px;
        }
        .btn-voltar:hover {
            background: #1565c0;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="?action=dashboard">Home</a> &gt; <a href="?action=area-index">Áreas</a> &gt; <a href="?action=quarteirao-list&cod_area=<?php echo urlencode($_GET['cod_area'] ?? ''); ?>">Quarteirões</a> &gt; <span style="color:#333; font-weight:600;">Imóveis</span>
        </div>
        <h2>Imóveis Cadastrados</h2>

        <?php if (isset($_GET['ok'])): ?>
            <div class="message">✅ Imóvel cadastrado com sucesso!</div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>N° Quarteirão</th>
                    <th>Nome da Rua</th>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Habitantes</th>
                    <th>Cães</th>
                    <th>Gatos</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($imoveis)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Nenhum imóvel cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($imoveis as $i): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($numero_quarteirao); ?></td>
                            <td><?php echo htmlspecialchars($i['nome_rua']); ?></td>
                            <td><?php echo htmlspecialchars($i['numero_imovel']); ?></td>
                            <td><?php echo htmlspecialchars($i['tipo_imovel']); ?></td>
                            <td><?php echo htmlspecialchars($i['qtd_habitantes']); ?></td>
                            <td><?php echo htmlspecialchars($i['qtd_caes']); ?></td>
                            <td><?php echo htmlspecialchars($i['qtd_gatos']); ?></td>
                            <td>
                                <a href="?action=visita-show&id_imovel=<?php echo (int)$i['id_imovel']; ?>" class="btn btn-trabalhar">Trabalhar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="?action=imovel-create&id_quarteirao=<?php echo $id_quarteirao ?>" class="btn" style="margin-top: 15px;">Cadastrar Imóvel</a>
        <button class="btn-voltar" onclick="window.location.href='?action=quarteirao-list&cod_area=<?php echo urlencode($_GET['cod_area'] ?? ''); ?>'">Voltar</button>
    </div>
</body>
</html>
