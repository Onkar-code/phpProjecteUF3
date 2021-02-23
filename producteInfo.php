<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  
  <form action="public.php">
        <input type="submit" value="Zona publica"></input>
  </form>
<?php
    session_start();
    if (isset($_SESSION['userId'])) {
        echo "<form action='private.php'>
            <input type='submit' value='Zona privada'></button>
        </form>";
        echo "<form method='POST' action='private.php'>
            <input type='submit' name='logout' value='Cerrar sesión'></button>
        </form>";
    }

    require('database/dbConnection_local.php');

    $sql = "SELECT * FROM producte WHERE id = ?";
    
    $statement=$db->prepare($sql);
	$statement->execute(array($_POST["id"]));

    while ( $result=$statement->fetch(PDO::FETCH_ASSOC)) {
        $array = [$result["nom"],$result["preu"],$result["categoria"], $result["data_publicacio"],$result["visites"],$result["descripcio"],$result["foto1"],$result["foto2"],$result["foto3"], $result["idClient"]];
        producteIndividual($array);
    }

    
    function producteIndividual($array) {
        //carrusel producte
        echo "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
                    <div class='carousel-inner'>
                    <div class='carousel-item active'>
                        <img src='imagenes/". $array[6] . "' class='h-50 w-100' >
                    </div>
                    <div class='carousel-item'>
                        <img src='imagenes/". $array[7] . "' class='h-50 w-100' >
                    </div>
                    <div class='carousel-item'>
                        <img src='imagenes/". $array[8] . "'  class='h-50 w-100'  >
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

        //Tabla producte individual
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
                        <td class='nom'>" . $array[0] . "</td>
                        <td class='preu'>" . $array[1] . "</td>
                        <td class='categoria'>" . $array[2] . "</td>
                        <td class='data'> " . $array[3] . "</td>
                        <td class='visites'>" . $array[4] . "</td>
                        <td class='descripcio'>" . $array[5] . "</td>
                    </tr>                  
                </tbody>
            </table>
        </div>";

        if (isset($_SESSION['userId'])) {
            if ($_SESSION['userId'] == $array[9]) {
                echo "<form method='POST' action='uploadEdit.php'>
                    <input type='submit' name='edit' value='Editar producto'></input>
                </form>";
                echo <<<EOT
                <form method='POST' action="producteInfo.php">
                    <input type='submit' name='delete' onclick="return confirm('¿Seguro que quieres eliminar este producto?')" value='Eliminar producto'></input>
                </form>
                EOT;
            }
        }

        //Estils
        echo "<style>
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
            </style>";
    }
?>