<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<?php
    require('database/dbConnection_local.php');

    $sql = "SELECT * FROM producte WHERE id = ?";
    
    $statement=$db->prepare($sql);
	$statement->execute(array($_POST["id"]));

    while ( $result=$statement->fetch(PDO::FETCH_ASSOC)) {
        $array = [$result["nom"],$result["preu"],$result["categoria"], $result["data_publicacio"],$result["visites"],$result["descripcio"],$result["foto1"],$result["foto2"],$result["foto3"]];
        producteIndividual($array);
    }


    function producteIndividual($array) {
        //carrusel producte
        echo "<div class='pic-ctn'>
                    <img src='imagenes/". $array[6] . "' alt='' class='pic' style='width:200px;height:300px>
                    <img src='imagenes/". $array[7] . "' alt='' class='pic' style='width:200px;height:300px>
                    <img src='imagenes/". $array[8] . "' alt='' class='pic' style='width:200px;height:300px>
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

        //Estils
        echo "<style>
            body{
                margin: 20px;
            }
            .cards-table{
                margin: auto;
                width: 50%;
                border: 3px solid green;
                padding: 10px;
                border-collapse: separate;
                border-spacing: 20px 5px;
            }
            .nom, .categoria, .visites {
                text-align: center; 
            }

            #carouselExampleControls{
                margin: auto;
                width: 300px;
                hight: 500px;
                padding-bottom: 10px;
            }

            .pic-ctn {
                width: 100vw;
                height: 200px;
            }

            
            @keyframes display {
                0% {
                transform: translateX(200px);
                opacity: 0;
                }
                10% {
                transform: translateX(0);
                opacity: 1;
                }
                20% {
                transform: translateX(0);
                opacity: 1;
                }
                30% {
                transform: translateX(-200px);
                opacity: 0;
                }
                100% {
                transform: translateX(-200px);
                opacity: 0;
                }
            }
            
            .pic-ctn {
                position: relative;
                width: 100vw;
                height: 300px;
                margin-top: 15vh;
            }
            
            .pic-ctn > img {
                position: absolute;
                top: 0;
                left: calc(50% - 100px);
                opacity: 0;
                animation: display 10s infinite;
            }
            
            img:nth-child(2) {
                animation-delay: 2s;
            }
            img:nth-child(3) {
                animation-delay: 4s;
            }
           
            </style>";
    }
?>