<?php
    require_once('database/dbConnection_local.php');

    //Recuperamos productos del usuario
    $sql = "SELECT * FROM producte WHERE idClient = $userId";
    $result=$db->query($sql);
    
    $json[] = array();

    if (!$resul->rowCount())  {
        echo "<br><h1>No has publicado ningún producto todavía.</h1><br>";
    }else{
        while($row=$result->fetch(PDO::FETCH_ASSOC)){
        
            $json[] = array(
                'nom' => $row['nom'],
                'preu' => $row['preu'],
                'categoria' => $row['categoria'],
                'data_publicacio' => $row['data_publicacio'],
            );
        }
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
?>