<?php
	require_once('database/dbConnection_local.php');

    if (isset($_POST['edit'])) {
		$id = ($_POST['id']);
		$price = $_POST['price1'] . '.' . $_POST['price2'];
    	$sql = "UPDATE producte SET nom = ?, descripcio = ?, preu = ? WHERE id = $id";
    	$statement = $db->prepare($sql);
    	$statement->execute(array($_POST['name'], $_POST['desc'], $price));

    	header('location: producte-info.php?id=' . $id);
	}
?>