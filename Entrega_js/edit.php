<?php
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('Location: login.php');
	}
	require_once('database/dbConnection_local.php');

    $id = $_POST['id'];
    $sql = "SELECT * FROM producte WHERE id = $id";
    $statement = $db->query($sql);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $name = $result['nom'];
    $desc = $result['descripcio'];
    $price = explode('.', $result['preu']);
    $price1 = $price[0];
    $price2 = $price[1];

    //Hacemos update del producto en la bd y devolvemos a la zona privada
	if (isset($_POST['confirmEdit'])) {
		$id = ($_POST['id']);
		$price = $_POST['price1'] . '.' . $_POST['price2'];
    	$sql = "UPDATE producte SET nom = ?, descripcio = ?, preu = ? WHERE id = $id";
    	$statement = $db->prepare($sql);
    	$statement->execute(array($_POST['name'], $_POST['desc'], $price));

    	//Tenemos que usar GET para poder volver al mismo producto en producteInfo
    	header('location: private.php');
	}