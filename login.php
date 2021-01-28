<?php 
	session_start();
	require_once('database/dbConnection_local.php');

	//Si envía formulario
	if (isset($_POST['send'])) {
		if (isset($_POST['user']) && isset($_POST['pass'])) {
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			if (strcmp($user, "asdf") == 0 && strcmp($pass, "asdf") == 0) {
				echo 'Login success!';
			}
			else {
				echo 'Login failed!';
			}
		} else {
			echo "Rellena todos los campos";	
		}
	}

	//Si no tiene cuenta linkeamos al formulario de registro
	if (isset($_POST['register'])) {
		header('location: register.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h2>Login</h2>
	<form action="" method="POST">
		<label>Username</label>
        <input type="text" name="user" /><br>

        <label>Password</label>
        <input type="password" name="pass" /><br><br>

		<input type="submit" name="send" value="Log in">
		<input type="submit" name="register" value="I don't have an account yet">
	</form>
</body>
</html>