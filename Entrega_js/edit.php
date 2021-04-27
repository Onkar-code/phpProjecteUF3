<?php
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: login.php');
	}
	require_once('database/dbConnection_local.php');

    $id = $_GET['id'];
    $sql = "SELECT * FROM producte WHERE id = ?";
    $statement = $db->prepare($sql);
	$statement->execute(array($id));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $name = $result['nom'];
    $desc = $result['descripcio'];
    $price = explode('.', $result['preu']);
    $price1 = $price[0];
    $price2 = $price[1];	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subir nuevo producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="app/edit.js"></script>
</head>
<body>
	<div class="container pt-5">
		<!--Link a la zona privada-->
		<button type="button" class="btn btn-primary" onClick="window.location.href='private.php'">Volver a la zona privada</button>
		
		<h4 class="text-center">Editar producto</h4>
		<form action="confirmEdit.php" method="post">
			<div class="form-row mt-5 mb-4">
				<div class="col-6">
					<label for="name">Nombre</label>
					<input type="text" class="form-control" id="name" value="<?php echo $name; ?>" maxlength="30" name="name">
					<div class="invalid-feedback"></div>
				</div>

				<div class="col-1"></div>
				<!--Parte entera-->
				<div class="col-2">
					<label>Precio</label>
					<input type="text" class="form-control text-right" id="price1" value="<?php echo $price1; ?>" maxlength="4" name="price1">
					<div class="invalid-feedback"></div>
				</div>

				<!--Parte decimal-->
				<div class="col-2">
					<label>.</label>
					<input type="text" class="form-control" id="price2" value="<?php echo $price2; ?>" maxlength="2" name="price2">
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-1">
					<label class="invisible">€</label>
					<div class="mt-2">€</div>
				</div>
			</div>

			<div class="form-row mb-4">
				<div class="col-12">
					<label for="desc">Descripción</label>
					<input type="text" class="form-control" id="desc" value="<?php echo $desc; ?>" maxlength="200" name="desc"></input>
					<div class="invalid-feedback"></div>
				</div>	
			</div>

			<button class="btn btn-success" type="submit" name="edit">Guardar cambios</button>
			<input type="hidden" name="id" value="<?php echo $id ?>" />
			<button type="button" class="btn btn-secondary" onClick="window.history.go(-1)">Cancelar</button>