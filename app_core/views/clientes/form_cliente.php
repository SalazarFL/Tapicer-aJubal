<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/tapiceria-jubal/global.php");
require_once(__CLS_PATH . "cls_html.php");
require_once(__CLS_PATH . "cls_cliente.php");

$html = new cls_Html();
$cliente = new cls_Cliente();

// Inicializar variables
$id = intval($_GET['id'] ?? 0);
$modo = ($id > 0) ? "Editar" : "Nuevo";

$datos = [
    'nombre_completo' => '',
    'telefono'        => '',
    'direccion'       => '',
    'correo'          => ''
];

// Si viene un ID, buscamos los datos
if ($id > 0) {
    $datosCliente = $cliente->obtenerClientePorId($id);
    if ($datosCliente) {
        $datos = $datosCliente;
    } else {
        // Si no existe el cliente, redirigir a la lista
        header("Location: " . __CTR_HOST_PATH . "ctrl_clientes.php?accion=listar");
        exit;
    }
}

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $nombre = $_POST['nombre'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $correo = $_POST['correo'] ?? '';

    if ($accion === 'insertar') {
        $exito = $cliente->insertarCliente($nombre, $telefono, $direccion, $correo);
    } elseif ($accion === 'actualizar') {
        $id = intval($_POST['id']);
        $exito = $cliente->actualizarCliente($id, $nombre, $telefono, $direccion, $correo);
    }

    if (isset($exito) && $exito) {
        // Redirigir a la lista de clientes con mensaje de éxito
        header("Location: " . __CTR_HOST_PATH . "ctrl_clientes.php?accion=listar&mensaje=success");
        exit;
    } else {
        $error = "No se pudo guardar la información.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $modo ?> Cliente</title>
    <?= $html->html_css_header(__CSS_PATH . "style.css", "all"); ?>
</head>
<body>

<h2><?= $modo ?> Cliente</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="" method="post" class="form-filtro">
    <?php if ($id > 0): ?>
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php else: ?>
        <input type="hidden" name="accion" value="insertar">
    <?php endif; ?>

    <label for="nombre">Nombre Completo:</label>
    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($datos['nombre_completo']) ?>" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>" required>

    <label for="direccion">Dirección:</label>
    <textarea name="direccion" id="direccion" rows="3" required><?= htmlspecialchars($datos['direccion']) ?></textarea>

    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($datos['correo']) ?>" required>

    <button type="submit" class="btn btn-new"><?= ($modo === "Editar") ? "💾 Actualizar Cliente" : "➕ Guardar Cliente" ?></button>
    <a href="<?= __CTR_HOST_PATH ?>ctrl_clientes.php?accion=listar" class="btn btn-delete">↩️ Cancelar</a>
</form>

</body>
</html>
