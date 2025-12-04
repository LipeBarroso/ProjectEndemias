<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas</title>
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
        .back-btn {
            background: #1976d2;
            color: white;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }
        .back-btn:hover {
            background: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="?action=dashboard" class="back-btn">← Voltar</a>
        <h2>Áreas Cadastradas</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Zona</th>
                    <th>Quarteirões</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($areas)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Nenhuma área cadastrada.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($areas as $area): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($area['cod_area']); ?></td>
                            <td><?php echo htmlspecialchars($area['nome_area']); ?></td>
                            <td><?php echo htmlspecialchars($area['cod_zona']); ?></td>
                            <td><?php echo htmlspecialchars($area['qtd_quarteiroes']); ?></td>
                            <td>
                                <a href="?action=quarteirao-list&cod_area=<?php echo urlencode($area['cod_area']); ?>" class="btn">Ver Quarteirões</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
