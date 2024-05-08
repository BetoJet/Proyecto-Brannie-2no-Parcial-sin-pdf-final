<?php

    $server = "localhost";
    
    $user = "root";

    $data = "brannie";

    $pass = "";

    $com = mysqli_connect($server, $user,$pass, $data );
    if (!$com){
                die("Fallo en la conexion".mysqli_error());

    }
  echo"";
    
    ?>