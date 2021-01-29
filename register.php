<?php
	//Hay que hacer comprobaciones de regex en el backend o se pueden hacer solo en el frontend con pattern y required?
	

	session_start();
	require_once('database/dbConnection_local.php');

	//Si envía formulario
	if (isset($_POST['register'])) {

		$message = '';

		//Comprobamos si ya existe el nombre de usuario en la bd
		$sql = "SELECT * FROM Client where usuari=?";
		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['user']));

		if ($statement->rowCount() > 0) {
			$message = 'Lo sentimos, este nombre de usuario ya está en uso<br>';
			$statement->closeCursor();
			exit();
		}

		$statement->closeCursor();

		//Comprobamos si ya existe el email en la bd
		$sql = "SELECT * FROM Client where email=?";
		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['email']));

		if ($statement->rowCount() > 0) {
			$message .= 'Este correo electrónico ya está asociado a una cuenta<br>';
			$statement->closeCursor();
			exit();
		}

		$statement->closeCursor();

		//Encriptamos password
		$_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

		//Insertamos datos usuario en la bd
		$sql = "INSERT INTO Client VALUES (?, ?, ?, ?, ?, ?)";
		$statement=$db->prepare($sql);

		//FALTA BINDEAR, EJECUTAR Y COMPROBAR
		unset($_POST['register']);
		print_r($_POST);
		$statement->execute($_POST);

		//Redireccionamos a la página del usuario
		$_SESSION['userId'] = $statement->lastInsertId();
		$_SESSION['username'] = $_POST['user'];

		$statement->closeCursor();
		header('Location: private.php');
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
	<h2>Registrarse</h2>
	<form method="post" action="">
		<label>Nombre<span>*</span></label>
        <input type="text" name="name" required /><br>

		<label>Primer apellido<span>*</span></label>
        <input type="text" name="surname1" required /><br>

		<label>Segundo apellido<span>*</span></label>
        <input type="text" name="surname2" required /><br>

        <label>Nombre de usuario<span>*</span></label>
        <input type="text" name="user" required pattern="[\dA-Za-z]+" /> Sólo letras o números<br>

        <label>Contraseña<span>*</span></label>
        <input type="password" name="pass" placeholder="Ejemplo: 1234abCD" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" required /> 
        Mínimo 8 carácteres, mínimo una mayúscula, una minúscula y un dígito<br>

        <label>Email<span>*</span></label>
        <input type="email" name="email" required /> ejemplo@ejemplo.com<br><br>

	    <input type="submit" name="register" value="Registrarme" />
	</form><br>
	¿Ya tienes cuenta? <a href='login.php'>Haz login</a><br>
	<?php if (isset($message)) echo $message; ?>
</body>
</html>