<?php
include "com.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Nombre'];
    $description = $_POST['Descrpition'];
    $price = floatval($_POST['Price']);

    $sql = "UPDATE producto SET Nombre = ?, Descrpition = ?, Price = ? WHERE id = ?";
    $stmt = $com->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
        if ($stmt->execute()) {
    header("Location: products_list.php");
    exit();
} else {
    echo "Error al actualizar el producto.";
        }
    }
}

if ($id > 0) {
    $sql = "SELECT * FROM producto WHERE id = $id";
    $result = $com->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

if (!$product) {
    echo "Producto no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar productos</h1>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="Nombre" value="<?php echo htmlspecialchars($product['Nombre']); ?>" required><br>

        <label>Descripción:</label>
        <input type="text" name="Descrpition" value="<?php echo htmlspecialchars($product['Descrpition']); ?>" required><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="Price" value="<?php echo htmlspecialchars($product['Price']); ?>" required><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <button onclick="history.back();">Regresar</button>

</body>
</html>
