<?php
session_start();
include "com.php"; 

$sql = "SELECT id, Nombre, Descrpition, Price FROM producto";
$result = $com->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
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
        color: black;
    }

    h3 {
        font-size: 2em;
    }

    p {
        font-size: 1.5em;
    }

    .container {
        max-width: 1400px;
        margin: auto;
        padding: 40px;
    }

    .producto {
        border: 1px solid #503459;
        background-color: #dac9df;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .producto h2 {
        color: #black;
        font-size: 2.2em;
    }

    .producto .descripcion {
        font-size: 1.5em;
        color: #36233d;
    }

    .producto .precio {
        font-size: 1.5em;
        color: #36233d;
    }

    .back-button {
        background-color: #81638b;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 1.2em;
        cursor: pointer;
    }

    .back-button:hover {
        background-color: #503459;
    }

    .add-to-cart-button {
        background-color: #503459;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 1.2em;
        cursor: pointer;
        
    }

    .add-to-cart-button:hover {
        background-color: #a069c2;
    }



    @media (min-width: 800px){

        .add-to-cart-button {
        background-color: #503459;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 1.2em;
        cursor: pointer;
       display: block;
       width: 200px;
        margin: 0 auto;
        margin-top:15px;
    }

    .producto h2 {
        color: #black;
        font-size: 2.2em;
        display: block;
       width: 200px;
        margin: 0 auto;
        margin-top:15px;
    }

    .producto .descripcion {
        font-size: 1.5em;
        color: #36233d;
        display: block;
       width: 200px;
        margin: 0 auto;
        margin-top:15px;
    }

    .producto .precio {
        font-size: 1.5em;
        color: #36233d;
        display: block;
       width: 200px;
        margin: 0 auto;
        margin-top:15px;
    }


    }


    </style>
</head>
<body>
    <div class="container">
        <!-- Botón para redirigir a Index.html -->
        <button class="back-button" onclick="window.location.href='Index.html'">Regresar</button> 
        <h1>Lista de Productos</h1>
        <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = htmlspecialchars($row["id"]);
        echo "<div class='producto'>";
        echo "<h2>" . htmlspecialchars($row["Nombre"]) . "</h2>";
        echo "<p class='descripcion'>Descripción: " . htmlspecialchars($row["Descrpition"]) . "</p>";
        echo "<p class='precio'>Precio: $" . number_format($row["Price"], 2) . "</p>";
        echo "<form method='post' action='cart.php'>";
        echo "<input type='hidden' name='product_id' value='$product_id'>";
        echo "<button class='add-to-cart-button' type='submit'>Agregar al Carrito</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No hay productos registrados.</p>";
}
        $com->close();
        ?>
    </div>
</body>
</html>
