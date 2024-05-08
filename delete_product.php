<?php
include "com.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $sql = "DELETE FROM producto WHERE id = $id";
    if ($com->query($sql)) {
header("Location: products_list.php");
exit();
}
 else {
        echo "Error al eliminar el producto.";
    }
}
 else {
    echo "ID de producto no válido.";
}
$com->close();
?>
