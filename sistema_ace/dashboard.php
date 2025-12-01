<?php



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Tela Inicial</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* === Centralização geral === */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #ffffff;
            margin: 0;
        }

        .container {
            background: #fff;
            width: 95%;
            max-width: 900px;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0px 12px 35px rgba(0, 0, 0, 0.25);
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

        th,
        td {
            border-bottom: 1px solid #ddd;
            text-align: left;
            padding: 10px;
            font-size: 14px;
            vertical-align: middle;
        }

        th {
            color: #006666;
            font-weight: bold;
            background: #f2f2f2;
        }

        tr:hover {
            background: #f9f9f9;
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
            margin-top: 10px;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-trabalhar {
            background: #009688;
            color: white;
        }

        .btn-trabalhar:hover {
            background: #00796b;
        }

        .btn-voltar {
            background: #1976d2;
            color: white;
        }

        .btn-voltar:hover {
            background: #1565c0;
        }

        .back-btn {
            background: #1976d2;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-bottom: 15px;
        }

        .back-btn:hover {
            background: #1565c0;
            transform: translateY(-2px);
        }

        @media (max-width: 700px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            th,
            td {
                font-size: 13px;
                padding: 8px;
            }
        }
    </style>
</head>

<div class="container">
    <h2>Funcionalidades</h2>

    <a href="area.php" class="btn btn-trabalhar">Áreas</a>

    <a href="boletim_diario.php" class="btn btn-trabalhar">Boletim diário</a>


</div>


</body>

</html>