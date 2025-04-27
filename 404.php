<?php
require_once("/xampp/htdocs/tapiceria-jubal/global.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error 404 - Página no encontrada</title>
    <link rel="stylesheet" href="<?= __CSS_PATH ?>style.css">
    <style>
        body {
            text-align: center;
            padding: 50px;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        h1 {
            font-size: 80px;
            color: #a63c06;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #a63c06;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #710000;
        }
    </style>
</head>
<body>

<h1>404</h1>
<h2>¡Página no encontrada!</h2>
<p>Lo sentimos, la página que buscas no existe o ha sido movida.</p>

<a href="<?= __VWS_HOST_PATH ?>dashboard.php">Volver al Inicio 🏠</a>

</body>
</html>
