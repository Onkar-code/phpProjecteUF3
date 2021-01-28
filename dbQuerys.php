<?php
    require('dbConnection_local.php');
    
    //TODO implementar con $_POST[""];
    $categoria = 'Libros';
    $nombre = 'Celio';

    //TODO
    //Filtar por categoria
    //Filtar por nom
    //Filtar por precio (limitar máx, min)
    //Ordenar por precio (ascendente)
    //Ordenar por fecha (ascendente)

    //Consulta para ver el funcionamiento (consulta preparada)
    $sql="SELECT * FROM Client where nom=?";
    $statement=$db->prepare($sql);

    $statement->execute(array($nombre)); 
    while($fila=$statement->fetch(PDO::FETCH_ASSOC)){
        echo "Apellidos: {$fila['cognom1']} {$fila['cognom2'] } <br/>";
        echo "email: {$fila["email"]}";
    }
    $statement->closeCursor();

?>