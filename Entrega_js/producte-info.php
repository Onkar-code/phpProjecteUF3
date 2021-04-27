<!DOCTYPE html>
<html lang="en">
<head>
    <title>Producte Info</title>
    <link rel="stylesheet" href="css/style-individual.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="app/app-individual.js"></script>
</head>
<body>
    <div class="container pt-5">
        <!--Link a la zona pública-->
        <button type="button" class="btn btn-primary mb-4" onClick="window.location.href='index.php'">Volver a la zona publica</button>
        
        <?php
            session_start();
            require('database/dbConnection_local.php');

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

            //Si hay una sesión iniciada, añadimos links para volver a la zona privada o para cerrar sesión
            if (isset($_SESSION['userId'])) {
                echo <<<EOT
                <button type="button" class="btn btn-primary mb-4" onClick="window.location.href='private.php'">Volver a la zona privada</button>
                <form class="ml-1" action="private.php" method="post">
                    <div class="form-row mb-4">
                        <button class="btn btn-secondary" type="submit" name="logout">Cerrar sesión</button>
                    </div>
                </form>
                EOT;
            }
        ?>
    </div>
        
        <!--Info producto-->
        <div id="table-info"></div>

        <?php
            //Si hay sesión iniciada y el usuario es dueño de ese producto, mostramos botones de editar y eliminar
            if (isset($_SESSION['userId'])) {
                $id = $_GET['id'];
                $sql = "SELECT idClient FROM producte WHERE id = ?";
                $statement=$db->prepare($sql);
                $statement->execute(array($id));
                $row=$statement->fetch(PDO::FETCH_ASSOC);

                if ($_SESSION['userId'] == $row['idClient']) {
                    echo <<<EOT
                    <div class="container pt-5">
                        <button type='submit' class="btn btn-success" onClick="window.location.href='edit.php?id=$id'">Editar producto</button>
                        <form method='POST' action="producte-info.php">
                            <div class="form-row mt-2 mb-4">
                                <input type="hidden" name="id" value="$id" />
                                <button type='submit' class="btn btn-danger" name='delete' onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar producto</button>
                            </div>
                        </form>
                    </div>
                    EOT;
                }
            }
        ?>
</body>
</html>