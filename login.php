<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css">
		span {
			color: red;
		}
	</style>
</head>
<body>

	<!--Link a la zona publica-->
	<a href="public.php">Volver a la zona publica</a><br>

	<!--PHP-->
	<?php 
		session_start();
		require_once('database/dbConnection_local.php');

		//Si envía formulario
		if (isset($_POST['login'])) {
			
			//Comprobar nombre de usuario o email
			$sql = "SELECT * FROM Client where usuari=? || email=?";
			$statement=$db->prepare($sql);
			$statement->execute(array($_POST['user'], $_POST['user']));

			while($row=$statement->fetch(PDO::FETCH_ASSOC)){

				//Comprobamos contraseña, iniciamos sesión y redirigimos a zona privada
				if (password_verify($_POST['pass'], $row['password'])) {
					$statement->closeCursor();
					$_SESSION['userId'] = $row['id'];
					$_SESSION['username'] = $row['nom'];
					header('Location: private.php');
				}
			}
			$statement->closeCursor();
			$failed = true;
		}
	?>

	<h2>Login</h2>
	<form action="" method="POST">
		<label>Nombre de usuario o email</label>
        <input type="text" name="user" required /><br>

        <label>Contraseña</label>
        <input type="password" name="pass" required /><br><br>

		<input type="submit" name="login" value="Log in" /> <?php echo isset($failed) ? '<span>Login failed!</span>' : '' ?>
	</form><br>

	<!--Link al register-->
	<a href="register.php">No estoy registrado</a>
</body>
</html>