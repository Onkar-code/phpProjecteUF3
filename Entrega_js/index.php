
<?php
        session_start();

        //Si hay sesión iniciada, mostramos opciones de volver a la zona privada o cerrar sesión
        if (isset($_SESSION['userId'])) {
            echo "<a href='private.php'>Volver a la zona privada</a><br><br>
                <form method='POST' action='private.php'>
                    <input type='submit' name='logout' value='Cerrar sesión'></button>
                </form><br>";

        //Si no hay sesión iniciada, mostramos opciones de hacer login o registrarse
        } else {
            echo "<div class='loginRegister'>
                    <form action='login.php'>
                        <input type='submit' value='Login'></button>
                    </form>
                    <form action='register.php'>
                        <input type='submit' value='Register'></button>
                    </form>
                </div>";
        }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
</head>
<body>
    <div class="content">
        <form id="consulta">
            <div class="principal pt-4 pl-4 pr-4 pb-2">
                <div class="filtros">
                    <h3> Filtros </h3>
                    Categoria: <select id="categoria" name="categoria">

                    </select><br><br>

                    ¿Qué buscas? <input id="search" type="text" name="search" placeholder="Buscar por texto"/><br><br>
                </div>
                <div id="rango-precio" class="pl-4 mt-3">

                    Rango de precio en €:
                    <input class="precio" id="precioMax" type="text" name="search" placeholder="Precio máximo"/><br>
                    <input class="precio" id="precioMin" type="text" name="search" placeholder="Precio mínimo"/>
                </div>

                <div class="ordenar ml-4">
                    <h3> Ordenación </h3>

                    Precio: <select id="ordenarPrecio" name="ordenarPrecio">
                        <option value="ASC">ASC</option>
                    <option value="DESC">DESC</option>
                    </select><br><br>

                    Fecha: <select id="ordenarFecha" name="ordenarFecha">
                        <option value="ASC">ASC</option>
                        <option value="DESC">DESC</option>
                    </select><br><br>
                </div>
            </div>
            <div class="pl-4">
            <label  class="checkbox-inline">
                <input type="checkbox" id="checkbox" class="checkbox" name="skills" id="radio" value="Listado">Listado
            </label>
            <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox" name="skills" value="Mapa">Mapa
            </label>
            </div>
            <div class="send-consulta pl-4 pb-4">
                <form>
                    Realizar consulta: <input type="submit" id="fetch-data" name="filtros" value="Enviar" /><br><br>
                </form>
                <form id="borrar-filtros">
                    Borrar filtros: <input type="submit" name="sinfiltros" value="Enviar" />
                </form>
            </div>
        </form>
    </div>

    <div id="resultados">
        <div id="card-container" class="container-fluid py-5 bg-primary">
            <div id="cardList" class="row">
            </div>
        </div>
    </div>


    <script src="app/app.js"></script>
</body>
</html>