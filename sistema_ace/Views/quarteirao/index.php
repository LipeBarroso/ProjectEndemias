<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quarteirões</title>
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
            max-width: 900px;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            color: #006666;
            font-size: 20px;
            margin-bottom: 20px;
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
        .btn-voltar {
            background: #1976d2;
            color: white;
            padding: 12px;
            margin-top: 20px;
            width: 100%;
        }
        .btn-voltar:hover {
            background: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="?action=dashboard">Home</a> &gt; <a href="?action=area-index">Áreas</a> &gt; <span style="color:#333; font-weight:600;">Quarteirões</span>
        </div>
        <h2>Quarteirões da Área</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Imóveis</th>
                    <th>Habitantes</th>
                    <th>Cães</th>
                    <th>Gatos</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($quarteiroes)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Nenhum quarteirão cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($quarteiroes as $quarteirao): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($quarteirao['numero_quarteirao']); ?></td>
                            <td><?php echo htmlspecialchars($quarteirao['qtd_imoveis']); ?></td>
                            <td><?php echo htmlspecialchars($quarteirao['qtd_habitantes']); ?></td>
                            <td><?php echo htmlspecialchars($quarteirao['qtd_caes']); ?></td>
                            <td><?php echo htmlspecialchars($quarteirao['qtd_gatos']); ?></td>
                            <td>
                                <a href="?action=imovel-list&id_quarteirao=<?php echo (int)$quarteirao['id_quarteirao']; ?>&cod_area=<?php echo urlencode($cod_area); ?>" class="btn">Ver Imóveis</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <button class="btn-voltar" onclick="window.location.href='?action=area-index'">Voltar</button>
    </div>
</body>
</html>
