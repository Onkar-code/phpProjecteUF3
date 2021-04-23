<?php

    include('database/dbConnection_local.php');
    
    //declarar la id
    $id = $_POST['id'];

    //Query basica
    $query = "SELECT * FROM producte WHERE id=$id";
   
    $json = array();
    $result=$db->query($query);

    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        $json[] = array(
          'nom' => $row['nom'],
          'preu' => $row['preu'],
          'categoria' => $row['categoria'],
          'data_publicacio' => $row['data_publicacio'],
          'foto1' => $row['foto1'],
          'foto2' => $row['foto2'],
          'foto3' => $row['foto3'],
          'descripcio' => $row['descripcio']
      );
  }

    $jsonstring = json_encode($json);
    echo $jsonstring;
?>