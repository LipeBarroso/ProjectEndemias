<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema ACE - Endemias</title>
    <link rel="stylesheet" href="/sistema_ace/style.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: #fff;
            width: 95%;
            max-width: 600px;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0px 15px 45px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            color: #006666;
            margin: 0 0 30px 0;
            font-size: 28px;
        }

        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #009688;
        }

        .stat-box h3 {
            margin: 0;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }

        .stat-box .number {
            font-size: 32px;
            color: #006666;
            font-weight: bold;
            margin: 10px 0 0 0;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            text-decoration: none;
            background: #009688;
            color: white;
        }

        .btn:hover {
            background: #00796b;
            transform: translateY(-2px);
        }

        @media (max-width: 500px) {
            .container {
                padding: 30px 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🏥 Sistema ACE</h1>
        <h2>Monitoramento de Endemias</h2>

        <div class="stats">
            <div class="stat-box">
                <h3>Áreas</h3>
                <div class="number"><?php echo $total_areas; ?></div>
            </div>
            <div class="stat-box">
                <h3>Imóveis</h3>
                <div class="number"><?php echo $total_imoveis; ?></div>
            </div>
            <div class="stat-box">
                <h3>Visitas</h3>
                <div class="number"><?php echo $total_visitas; ?></div>
            </div>
        </div>

        <a href="../../public/index.php?action=area-index" class="btn">Iniciar</a>
    </div>
</body>

</html>