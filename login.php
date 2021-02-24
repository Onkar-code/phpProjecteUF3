<?php 
	session_start();
	require_once('database/dbConnection_local.php');

	//Si envía formulario
	if (isset($_POST['send'])) {
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];

		//Comprobar nombre de usuario o email
		$sql = "SELECT * FROM Client where usuari=? || email=?";
		$statement=$db->prepare($sql);
		$statement->execute(array($user, $user));

		while($row=$statement->fetch(PDO::FETCH_ASSOC)){

			//Comprobar contraseña, iniciamos sesión
			if (password_verify($pass, $row['password'])) {
				$statement->closeCursor();
				$_SESSION['userId'] = $row['id'];
				$_SESSION['username'] = $row['nom'];
				header('Location: private.php');
			}
		}
		$statement->closeCursor();
		echo 'Login failed!';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<a href="public.php">Volver a la zona publica</a>
	<h2>Login</h2>
	<form action="" method="POST">
		<label>Nombre de usuario o email</label>
        <input type="text" name="user" required /><br>

        <label>Contraseña</label>
        <input type="password" name="pass" required /><br><br>

		<input type="submit" name="send" value="Log in" />
		
	</form><br>
	<a href="register.php">No estoy registrado</a>
</body>
</html>