	Filtros y ordenar, para public.php

	Ejemplo: en post(search) hay 'samsung' y en precio maximo hay 100
	"SELECT * FROM Producte WHERE nom %LIKE% 'samsung' OR descripcio %LIKE% 'samsung' AND preu < 100 ORDER BY Data DESC";

<?php
	
	if (isset($_POST['filtros'])) {
		$numFiltros = 0;

		//Comienzo SELECT
		$sql = "SELECT * FROM Producte";

		//Categoria
		if (isset($_POST['categoria'])) {
			$numFiltros++;
			if ($numFiltros > 0) {
				$sql .= " WHERE ";
			}
			$sql .= "categoria = " . $_POST['categoria'];
		}

		//Busqueda por nombre o desc
		if (isset($_POST['search'])) {
			$numFiltros++;
			if ($numFiltros > 0) {
				$sql .= " WHERE ";
			}
			if ($numFiltros > 1) {
				$sql .= " AND ";
			}
			$sql .= "LOWER(nom) %LIKE% LOWER(?) OR LOWER(descripcio) %LIKE% LOWER(?)";
		}

		//Preu minim
		if (isset($_POST['precioMin'])) {
			$numFiltros++;
			if ($numFiltros > 0) {
				$sql .= " WHERE ";
			}
			if ($numFiltros > 1) {
				$sql .= " AND ";
			}
			$sql .= "preu > $_POST['precioMin']";
		}

		//Preu max
		if (isset($_POST['precioMax'])) {
			$numFiltros++;
			if ($numFiltros > 0) {
				$sql .= " WHERE ";
			}
			if ($numFiltros > 1) {
				$sql .= " AND ";
			}
			$sql .= "preu < $_POST['precioMax']";
		}

		//Ordenar
		$sql .= " ORDER BY ";

		//preu
		if(isset($_POST['ordenarPrecio'])) {
			$sql .= "preu " . $_POST['ordenarPrecio'] . ", ";
		}

		//Data
		if(isset($_POST['ordenarFecha'])) {
			$sql .= "data_publicacio" . $_POST['ordenarFecha'];
		}

		//Por defecto
		else {
			$sql .= "data_publicacio DESC" //De nuevo a antiguo
		}

		$statement=$db->prepare($sql);
		$statement->execute(array($_POST['search'], $_POST['search']));
		//Falta tratar resultado
	}
?>

dropwdown ORDENAR PREU -> 'ASC'
				'DESC'
				
dropwdown ORDENAR DATA -> 'ASC'
				'DESC'


SLIDER HTML
$_POST['min']->value o------o $_POST['max']->value
MAX 9999,99
MIN 0