<a href="index.php">Volver a la zona publica</a><br>
    <?php
        session_start();
        require('database/dbConnection_local.php');

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
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style-individual.css">
    <title>Producte Info</title>

</head>
<body>
    <h1 id="load-text">Carregant info...</h1>

    <div id="table-info"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="app/app-individual.js"></script>
</body>
</html>

<?php
    //Si hay sesión iniciada y el usuario es dueño de ese producto, mostramos botones de editar y eliminar
    if (isset($_SESSION['userId'])) {
        $sql = "SELECT idClient FROM producte WHERE id =" . $_POST['id'];
        $result = $db->query($sql);
        $row=$result->fetch(PDO::FETCH_ASSOC);
        $id = $_GET['id'];
        if ($_SESSION['userId'] == $row['idClient']) {
            echo <<<EOT
            <form method='POST' action='edit.php'>
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
?>
