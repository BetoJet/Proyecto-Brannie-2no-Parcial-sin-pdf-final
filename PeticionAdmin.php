<?php
include "com.php";

$nombre = $_POST["nombre"];
$Descripcion = $_POST["Descripcion"];
$Precio = $_POST["Precio"];

$sql = "INSERT INTO producto(Nombre, Descrpition, Price)
VALUES ('$nombre', '$Descripcion', '$Precio')";

if ($com->query($sql) === TRUE) {
  echo "Registro exitoso";
  header("Location: ProductoAdmin.html");
} else {
  echo "Error: " . $sql . "<br>" . $com->error;
}

$com->close();

?>

