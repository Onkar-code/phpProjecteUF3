<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="app/app.js"></script>
<form method="post" action="public.php">
    <div class="principal">
        <div class="filtros">
            <h3> Filtros </h3>
            Categoria: <select name="categoria">
                <option value="Todas"> Todas las categorias </option>
                <option value="Libros">Libros</option>
                <option value="Moviles">Moviles</option>
                <option value="Videojuegos">Videojuegos</option>
            </select><br><br>
            ¿Qué buscas? <input type="text" name="search" placeholder="Buscar por texto"  value="<?php echo isset($_POST['search']) ? ($_POST['search']) : ''; ?>"/><br><br>

            Rango de precio en €:
            <input type="text" id="amount" name="RangoPrecio" readonly style="color:#000000; font-weight:bold;"><br><br>
            <div id="slider-range" style="width: 300px;"></div>
        </div>
    
        <div class="ordenar">
            <h3> Ordenación </h3>

            Precio: <select name="ordenarPrecio">
                <option value="ASC">ASC</option>
                <option value="DESC">DESC</option>
            </select><br><br>

            Fecha: <select name="ordenarFecha">
                <option value="ASC">ASC</option>
                <option value="DESC">DESC</option>
            </select><br><br>
        </div>
    </div>
    <br><br>
    Realizar consulta: <input type="submit" name="filtros" value="Enviar" /><br><br>
    Sin filtros: <input type="submit" name="sinfiltros" value="Enviar" />
    
</form>

<div class=productes-table></div>

<?php
    require('database/dbConnection_local.php');
       
    if(!isset($_POST['filtros']) || isset($_POST['sinFiltros']) ){

     
        $sql = "SELECT * FROM producte";
        $result=$db->query($sql);

        if(!$result) { 
            print"Error en la consulta.\n";
        } else{ 
            foreach($result as $valor) {
                $array = [$valor["nom"],$valor["preu"],$valor["categoria"], $valor["data_publicacio"],$valor["id"]];
                createTable($array);
            }
        }
        
    }else{
        if(isset($_POST['categoria']) || isset($_POST['ordenarPrecio']) || isset($_POST['ordenarFecha']) || isset($_POST['search']) || isset($_POST['RangoPrecio'])){

            $consultaPreparad = false;
            $sql = "SELECT * FROM producte";
            $numFiltros = 0;
            
            if ($_POST['categoria'] != "Todas"){
                
                $categoria=$_POST['categoria'];
                
                $sql .= " WHERE categoria='$categoria' ";

                $numFiltros++;
            }

            //Buscar por palabra(s)
            if ($_POST['search'] != ""){
               
                if ($numFiltros == 0) {
                    $sql .= " WHERE ";
                }
                if ($numFiltros > 0) {
                    $sql .= " AND ";
                }
                $sql .= " LOWER(nom) LIKE LOWER(?) OR LOWER(descripcio) LIKE LOWER(?) ";
                $numFiltros++;
                $consultaPreparad=true;
            }
            
            //Rando de precio
            if (isset($_POST['RangoPrecio'])) {

                $amounts = explode(" - ", $_POST['RangoPrecio']);
                $precioMin = $amounts[0];
                $precioMax = $amounts[1];

                if ($numFiltros == 0) {
                    $sql .= " WHERE ";
                }
                if ($numFiltros > 0) {
                    $sql .= " AND ";
                }
                $sql .= " preu BETWEEN $precioMin AND $precioMax ";
                $numFiltros++;
            }
            //Ordenar
            $precioORD = $_POST['ordenarPrecio'];
            $fechaORD = $_POST['ordenarFecha'];
            $sql .= " ORDER BY preu $precioORD, data_publicacio $fechaORD ";

            if ($consultaPreparad){
                $statement=$db->prepare($sql);
		        $statement->execute(array("%".$_POST['search']."%", "%".$_POST['search']."%"));
                if ( $statement->rowCount() == 0) {
                    echo "<h1>No s'han trobat resultats</h1>";
                }else{
                    while ( $result=$statement->fetch(PDO::FETCH_ASSOC)) {
                        $array = [$result["nom"],$result["preu"],$result["categoria"], $result["data_publicacio"],$result["id"]];
                        createTable($array);
                    }
                }
                
            }else{
                $result=$db->query($sql);
                if(!$result) { 
                    print"Error en la consulta.\n";
                } else{ 

                    if ( $result->rowCount() == 0) {
                        echo "<h1>No s'han trobat resultats</h1>";
                    }else{
                        foreach($result as $valor) {
                            $array = [$valor["nom"],$valor["preu"],$valor["categoria"], $valor["data_publicacio"],$valor["id"]];
                            createTable($array);
                        }
                    }    
                }
            }
        }
    }
    
    function createTable($array) {
        //contenedor con imagen, propiedades e hipervínculo a la info de los Productos

        echo "<div class='producte-individual'><form method='POST' action='producteInfo.php'> 
        <img src='imagenes/". $array[4] . "_1.jpg' style='width:200px;height:300px;>    
        </form>";
        echo "<div><ul style='list-style-type:none;'> 
            <li>" . $array[0] . "</li>
            <li>" . $array[1] . "</li>
            <li>" . $array[2] . "</li>
            <li>" . $array[3] . "</li>
            <li>  <button class='button' name='id' value=" . $array[4] . ">Detalles</button></li>

            </ul></div></div>";
    }

    //Estilos
    echo "<style>
    body{
        max-width: 1200px;
        margin: auto;
    }

    .principal{
        display:flex;
    }

    .filtros{
        margin-right: 100px;
    }

    
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
        padding-bottom: 15px;
        width: calc(100% * (1/5) - 10px - 1px);
    }

    img {
        padding-bottom: 15px;
    }
    li{
        list-style-type: none;
    }
    .button:hover{
        //background-color: blue;
    </style>"

    //TODO

    //mostrar fecha amigable (periodo desde que se publicó)
    //echo de los filtros aplicados porque por defecto se reinician
?>

