<?php
session_start();
include "com.php"; // Conexión a la base de datos

// Añadir o modificar productos en el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);

        if (isset($_SESSION['cart'][$product_id])) {
            if (isset($_POST['action']) && $_POST['action'] === 'decrease') {
                // Disminuir la cantidad
                $_SESSION['cart'][$product_id] -= 1;
                // Eliminar si la cantidad es menor o igual a cero
                if ($_SESSION['cart'][$product_id] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
            } else {
                // Incrementar la cantidad
                $_SESSION['cart'][$product_id] += 1;
            }
        } else {
            // Si el producto no está en el carrito, agregarlo con cantidad 1
            $_SESSION['cart'][$product_id] = 1;
        }
    }
}

// Eliminar un producto del carrito
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$remove_id]);
}

// Obtener información del producto por ID
function obtenerDetallesProducto($product_id, $com) {
    $sql = "SELECT Nombre, Price FROM producto WHERE id = ?";
    $stmt = $com->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <style>
    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
        margin-left: 16px;
    }

    body {
        margin: 0;
        font-family: 'Roboto', sans-serif;
    }

    h1 {
        font-size: 3.2em;
    }

    h2 {
        font-size: 2.3em;
        color: negro;
    }

    .container {
        max-width: 1400px;
        margin: auto;
        padding: 20px;
    }

    .cart-item {
        border: 1px sólido #503459;
        background-color: #dac9df;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-item .descripcion {
        font-size: 1.5em;
    }

    .remove-button {
        background-color: #e74c3c;
        color: blanco;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        cursor: pointer;
    }

    .total {
        font-size: 1.8em;
       
        color: #36233d;
    }

    .increase-button {
        background-color: #503459;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        cursor: pointer;
        
    }

    .decrease-button {
        background-color: #503459;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        cursor: pointer;
    }

    .back-button{
        background-color: #e67e22;
        color: #503459;
        font-weight: bold;
        border: none;
        padding: 15px 20px;
        border-radius: 10px;
        cursor: pointer;
        margin-left: 30px;
        justify-content: flex-end;
        display: block;
       width: 200px;
        margin: 0 auto;
        margin-top:15px;
        background: #dac9df; /* color de fondo */
  
  border: 2px  ; /* tamaño y color de borde */
 
  border-radius: 10px; /* redondear bordes */
  position: relative;
  z-index: 1;
  overflow: hidden;
  
    }
    .back-button:hover {
  color: #fff;/* color de fuente hover */
}
.back-button::after {
  content: "";
  background: #503459; /* color de fondo hover */
  position: absolute;
  z-index: -1;
  padding: 16px 20px;
  display: block;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  transform: scale(0, 0);
  transition: all 0.3s ease;
}
.back-button:hover::after {
  transition: all 0.3s ease-out;
  transform: scale(1, 1);
}

    .buy-button{
        background-color: #dac9df;
        font-size:15px;
        font-weight:bold;
        color: #503459;
        padding: 15px 53px;
        cursor: pointer;
        margin:30px;
        display: block;
       width: 200px;
        margin: 0 auto;
        margin-top:15px;
        border: 2px ; /* tamaño y color de borde */
        border-radius: 10px; /* redondear bordes */
        position: relative;
        z-index: 1;
        overflow: hidden;
    }
    .buy-button:hover{
    color: #fff; /* color de fuente hover */
}
   
    .buy-button::after {
  content: "";
  background: #503459; /* color de fondo hover */
  position: absolute;
  z-index: -1;
  padding: 16px 20px;
  display: block;
  top: 0;
  bottom: 0;
  left: 100%;
  right: -100%;
  -webkit-transition: all 0.35s;
  transition: all 0.35s;
  
}
.buy-button:hover::after {
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  -webkit-transition: all 0.35s;
  transition: all 0.35s;
 
}




    </style>
</head>
<body>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <?php
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $cantidad) {
                $producto = obtenerDetallesProducto($product_id, $com);
                if ($producto) {
                    $nombre_producto = htmlspecialchars($producto["Nombre"]);
                    $precio_producto = number_format($producto["Price"], 2);
                    $subtotal = $producto["Price"] * $cantidad;
                    $total += $subtotal;

                    echo "<div class='cart-item'>";
                    echo "<div>";
                    echo "<h2>" . htmlspecialchars($nombre_producto) . "</h2>";
                    echo "<p class='descripcion'>Cantidad: " . htmlspecialchars($cantidad) . "</p>";
                    echo "<p class='precio'>Subtotal: $" . number_format($subtotal, 2) . "</p>";
                    echo "</div>";

                    // Botón para aumentar la cantidad
                    echo "<form method='post' action='cart.php' style='display: inline;'>";
                    echo "<input type='hidden' name='product_id' value='" . intval($product_id) . "'>";
                    echo "<input type='hidden' name='action' value='increase'>";
                    echo "<button type='submit' class='increase-button'>Aumentar Cantidad</button>";
                    echo "</form>";

                    // Botón para disminuir la cantidad
                    echo "<form method='post' action='cart.php' style='display: inline;'>";
                    echo "<input type='hidden' name='product_id' value='" . intval($product_id) . "'>";
                    echo "<input type='hidden' name='action' value='decrease'>";
                    echo "<button type='submit' class='decrease-button'>Disminuir Cantidad</button>";
                    echo "</form>";

                    // Botón para eliminar el producto
                    echo "<a class='remove-button' href='cart.php?remove=" . intval($product_id) . "'>Eliminar</a>";
                    echo "</div>";
                } else {
                    echo "<div class='cart-item'>";
                    echo "<p>Producto desconocido</p>";
                    echo "</div>";
                }
            }

            echo "<p class='total'>Total: $" . number_format($total, 2) . "</p>";

            // Formulario para realizar la compra
            echo "<form method='post' action='checkout.php'>";
            echo "<button type='submit' class='buy-button' id= 'buy-button'>Realizar Compra</button>";
            echo "</form>";

            

        } else {
            echo "<p>No hay productos en el carrito.</p>";
        }
        ?>

        <!-- Botón para ir a ProductoUsuarios.php -->
        <a href="ProductoUsuarios.php" class="back-button">Ir a ProductoUsuarios</a>
    </div>
</body>
</html>
