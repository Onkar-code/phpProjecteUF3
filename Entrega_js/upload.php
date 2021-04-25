<?php
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: login.php');
	}
	require_once('database/dbConnection_local.php');

	//Insertar producto en bd
	if (isset($_POST['confirmUpload'])) {
		$price = $_POST['price1'] . '.' . $_POST['price2'];
		$sql = "INSERT INTO producte (nom, descripcio, preu, categoria, data_publicacio, idClient) VALUES (?, ?, ?, ?, ?, ?)";
		$statement = $db->prepare($sql);
		$statement->execute(array($_POST['name'], $_POST['desc'], $price, $_POST['categoria'], date("Y-m-d"), $_SESSION['userId']));

		//Gestionar fotos
		$productId = $db->lastInsertId();
		$uploadDir = 'imagenes/';

		for ($i = 1; $i <= 3; $i++) {

			//Ejemplo: imagenes/1_1.jpg
			$foto = $uploadDir . $productId . '_' . $i . '.jpg';
			move_uploaded_file($_FILES['foto' . $i]['tmp_name'], $foto);
			$sql = "UPDATE producte SET foto$i = ? WHERE id = $productId";
			$statement = $db->prepare($sql);
			$statement->execute(array(basename($foto)));
			$statement->closeCursor();
		}
			
		header('location: private.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subir nuevo producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="app/upload.js"></script>
</head>
<body>
	<div class="container pt-5">
		<!--Link a la zona privada-->
		<button type="button" class="btn btn-primary" onClick="window.location.href='private.php'">Volver a la zona privada</button>
		
		<h4 class="text-center">Subir nuevo producto</h4>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<div class="form-row mt-5">
				<div class="col-6">
					<label for="name">Nombre*</label>
					<input type="text" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" maxlength="30" name="name">
					<div class="invalid-feedback"></div>
				</div>

				<div class="col-1"></div>
				<!--Parte entera-->
				<div class="col-2">
					<label>Precio*</label>
					<input type="text" class="form-control text-right" id="price1" value="<?php echo isset($_POST['price1']) ? $_POST['price1'] : '' ?>" maxlength="4" name="price1">
					<div class="invalid-feedback"></div>
				</div>

				<!--Parte decimal-->
				<div class="col-2">
					<label>.</label>
					<input type="text" class="form-control" id="price2" value="<?php echo isset($_POST['price2']) ? $_POST['price2'] : '00'; ?>" maxlength="2" name="price2">
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-1">
					<label class="invisible">€</label>
					<div class="mt-2">€</div>
				</div>
			</div>

			<div class="form-row mb-4">
				<div class="col-12">
					<label for="desc">Descripción*</label>
					<textarea type="text" class="form-control" id="desc" value="<?php echo isset($_POST['desc']) ? $_POST['desc'] : '' ?>" maxlength="200" name="desc"></textarea>
					<div class="invalid-feedback"></div>
				</div>	
			</div>

			<div class="form-row mb-4">
				<div class="col-6">
					<label>Categoria*</label>
					<select class="custom-select" id="categoria" name="categoria">
					</select>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-row mb-2 ml-1">Sube 3 fotos del producto*</div>

			<div class="form-row mb-4">
				<div class="col-4 custom-file">
					<input type="file" class="custom-file-input" id="foto1" name="foto1" accept="image/*">
					<label class="custom-file-label" for="foto1">Seleccionar archivo</label>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-4 custom-file">
					<input type="file" class="custom-file-input" id="foto2" name="foto2" accept="image/*">
					<label class="custom-file-label" for="foto2">Seleccionar archivo</label>
					<div class="invalid-feedback"></div>
				</div>
				<div class="col-4 custom-file">
					<input type="file" class="custom-file-input" id="foto3" name="foto3" accept="image/*">
					<label class="custom-file-label" for="foto3">Seleccionar archivo</label>
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<button class="btn btn-primary" type="submit" name="confirmUpload">Subir producto</button>
		</form>
	</div>
</body>
</html>