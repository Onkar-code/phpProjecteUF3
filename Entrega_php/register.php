<?php	
	session_start();
	require_once('database/dbConnection_hosting.php');

	if (isset($_POST['register'])) {
		//Comprobamos si ya existe el nombre de usuario en la bd
		$sql = "SELECT * FROM Client where usuari=?";
		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['user']));

		if ($statement->rowCount() > 0) {

			//Mensaje a mostrar en el HTML
			$msgUserExists = 'Lo sentimos, este nombre de usuario ya está en uso<br>';
		}
		$statement->closeCursor();


		//Comprobamos si ya existe el email en la bd
		$sql = "SELECT * FROM Client where LOWER(email)=LOWER(?)";
		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['email']));

		if ($statement->rowCount() > 0) {

			//Mensaje a mostrar en el HTML
			$msgEmailExists = 'Este correo electrónico ya está asociado a una cuenta<br>';
		}
		$statement->closeCursor();

		//Si esta todo OK
		if (!isset($msgEmailExists) && !isset($msgUserExists)) {
			//Encriptamos password
			$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);

			//Insertamos datos del usuario en la bd
			$sql = "INSERT INTO Client (nom, cognom1, cognom2, usuari, password, email) VALUES (?, ?, ?, ?, ?, LOWER(?))";
			$statement=$db->prepare($sql);
			$statement->execute(array($_POST['name'], $_POST['surname1'], $_POST['surname2'], $_POST['user'], $pass, $_POST['email']));

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
	<title>Crear cuenta</title>
	<style type="text/css">
		span {
			color: red;
		}
	</style>
</head>
<body>
	<a href="public.php">Volver a la zona publica</a>
	<h2>Registrarse</h2>
	<form method="post" action="">
		<label>Nombre<span>*</span></label>
        <input type="text" name="name" required maxlength="30" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>"/><br>

		<label>Primer apellido<span>*</span></label>
        <input type="text" name="surname1" required maxlength="30" value="<?php echo isset($_POST['surname1']) ? $_POST['surname1'] : '' ?>"/><br>

		<label>Segundo apellido<span>*</span></label>
        <input type="text" name="surname2" required maxlength="30" value="<?php echo isset($_POST['surname2']) ? $_POST['surname2'] : '' ?>"/><br>

        <label>Nombre de usuario<span>*</span></label>
        <input type="text" name="user" required maxlength="30" pattern="[\dA-Za-z\-]+" /> Sólo letras, números o guiones<br>
        <!-- Mensaje a mostrar en caso de error -->
		<?php if (isset($msgUserExists)) echo "<span>$msgUserExists</span>"; ?>

        <label>Contraseña<span>*</span></label>
        <input type="password" name="pass" placeholder="Ejemplo: 1234abCD" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" required /> 
        Mínimo 8 carácteres, mínimo una mayúscula, una minúscula y un dígito<br>

        <label>Email<span>*</span></label>
        <input type="email" name="email" required maxlength="30" /> ejemplo@ejemplo.com<br>
        <!-- Mensaje a mostrar en caso de error -->
		<?php if (isset($msgEmailExists)) echo "<span>$msgEmailExists</span><br>"; ?><br>

	    <input type="submit" name="register" value="Registrarme" />
	</form><br>

	<!--Link al login-->
	¿Ya tienes cuenta? <a href='login.php'>Haz login</a><br>
</body>
</html>