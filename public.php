
<!DOCTYPE html>
<html>
<head>
	<title>Public zone</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/styles.css">

</head>
<body>
    <!-- BARRA LOGIN/REGISTER -->
    <div class="barra-navegacio">
        <ul class="nav justify-content ">
            <li class="nav-item ">
                <a  href="login.php" class="nav-link active">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="register.php">Register</a>
            </li>
        </ul>
    </div>
   
    <!-- Botons para filtrar por categoria -->
    <form method="post" action="">
        <label>Categorias</label>
        <button type="submit" class="btn btn-primary" name="Libros" value="Libros">Libros</button>
        <button type="submit" class="btn btn-primary" name="Moviles" value="Moviles" >Moviles</button>
        <button type="submit" class="btn btn-primary" name="Videojuegos" value="Videojuegos">Videojuegos</button>
    </form><br>
    
</body>
</html>


<?php 
    require('database/dbConnection_local.php');
    
    //Crear Tabla
    function createTable($array) {
        //contenedor con imagen, propiedades e hipervínculo a la info de los Productos
        echo "<div class='producte-individual'><a href='producteInfo.php' > <div><img src='imagenes/imagenEjemplo.jpg' style='width:200px;height:100px;' ></div>";
        echo "<div><ul style='list-style-type:none;'> 
            <li>" . $array[0] . "</li></a>
            <li>" . $array[1] . "</li>
            <li>" . $array[2] . "</li>
            <li>" . $array[3] . "</li>
            </ul></div></div>";
    }

    function main($db){
        //Query zona publica por defecto
        $tableProducte= "producte";

        if (isset($_POST['Moviles'])){
            $sql = "SELECT * FROM $tableProducte WHERE categoria = 'Moviles'";
        }elseif(isset($_POST['Libros'])){
            $sql = "SELECT * FROM $tableProducte WHERE categoria = 'Libros'";
        }elseif(isset($_POST['Videojuegos'])){
            $sql = "SELECT * FROM $tableProducte WHERE categoria = 'Videojuegos'";
        }else{
            $sql = "SELECT * FROM $tableProducte";
        }

    
        
        $result=$db->query($sql);

        if(!$result) { 
            print"Error en la consulta.\n";
        } else{ 
            // $array = array();
            foreach($result as $valor) {
                // array_push($array, $valor["nom"],$valor["preu"],$valor["categoria"], $valor["data_publicacio"]);
                $array = [$valor["nom"],$valor["preu"],$valor["categoria"], $valor["data_publicacio"]];
                createTable($array);
                // $array = [];
            }
        }
    }

    echo "<div class=productes-table>";
    main($db);
    echo "</div>";

    //Estilos
    echo "<style>
    .productes-table{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-content: center;
        // height: 100px;
        // width: calc(100% * (1/4) - 10px - 1px);
    }
    
    .producte-individual {
        display: inline-block;
        margin: 10px 0 0 2%;
        flex-grow: 1;
        // height: 100px;
        width: calc(100% * (1/5) - 10px - 1px);
    }
    </style>"


    //mostrar una imagen y sus características DONE
    //query mostrar por categoria DONE
    //TODO
    //Insertar dropdown
    //rehacer el switch (donde filtraré la categoria)
    //recuperar los campos de busqueda para realizar la query completa (campos de nombre, precio min,max)
    //query mostrar por nombre o descripcion 
    //query mostrar por precio min, precio max o ambos
    
    //Ordenar por precio (ascendente)
    //Ordenar por fecha (ascendente)
    //mostrar fecha amigable (periodo desde que se publicó)

?>
