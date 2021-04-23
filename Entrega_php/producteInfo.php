<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <style>
        body{
            margin: 20px;
        }

        .cards-table{
            margin: auto;
            width: 70%;
            border: 3px solid green;
            padding: 10px;
            border-collapse: separate;
            border-spacing: 20px 5px;
        }

        .nom, .categoria, .visites {
            text-align: center; 
        }

        #carouselExampleControls{
            width: 200px;
            hight: 300px;
            margin: auto;
            padding-bottom: 10px;
        }
    </style>
</head>
    <body>
    <a href="public.php">Volver a la zona publica</a><br>
    <?php
        session_start();
        require('database/dbConnection_hosting.php');

        //Si hay una sesión iniciada, añadimos links para volver a la zona privada o para cerrar sesión
        if (isset($_SESSION['userId'])) {
            echo "<a href='private.php'>Volver a la zona privada</a><br><br>";
            echo "<form method='POST' action='private.php'>
                <input type='submit' name='logout' value='Cerrar sesión'></button>
            </form>";
        }

        //Si le dan a delete, borramos producto y volvemos a la zona privada
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $sql = "DELETE FROM producte WHERE id = ?";
            $statement=$db->prepare($sql);
            $statement->execute(array($id));

            //Borramos fotos de la carpeta imagenes
            for ($i = 1; $i <= 3; $i++) {
                unlink("imagenes/" . $id . "_" . $i . ".jpg");
            }
            header('location: private.php');
        }

        //Recogemos y mostramos info del producto
        $id = $_POST['id'];
        $sql = "SELECT * FROM producte WHERE id = $id";
        $result = $db->query($sql);
        while ($row=$result->fetch(PDO::FETCH_ASSOC)) {

            //Printamos tabla con los datos del producto
            producteIndividual($row);

            //Si el usuario logeado no es dueño del producto, o si no hay sesión iniciada, sumamos una visita al contador de ese producto
            $sql = "UPDATE producte SET visites = visites + 1 WHERE id = $id";

            if (isset($_SESSION['userId'])) {
                if (strcmp($_SESSION['userId'], $row['idClient']) != 0) {
                    $db->query($sql);
                }
            }
            else {
                $db->query($sql);
            }
        }

        
        function producteIndividual($row) {
            //Carousel fotos producto
            echo "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
                        <div class='carousel-inner'>
                        <div class='carousel-item active'>
                            <img src='imagenes/". $row['foto1'] . "' class='h-50 w-100' >
                        </div>
                        <div class='carousel-item'>
                            <img src='imagenes/". $row['foto2'] . "' class='h-50 w-100' >
                        </div>
                        <div class='carousel-item'>
                            <img src='imagenes/". $row['foto3'] . "' class='h-50 w-100'  >
                        </div>
                        </div>
                        <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Previous</span>
                        </a>
                        <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Next</span>
                        </a>
                </div>";  

            //Tabla producto individual
            echo "<div class='table'><table class='cards-table'>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Preu(€)</th>
                            <th>Categoria</th>
                            <th>Publicació</th>
                            <th>Visites</th>
                            <th>Descripció</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='nom'>" . $row['nom'] . "</td>
                            <td class='preu'>" . $row['preu'] . "</td>
                            <td class='categoria'>" . $row['categoria'] . "</td>
                            <td class='data'> " . $row['data_publicacio'] . "</td>
                            <td class='visites'>" . $row['visites'] . "</td>
                            <td class='descripcio'>" . $row['descripcio'] . "</td>
                        </tr>                  
                    </tbody>
                </table>
            </div>";

            //Si hay sesión iniciada y el usuario es dueño de ese producto, mostramos botones de editar y eliminar
            if (isset($_SESSION['userId'])) {
                $id = $_POST['id'];
                if ($_SESSION['userId'] == $row['idClient']) {
                    echo <<<EOT
                    <form method='POST' action='uploadEdit.php'>
                        <input type="hidden" name="id" value="$id" />
                        <input type='submit' name='edit' value='Editar producto'></input>
                    </form><br>
                    EOT;
                    echo <<<EOT
                    <form method='POST' action="producteInfo.php">
                        <input type="hidden" name="id" value="$id" />
                        <input type='submit' name='delete' onclick="return confirm('¿Seguro que quieres eliminar este producto?')" value='Eliminar producto'></input>
                    </form>
                    EOT;
                }
            }
        }
    ?>
</body>
</html>