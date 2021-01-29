<?php  
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