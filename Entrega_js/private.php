<!DOCTYPE html>
<html>
<head>
	<title>Zona de Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="app/private.js"></script>
</head>
<body>
    <div class="container pt-5">
            <!--Link a la zona pública-->
            <button type="button" class="btn btn-primary" onClick="window.location.href='index.php'">Volver a la zona publica</button>

            <!--Botón para cerrar sesión-->
            <form class="ml-1" action="private.php" method="post">
                <div class="form-row mt-3 mb-4">
                    <button class="btn btn-secondary" type="submit" name="logout">Cerrar sesión</button>
                </div>
            </form>

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
                    $username = $_SESSION['username'];
                    $userId = $_SESSION['userId'];
                    echo <<<EOT
                        <h5 class='mb-4'>Hola $username! Aquí puedes ver una lista con los productos que has publicado. Puedes subir nuevos productos, 
                        o bien editar o eliminar tus productos existentes. Para ello, primero clica en Detalles de ese producto.</h5>
                    EOT;
                }
            ?>

        <div class="row">

            <?php
                require_once('database/dbConnection_local.php');

                //Recuperamos productos del usuario
                $sql = "SELECT * FROM producte WHERE idClient = $userId";
                $result=$db->query($sql);

                //Si no tiene productos publicados
                if(!$result->rowCount()) {
                    echo "<h1 class='ml-5 mt-5'>No has publicado ningún producto todavía.</h1>";
                
                //Mostramos productos
                } else{ 
                    while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        createTable($row);
                    }
                }
                    
                //Contenedor con imagen, propiedades e hipervínculo a la info de los Productos
                function createTable($row) {
                    echo "<div class='col-4 mb-4'>
                            <img src='imagenes/" . $row['foto1'] . "' style='max-width:200px;max-height:200px; object-fit: contain;'>
                            <div>" . $row['nom'] . "</div>
                            <div>" . $row['preu'] . "</div>
                            <div>" . $row['categoria'] . "</div>
                            <div>" . $row['data_publicacio'] . "</div>
                            <button id=" . $row['id'] . " class='info-producte btn btn-primary'>Mes informació</button>
                        </div>";
                }
            ?>

        </div>
        
        <!--Subir nuevo producto-->
        <button type="button" class="btn btn-success mt-5" onClick="window.location.href='upload.php'">Subir nuevo producto</button>
    </div>
</body>
</html>