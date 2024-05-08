<?php
session_start(); 


if (isset($_SESSION['username'])) {
    echo "Sesión iniciada: " . htmlspecialchars($_SESSION['username']);
} else {
    echo "No hay sesión iniciada.";
}
?>