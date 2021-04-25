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

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="app/login.js"></script>
</head>
<body>
	<div class="container pt-5">
		<!--Link a la zona pública-->
		<button type="button" class="btn btn-primary" onClick="window.location.href='index.php'">Volver a la zona pública</button>

		<h4 class="text-center">Login</h4>
		<form action="login.php" method="post">
			<div class="form-row mt-5 mb-4">
				<div class="col-4"></div>
				<div class="col-4">
					<label for="user">Nombre de usuario</label>
					<input type="text" class="form-control" id="user" value="" maxlength="30" name="user">
					<div class="invalid-feedback"></div>
				</div>
			</div>
			<div class="form-row mb-4">
				<div class="col-4"></div>
				<div class="col-4">
					<label for="pass">Contraseña</label>
					<input type="text" class="form-control" id="pass" value="" maxlength="60" name="pass">
					<div class="invalid-feedback"></div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-4"></div>
				<div class="col-4">
					<button class="btn btn-primary" type="submit" name="login">Log in</button>
					
					<!--Link al register-->
					<a class="pl-2" href="register.php">No estoy registrado</a>
				</div>
			</div>
			<div class="form-row">
				<div class="col-4"></div>
				<div id="feedback" class="alert mt-3"><?php echo isset($failed) ? 'Nombre de usuario o contraseña incorrectos' : '' ?></div>
			</div>
		</form>
</body>
</html>