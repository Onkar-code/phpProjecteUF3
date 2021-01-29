<?php
	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Registrarse</title>
</head>
<body>
	<h2>Registrarse</h2>
	<form method="post" action="">
		<label>Nombre</label>
        <input type="text" name="user" required /><br>

		<label>Primer apellido</label>
        <input type="text" name="user" required /><br>

		<label>Segundo apellido</label>
        <input type="text" name="user" required /><br>

        <label>Nombre de usuario</label>
        <input type="text" name="user" required /><br>

        <label>Email</label>
        <input type="email" name="email" required /><br>

        <label>Contraseña</label>
        <input type="password" name="password" required /><br><br>

	    <input type="submit" name="register" value="Register" />
	</form><br>
	¿Ya tienes cuenta? <a href='login.php'>Haz login</a>
</body>
</html>