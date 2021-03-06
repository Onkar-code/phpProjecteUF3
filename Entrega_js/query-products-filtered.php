<?php

    include('database/dbConnection_local.php');

    $categoria = $_POST['categoria'];
    $ordenarPrecio = $_POST['ordenarPrecio'];
    $ordenarFecha = $_POST['ordenarFecha'];
    $search = $_POST['search'];
    $precioMax = $_POST['precioMax'];
    $precioMin = $_POST['precioMin'];
    
    if(empty($precioMax)) {
        $precioMax = "9999.99";
    }
    if(empty($precioMin)) {
        $precioMin = "0";
    }

    $consultaPreparada=false;
    $numFiltros = 0;

    //Query basica
    $query = "SELECT p.*, c.latitud, c.longitud, p.idClient FROM producte p JOIN client c ON p.idClient = c.id";
   
    //Filtro categoria
    if ($categoria != "Todas"){
        $query .= " WHERE categoria='$categoria' ";
        $numFiltros++;
    }

    //Buscar por palabra(s)
    if (!empty($search)){
        
        //Si es el primer filtro aplicado
        if ($numFiltros == 0) {
            $query .= " WHERE ";
        }
        
        //Si hay más filtros anteriormente
        if ($numFiltros > 0) {
            $query .= " AND ";
        }
        $query .= " LOWER(p.nom) LIKE LOWER(?) OR LOWER(p.descripcio) LIKE LOWER(?) ";
        $numFiltros++;
        $consultaPreparada=true;
    }
    
    //Rango de precio
    //Si es el primer filtro aplicado
    if ($numFiltros == 0) {
        $query .= " WHERE ";
    }

    //Si hay más filtros anteriormente
    if ($numFiltros > 0) {
        $query .= " AND ";
    }
    $query .= " p.preu BETWEEN $precioMin AND $precioMax ";

    //Ordenar
    $query .= " ORDER BY p.preu $ordenarPrecio, p.data_publicacio $ordenarFecha ";
    
    $json = array();

    //Si hay filtro de campo de busqueda preparamos consulta
    if ($consultaPreparada){
        $statement=$db->prepare($query);
        $statement->execute(array("%".$_POST['search']."%", "%".$_POST['search']."%"));

        if ($statement->rowCount() == 0) {
            $json = array( 'resultado' => "No s'han trobat resultats");
        }else{
            while ($row=$statement->fetch(PDO::FETCH_ASSOC)) {
                    $json[] = array(
                    'nom' => $row['nom'],
                    'preu' => $row['preu'],
                    'categoria' => $row['categoria'],
                    'data_publicacio' => $row['data_publicacio'],
                    'foto' => $row['foto1'],
                    'id' => $row['id'],
                    'latitud' => $row['latitud'],
                    'longitud' => $row['longitud'],
                    'idClient' => $row['idClient']
                );
            }
        }
        $statement->closeCursor();

    //Si no hay filtro de campo de busqueda, no hace falta preparar la consulta
    } else {
        $result=$db->query($query);
        if ($result->rowCount() == 0) {
            $json = array( 'resultado' => "No s'han trobat resultats");
        }else{
            while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
                  $json[] = array(
                    'nom' => $row['nom'],
                    'preu' => $row['preu'],
                    'categoria' => $row['categoria'],
                    'data_publicacio' => $row['data_publicacio'],
                    'foto' => $row['foto1'],
                    'id' => $row['id'],
                    'latitud' => $row['latitud'],
                    'longitud' => $row['longitud'],
                    'idClient' => $row['idClient']
                );
            }
        }
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
    

?>