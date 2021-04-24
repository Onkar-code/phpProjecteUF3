<?php
        require_once('database/dbConnection_local.php');

        //Recuperamos productos del usuario
        $sql = "SELECT DISTINCT categoria from producte";
        $result=$db->query($sql);
        
        $json[] = array();

        while($row=$result->fetch(PDO::FETCH_ASSOC)){
            
            $json[] = array(
                'categoriaNom' => $row['categoria'],
            );
        }
        
        $jsonstring = json_encode($json);
        echo $jsonstring;
    
?>