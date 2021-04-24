<?php

    include('database/dbConnection_local.php');

    $query = "SELECT * FROM producte";
    $result=$db->query($query);

    if (!$result)  {
        die('Query Error ' . mysqli_error($db));
    }

    //AHORA VAMOS A RETORNAR LA INFO EN JSON
    $json = array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        
        $json[] = array(
            'nom' => $row['nom'],
            'preu' => $row['preu'],
            'categoria' => $row['categoria'],
            'data_publicacio' => $row['data_publicacio'],
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;

?>