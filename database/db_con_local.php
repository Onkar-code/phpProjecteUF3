<?php
    
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'testdb';

    //iniciamos conexión
    $con = new mysqli($db_host, $db_user, $db_password, $db_name);

    //verificar conexión
    if ( mysqli_connect_errno() ) {
        printf("Error: No se pudo conectar a MySQL: %s\n", $mysqli_connect_error());
        echo "Error";
        exit();
    }else{
        $sql = "Select * from Client";
        $result = mysqli_query($con, $sql);

        if ( mysqli_num_rows($result)>0) {
            while($fila = $result->fetch_array()) { 
                echo  $fila["id"] . " " . $fila["nom"] . " " . $fila["cognom1"] ."<br/>";
            }
        }
    }
    //cerramos conexión
    mysqli_close($con);
?>