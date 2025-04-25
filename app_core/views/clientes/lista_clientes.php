<?php
require_once(__CLS_PATH . "cls_html.php");
$html = new cls_Html();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
    <style>
        body {
            font-family: sans-serif;
            background-color: #fffef3;
            padding: 2rem;
        }

        h2 {
            color: #710000;
        }

        .acciones-reporte {
            margin: 1rem 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            border: 1px solid #eeba0b;
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #c36f09;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fff9e3;
        }

        .btn {
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            border: none;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            background-color: #a63c06;
        }

        .btn-delete {
            background-color: #710000;
        }

        .btn-new {
            background-color: #eeba0b;
            color: #000;
        }

        .btn-pdf {
            background-color: #c36f09;
        }

        .btn-excel {
            background-color: #f4e409;
            color: #000;
        }

        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>

    <h2>Listado de Clientes</h2>

    <div class="acciones-reporte">
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=pdf" class="btn btn-pdf">📄 Generar PDF</a>
        <a href="<?= __CTR_HOST_PATH ?>ctrl_reportes.php?tipo=clientes&formato=excel" class="btn btn-excel">📊 Generar Excel</a>
        <a href="form_cliente.php" class="btn btn-new">+ Nuevo Cliente</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $cliente): ?>
                    <tr>
                        <td><?= $cliente['id']; ?></td>
                        <td><?= $cliente['nombre_completo']; ?></td>
                        <td><?= $cliente['telefono']; ?></td>
                        <td><?= $cliente['direccion']; ?></td>
                        <td><?= $cliente['correo']; ?></td>
                        <td>
                            <a href="form_cliente.php?id=<?= $cliente['id']; ?>" class="btn btn-edit">Editar</a>
                            <a href="<?= __CTR_HOST_PATH ?>ctrl_clientes.php?accion=eliminar&id=<?= $cliente['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Desea eliminar este cliente?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay clientes registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
