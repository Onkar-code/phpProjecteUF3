<!DOCTYPE html>
<html>
<head>
	<title>Zona de Usuario</title>
    <style>
        body {
            max-width: 1200px;
            margin: auto;
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
    <!--Link a la zona publica-->
    <a href="index.php">Volver a la zona publica</a><br><br>

    <!--Botón para cerrar sesión-->
	<form method="POST" action="private.php">
        <input type="submit" name="logout" value="Cerrar sesión"></button>
  	</form>
  	<br>

    <?php
        session_start();

        //Si pulsan cerrar sesión
        if (isset($_POST['logout'])) {
            unset($_SESSION['userId']);
            unset($_SESSION['username']);
        }

        //Si no hay sesión iniciada, redirigimos a la zona publica
        if (!isset($_SESSION['userId'])) {
            header('Location: index.php');
        }
        else {
            $userId = $_SESSION['userId'];
            echo "Hola " . $_SESSION['username'] . "! Aquí puedes ver una lista con los productos que has publicado. Puedes subir nuevos productos, o bien editar o eliminar tus productos existentes. Para ello, primero clica en Detalles de ese producto.";
        }
    ?>

	<div class=productes-table class=productes-table></div>

    <?php
        require_once('database/dbConnection_local.php');

        //Recuperamos productos del usuario
        $sql = "SELECT * FROM producte WHERE idClient = $userId";
        $result=$db->query($sql);

        //Si no tiene productos publicados
        if(!$result->rowCount()) {
            echo "<br><h1>No has publicado ningún producto todavía.</h1><br>";
        
        //Mostramos productos
        } else{ 
            while($row=$result->fetch(PDO::FETCH_ASSOC)){
                createTable($row);
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

    <!--Subir nuevo producto-->
    <br>
    <form method="POST" action="uploadEdit.php">
        <input type="submit" name="upload" value="Publicar nuevo producto"></button>
    </form>
</body>
</html>