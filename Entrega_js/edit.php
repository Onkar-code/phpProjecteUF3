<?php
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: login.php');
	}
	require_once('database/dbConnection_local.php');

    $id = $_POST['id'];
    $sql = "SELECT * FROM producte WHERE id = $id";
    $statement = $db->query($sql);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $name = $result['nom'];
    $desc = $result['descripcio'];
    $price = explode('.', $result['preu']);
    $price1 = $price[0];
    $price2 = $price[1];

    //Hacemos update del producto en la bd y devolvemos a la zona privada
	if (isset($_POST['confirmEdit'])) {
		$id = ($_POST['id']);
		$price = $_POST['price1'] . '.' . $_POST['price2'];
    	$sql = "UPDATE producte SET nom = ?, descripcio = ?, preu = ? WHERE id = $id";
    	$statement = $db->prepare($sql);
    	$statement->execute(array($_POST['name'], $_POST['desc'], $price));

    	//Tenemos que usar GET para poder volver al mismo producto en producteInfo
    	header('location: private.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subir nuevo producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container pt-5">
		<!--Link a la zona privada-->
		<button type="button" class="btn btn-primary" onClick="window.location.href='private.php'">Volver a la zona privada</button>
		
		<h4 class="text-center">Subir nuevo producto</h4>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<div class="form-row mt-5 mb-4">
				<div class="col-4">
					<label for="name">Nombre*</label>
					<input type="text" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" maxlength="30" name="name">
					<div class="invalid-feedback"></div>
				</div>
				</div class="col-4">
					<label for="price1">Precio*</label>
					<input type="text" class="form-control" id="price1" value="<?php echo isset($_POST['price1']) ? $_POST['price1'] : ''; ?>" maxlength="4" name="price1" pattern="^\d+$"/>
					<div class="invalid-feedback"></div>
					<!--Punto decimal-->
					.
				</div>
				</div class="col-4">
					<input type="text" class="form-control" id="price2" value="<?php echo isset($_POST['price2']) ? $_POST['price2'] : '00'; ?>" maxlength="2" name="price2" pattern="^\d{2}$"/>
					<!--Símbolo de euro-->
					€
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-row mb-4">
				<div class="col-12">
					<label for="desc">Descripción*</label>
					<input type="text" class="form-control" id="desc" value="<?php echo isset($_POST['desc']) ? $_POST['desc'] : '' ?>" maxlength="200" size="100" name="desc">
					<div class="invalid-feedback"></div>
				</div>	
			</div>



    <!--Depende de si está subiendo producto nuevo o editando existente, el nombre de la variable POST cambia-->
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        <input type="submit" name="confirmEdit" />