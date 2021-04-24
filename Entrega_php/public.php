<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="app/app.js"></script>
    <style>
        body {
            max-width: 1200px;
            margin: auto;
        }

        .loginRegister {   
            display:flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .principal {
            display:flex;
        }

        .filtros {
            margin-right: 100px;
        }
        
        .productes-table {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-content: center;
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
        li {
            list-style-type: none;
        }
    </style>
</head>
<body>

    <?php
        session_start();

        //Si hay sesión iniciada, mostramos opciones de volver a la zona privada o cerrar sesión
        if (isset($_SESSION['userId'])) {
            echo "<a href='private.php'>Volver a la zona privada</a><br><br>
                <form method='POST' action='private.php'>
                    <input type='submit' name='logout' value='Cerrar sesión'></button>
                </form><br>";

        //Si no hay sesión iniciada, mostramos opciones de hacer login o registrarse
        } else {
            echo "<div class='loginRegister'>
                    <form action='login.php'>
                        <input type='submit' value='Login'></button>
                    </form>
                    <form action='register.php'>
                        <input type='submit' value='Register'></button>
                    </form>
                </div>";
        }
    ?>

    <!--Formulario para filtrar y ordenar productos-->
    <form method="post" action="public.php">
        <div class="principal">
            <div class="filtros">
                <h3> Filtros </h3>
                Categoria: <select name="categoria">
                    <option value="Todas">Todas las categorias </option>
                    <option <?php if (isset($_POST['categoria'])) echo strcmp($_POST['categoria'], 'Libros') ? '' : "selected='selected'" ?> value="Libros">Libros</option>
                    <option <?php if (isset($_POST['categoria'])) echo strcmp($_POST['categoria'], 'Moviles') ? '' : "selected='selected'" ?> value="Moviles">Moviles</option>
                    <option <?php if (isset($_POST['categoria'])) echo strcmp($_POST['categoria'], 'Videojuegos') ? '' : "selected='selected'" ?> value="Videojuegos">Videojuegos</option>
                </select><br><br>

                ¿Qué buscas? <input id="search" type="text" name="search" placeholder="Buscar por texto" value="<?php echo isset($_POST['search']) ? ($_POST['search']) : ''; ?>"/><br><br>

                Rango de precio en €:
                <input type="text" id="amount" name="RangoPrecio" readonly style="color:#000000; font-weight:bold;"><br><br>
                <div id="slider-range" style="width: 300px;"></div>
            </div>
        
            <div class="ordenar">
                <h3> Ordenación </h3>

                Precio: <select name="ordenarPrecio">
                    <option value="ASC">ASC</option>
                    <option <?php if (isset($_POST['ordenarPrecio'])) echo strcmp($_POST['ordenarPrecio'], 'DESC') ? '' : "selected='selected'" ?> value="DESC">DESC</option>
                </select><br><br>

                Fecha: <select name="ordenarFecha">
                    <option value="ASC">ASC</option>
                    <option <?php if (isset($_POST['ordenarFecha'])) echo strcmp($_POST['ordenarFecha'], 'DESC') ? '' : "selected='selected'" ?> value="DESC">DESC</option>
                </select><br><br>
            </div>
        </div>
        <br><br>
        Realizar consulta: <input type="submit" name="filtros" value="Enviar" /><br><br>
    </form>
    <form method="post" action="public.php">
        Borrar filtros: <input type="submit" name="sinfiltros" value="Enviar" />      
    </form>
    
    <!--Div donde iran los productos-->
    <div class=productes-table></div>

    <?php
        require_once('database/dbConnection_hosting.php');
        
        //Query basica
        $sql = "SELECT * FROM producte";

        //Si no hay filtros aplicados, ejecutamos la query basica
        if(!isset($_POST['filtros'])){
            $result=$db->query($sql);
            while($row=$result->fetch(PDO::FETCH_ASSOC)){
                createTable($row);
            }
        
        //Si hay filtros aplicados, vamos añadiendo texto a la query por cada filtro
        } else {
            $consultaPreparada = false;
            $numFiltros = 0;
            
            //Filtro categoria
            if ($_POST['categoria'] != "Todas"){
                $categoria=$_POST['categoria'];
                $sql .= " WHERE categoria='$categoria' ";
                $numFiltros++;
            }

            //Buscar por palabra(s)
            if ($_POST['search'] != ""){
                
                //Si es el primer filtro aplicado
                if ($numFiltros == 0) {
                    $sql .= " WHERE ";
                }
                
                //Si hay más filtros anteriormente
                if ($numFiltros > 0) {
                    $sql .= " AND ";
                }
                $sql .= " LOWER(nom) LIKE LOWER(?) OR LOWER(descripcio) LIKE LOWER(?) ";
                $numFiltros++;
                $consultaPreparada=true;
            }
            
            //Rango de precio
            if (isset($_POST['RangoPrecio'])) {

                $amounts = explode(" - ", $_POST['RangoPrecio']);
                $precioMin = $amounts[0];
                $precioMax = $amounts[1];

                //Si es el primer filtro aplicado
                if ($numFiltros == 0) {
                    $sql .= " WHERE ";
                }

                //Si hay más filtros anteriormente
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

            //Si hay filtro de campo de busqueda preparamos consulta
            if ($consultaPreparada){
                $statement=$db->prepare($sql);
                $statement->execute(array("%".$_POST['search']."%", "%".$_POST['search']."%"));

                if ($statement->rowCount() == 0) {
                    echo "<h1>No s'han trobat resultats</h1>";
                }else{
                    while ($row=$statement->fetch(PDO::FETCH_ASSOC)) {
                        createTable($row);
                    }
                }
                $statement->closeCursor();
            
            //Si no hay filtro de campo de busqueda, no hace falta preparar la consulta
            } else {
                $result=$db->query($sql);
                if ($result->rowCount() == 0) {
                    echo "<h1>No s'han trobat resultats</h1>";
                }else{
                    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
                        createTable($row);
                    }
                }
            }
        }
        
        //Contenedor con imagen, propiedades e hipervínculo a la info de los Productos
        function createTable($row) {
            echo "<div class='producte-individual'>
                        <img src='imagenes/" . $row['foto1'] . "' style='width:200px;height:300px;'>
                    <div>
                        <ul style='list-style-type:none;'> 
                            <li>" . $row['nom'] . "</li>
                            <li>" . $row['preu'] . "</li>
                            <li>" . $row['categoria'] . "</li>
                            <li>" . $row['data_publicacio'] . "</li>
                            <li> <form method='POST' action='producteInfo.php'>
                                    <input type='hidden' name='id' value=" . $row['id'] . " />
                                    <input type='submit' value='Detalles' />
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>";
        }
    ?>
</body>
</html>