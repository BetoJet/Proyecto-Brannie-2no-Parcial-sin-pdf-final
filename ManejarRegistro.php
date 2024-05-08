<?php
include "com.php";

session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    $stored_user = "admin@admin.com"; 
    $stored_pass = "123";


    
if ($username === $stored_user && $password === $stored_pass) {
       
    $_SESSION['username'] = $username; 

    header('Location: ProductoAdmin.html'); 
    exit(); 
} else {
   
    echo "Usuario o contraseña incorrectos. Intenta de nuevo."; 
}
    if ($username === $_POST['username'] && $password === $_POST['password']) {
       
        $_SESSION['username'] = $username; 
    
        header('Location: index.html'); 
        exit(); 
    } else {
        echo "Usuario o contraseña incorrectos. Intenta de nuevo."; 
    }
} else {
    
    header('Location: index.html'); 
    exit();
}

?>