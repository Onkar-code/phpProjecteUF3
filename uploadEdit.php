<?php
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: login.php');
	}
	require_once('database/dbConnection_hosting.php');

	//Si hemos entrado para editar producto
	if (isset($_POST['edit'])) {
		$id = $_POST['id'];
    	$sql = "SELECT * FROM producte WHERE id = $id";
    	$statement = $db->query($sql);
    	$result = $statement->fetch(PDO::FETCH_ASSOC);
    	$name = $result['nom'];
    	$desc = $result['descripcio'];
    	$price = explode('.', $result['preu']);
    	$price1 = $price[0];
    	$price2 = $price[1];
	}

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
	<title><?php echo isset($_POST['upload']) ? "Subir nuevo " : "Editar " ?> producto</title>
	<style type="text/css">
		span {
			color: red;
		}
	</style>
</head>
<body>
	<a href='private.php'>Volver a la zona privada</a>
	<h2><?php echo isset($_POST['upload']) ? "Subir nuevo " : "Editar " ?> producto</h2>

	<form method="post" action="" enctype="multipart/form-data">
		<label>Nombre<span>*</span></label>
        <input type="text" name="name" required maxlength="30" value="<?php echo isset($name) ? $name : ''; ?>"/><br>

		<label>Descripción</label>
        <input type="text" name="desc" maxlength="200" size="100" value="<?php echo isset($desc) ? $desc : ''; ?>"/><br>

		<label>Precio<span>*</span></label>
        <input type="text" name="price1" required maxlength="4" pattern="^\d+$" value="<?php echo isset($price1) ? $price1 : ''; ?>"/>
        .
        <input type="text" name="price2" required maxlength="2" pattern="^\d{2}$" value="<?php echo isset($price2) ? $price2 : '00'; ?>" />
        €<br>


<!--Si se está subiendo producto nuevo, se puede seleccionar la categoría y subir las fotos, si se está editando, solo se puede cambiar nombre, desc y precio-->
<?php
	if (isset($_POST['upload'])) {
?>
        <label>Categoria<span>*</span></label>
        <select name="categoria" required>
        	<option value=""/>
            <option value="Libros">Libros</option>
            <option value="Moviles">Moviles</option>
            <option value="Videojuegos">Videojuegos</option>
        </select><br><br>

        <label>Fotografía 1 (foto principal que se verá en la zona pública)<span>*</span></label><br>
        <input type="file" name="foto1" required accept="image/*" />
        <br><br>

        <label>Fotografía 2<span>*</span></label><br>
        <input type="file" name="foto2" required accept="image/*" />
        <br><br>

        <label>Fotografía 3<span>*</span></label><br>
        <input type="file" name="foto3" required accept="image/*" />
        <br><br><br>
<?php
	}
?>

        <!--Depende de si está subiendo producto nuevo o editando existente, el nombre de la variable POST cambia-->
        <input type="hidden" name="id" value="<?php echo $id ?>" />
	    <br>
		<input type="submit" name="<?php echo isset($_POST['upload']) ? 'confirmUpload' : 'confirmEdit' ?>" value="Guardar" />
	</form>
</body>
</html>