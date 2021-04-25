<?php	
	session_start();
	require_once('database/dbConnection_local.php');

	if (isset($_POST['register'])) {
		//Comprobamos si ya existe el nombre de usuario en la bd
		$sql = "SELECT * FROM Client where usuari=?";
		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['user']));

		if ($statement->rowCount() > 0) {

			//Mensaje a mostrar en el HTML
			$msgUserExists = 'Lo sentimos, el nombre de usuario introducido ya está en uso';
		}
		$statement->closeCursor();

		//Comprobamos si ya existe el email en la bd
		$sql = "SELECT * FROM Client where LOWER(email)=LOWER(?)";
		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['email']));

		if ($statement->rowCount() > 0) {

			//Mensaje a mostrar en el HTML
			$msgEmailExists = 'El correo electrónico introducido ya está asociado a una cuenta';
		}
		$statement->closeCursor();

		//Si esta todo OK
		if (!isset($msgEmailExists) && !isset($msgUserExists)) {
			//Encriptamos password
			$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);

			//Insertamos datos del usuario en la bd
			$sql = "INSERT INTO Client (nom, cognom1, cognom2, usuari, password, email, telefon, dni, latitud, longitud) VALUES (?, ?, ?, ?, ?, LOWER(?), ?, ?, ?, ?)";
			$statement=$db->prepare($sql);
			$statement->execute(array($_POST['name'], $_POST['surname1'], $_POST['surname2'], $_POST['user'], $pass, $_POST['email'], $_POST['phone'], $_POST['dni'], 
								$_POST['latitude'], $_POST['longitude']));

			//Iniciamos sesión
			$_SESSION['userId'] = $db->lastInsertId();
			$_SESSION['username'] = $_POST['user'];

			$statement->closeCursor();

			//Redirigimos al area privada directamente para que no hay que hacer login
			header('Location: private.php');
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registro de Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Load Leaflet from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js"
        integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q=="
        crossorigin=""></script>

    <!-- Geocoding Control -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
        integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
        crossorigin="">
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
        integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
        crossorigin=""></script>
   

	<script src="app/register.js"></script>

	<style>
		#map {
			width: 600px;
			height: 400px;
		}
	</style>
</head>
<body>
	<div class="container pt-5">
		<!--Link a la zona pública-->
		<button type="button" class="btn btn-primary" onClick="window.location.href='index.php'">Volver a la zona pública</button>
		
		<h4 class="text-center">Registro de Usuario</h4>
		<div class="row">
			<div class="col-6">
				<form action="register.php" method="post">
					<div class="form-row mt-5 mb-4">
						<div class="col-4">
							<label for="name">Nombre*</label>
							<input type="text" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" maxlength="30" name="name">
							<div class="invalid-feedback"></div>
						</div>
		
						<div class="col-4">
							<label for="surname1">Primer apellido*</label>
							<input type="text" class="form-control" id="surname1" value="<?php echo isset($_POST['surname1']) ? $_POST['surname1'] : '' ?>" maxlength="30" name="surname1">
							<div class="invalid-feedback"></div>
						</div>	

						<div class="col-4">
							<label for="surname2">Segundo apellido*</label>
							<input type="text" class="form-control" id="surname2" value="<?php echo isset($_POST['surname2']) ? $_POST['surname2'] : '' ?>" maxlength="30" name="surname2">
							<div class="invalid-feedback"></div>
						</div>		
					</div>

					<div class="form-row mb-4">
						<div class="col-6">
							<label for="user">Nombre de usuario*</label>
							<input type="text" class="form-control" id="user" value="" maxlength="30" name="user">
							<div class="invalid-feedback" id="userFeedback"><?php if (isset($msgUserExists)) echo $msgUserExists; ?></div>
						</div>
						<div class="col-6">
							<label for="pass">Contraseña*</label>
							<input type="text" class="form-control" id="pass" value="" maxlength="60" name="pass" placeholder="Ejemplo: 123456Ab" 
								title="Mín. 8 carácteres, una mayúscula, una minúscula y un dígito">
							<div class="invalid-feedback"></div>
						</div>
					</div>

					<div class="form-row mb-4">
						<div class="col-6">
							<label for="email">Email*</label>
							<input type="email" class="form-control" id="email" maxlength="30" name="email" placeholder="ejemplo@ejemplo.com">
							<div class="invalid-feedback" id="emailFeedback"><?php if (isset($msgEmailExists)) echo $msgEmailExists; ?></div>
						</div>
		
						<div class="col-6">
							<label for="phone">Telefono*</label>
							<input type="text" class="form-control" id="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>" maxlength="9" name="phone">
							<div class="invalid-feedback"></div>
						</div>
					</div>

					<div class="form-row mb-4">
						<div class="col-6">
							<label for="dni">DNI*</label>
							<input type="text" class="form-control" id="dni" value="<?php echo isset($_POST['dni']) ? $_POST['dni'] : '' ?>" maxlength="9" name="dni" 
								placeholder="12345678A">
							<div class="invalid-feedback"></div>
						</div>
					</div>

					<div class="form-row mb-4">
						<div class="col-10">
							<label for="">Calle*</label>
							<input type="text" class="form-control" id="street" value="<?php echo isset($_POST['street']) ? $_POST['street'] : '' ?>" name="street" 
								placeholder="Tipo de vía + nombre. Ejemplo: Calle Jacinto Verdaguer">
							<div class="invalid-feedback"></div>
						</div>

						<div class="col-2">
							<label for="">Número*</label>
							<input type="text" class="form-control" id="number" value="<?php echo isset($_POST['number']) ? $_POST['number'] : '' ?>" name="number">
							<div class="invalid-feedback"></div>
						</div>
					</div>

					<div class="form-row mb-4">
						<div class="col-6">
							<label for="">Población*</label>
							<input type="text" class="form-control" id="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : '' ?>" name="city">
							<div class="invalid-feedback"></div>
						</div>
						<div class="col-3">
							<label for="">Código postal</label>
							<input type="text" class="form-control" id="postal" value="<?php echo isset($_POST['postal']) ? $_POST['postal'] : '' ?>" name="postal">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<input type="hidden" id="latitude" value="<?php echo isset($_POST['latitude']) ? $_POST['latitude'] : '' ?>" name="latitude"/>  
					<input type="hidden" id="longitude" value="<?php echo isset($_POST['longitude']) ? $_POST['longitude'] : '' ?>" name="longitude"/>  		
	
					<button class="btn btn-primary" type="submit" name="register">Registrarme</button>
									
					<!--Link al login-->
					¿Ya tienes cuenta? <a href='login.php'>Haz login</a><br>
				</form>
			</div>

			<div class="col-6 pt-5">
				<div id="map">
				</div>
				<button type="button" class="btn btn-secondary mt-2" id="findAddress">Buscar dirección</button>  
				<button type="button" class="btn btn-success mt-2" id="saveAddress">Guardar</button>
				<div class="mt-3 alert" id="feedback"></div>
			</div>		
		</div>

	</div>
</body>
</html>