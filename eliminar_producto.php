<?php
include "com.php"; 

if (isset($_POST["id"])) { 
    $id = $_POST["id"]; 

$sql = "DELETE FROM producto WHERE id = '$id'";
    if ($com->query($sql) === TRUE) {
        echo "Producto eliminado exitosamente.";
        header("Location: mostrar_productos.php"); 
    } else {
        echo "Error al eliminar el producto: " . $com->error;
    }
} else {
    echo "No se proporcionó el ID del producto.";
}
$com->close();
?>
