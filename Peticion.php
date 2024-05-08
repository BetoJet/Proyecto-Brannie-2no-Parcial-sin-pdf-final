<?php
include "com.php";


$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "INSERT INTO usuario (Nombre, Apellidos, Correo, Contrasena)
VALUES ('$nombre', '$apellidos', '$username','$password')";

if ($com->query($sql) === TRUE) {
  echo " Registro exitoso";
  header("Location: Formulario.html");
} else {
  echo "Error: " . $sql . "<br>" . $com->error;
}

?>

