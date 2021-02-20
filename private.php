<?php
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: public.php');
	}
	else {
		echo 'Hola '.$_SESSION['username'].'!';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Zona de Usuario</title>
</head>
<body>
	<div class=productes-table></div>

<?php
    require_once('database/dbConnection_local.php');

	$sql = "SELECT * FROM producte WHERE idClient = $_SESSION['userId']";
    $result=$db->query($sql);

    if(!$result) { 
        print"Error en la consulta.\n";
    } else{ 
        foreach($result as $valor) {
            $array = [$valor["nom"],$valor["preu"],$valor["categoria"], $valor["data_publicacio"]];
            createTable($array);
        }
    }
</body>
</html>
