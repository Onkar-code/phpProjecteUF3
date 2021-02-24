<!DOCTYPE html>
<html>
<head>
	<title>Zona de Usuario</title>
</head>
<body>
	<form method="POST" action="private.php">
        <input type="submit" name="logout" value="Cerrar sesión"></button>
  	</form>
  	<a href="public.php">Zona publica</a>
  	<br>

<?php
	session_start();
	if (isset($_POST['logout'])) {
		unset($_SESSION['userId']);
        unset($_SESSION['username']);
	}
	if (!isset($_SESSION['userId'])) {
		header('Location: public.php');
	}
	else {
		$userId = $_SESSION['userId'];
		echo 'Hola '.$_SESSION['username'].'! Aquí puedes ver una lista con los productos que has publicado. Puedes subir nuevos productos, o bien editar o eliminar tus productos existentes. Para ello, primero clica en Detalles de ese producto.';
	}
?>

	<div class=productes-table></div>

<?php
    require_once('database/dbConnection_local.php');

	$sql = "SELECT * FROM producte WHERE idClient = $userId";
    $result=$db->query($sql);

    if(!$result) { 
        print"Error en la consulta.\n";
    } else{ 
        foreach($result as $valor) {
            $array = [$valor["nom"],$valor["preu"],$valor["categoria"], $valor["data_publicacio"],$valor["id"]];
            createTable($array);
        }
    }

    function createTable($array) {
        //contenedor con imagen, propiedades e hipervínculo a la info de los Productos

        echo "<div class='producte-individual'>
                    <img src='imagenes/$array[4]_1.jpg' style='width:200px;height:300px;'>
                <div>
                    <ul style='list-style-type:none;'> 
                        <li>" . $array[0] . "</li>
                        <li>" . $array[1] . "</li>
                        <li>" . $array[2] . "</li>
                        <li>" . $array[3] . "</li>
                        <li> <form method='POST' action='producteInfo.php'>
                                <input type='hidden' name='id' value=$array[4] />
                                <input type='submit' value='Detalles' />
                            </form>
                        </li>

                    </ul>
                </div>
            </div>";
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
    }
    </style>"
?>
<!--Subir producto-->
<br>
<form method="POST" action="uploadEdit.php">
    <input type="submit" name="upload" value="Publicar nuevo producto"></button>
</form>
</body>
</html>