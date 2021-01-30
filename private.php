<?php
	//EN LA ZONA PRIVADA TIENEN QUE APARECER TODOS LOS PRODUCTOS Y PODER FILTRAR, ETC COMO EN LA PUBLICA?

	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: login.php');
	}
	else {
		echo 'Hola '.$_SESSION['username'].'!';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Zona de Usuario</title>
</head>
<body>

</body>
</html>