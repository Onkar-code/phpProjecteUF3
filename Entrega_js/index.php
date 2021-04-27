<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona pública</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">

    <!-- Load Leaflet from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js"
        integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q=="
        crossorigin=""></script>

    <!-- Geocoding Control -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
        integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
        crossorigin="">
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
        integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
        crossorigin=""></script>

</head>
<body>
    <div class="container pt-5">
        <?php
            session_start();

            //Si hay una sesión iniciada, añadimos links para volver a la zona privada o para cerrar sesión
            if (isset($_SESSION['userId'])) {
                echo <<<EOT
                <button type="button" class="btn btn-primary mb-4" onClick="window.location.href='private.php'">Volver a la zona privada</button>
                <form class="ml-1" action="private.php" method="post">
                    <div class="form-row mb-4">
                        <button class="btn btn-secondary" type="submit" name="logout">Cerrar sesión</button>
                    </div>
                </form>
                EOT;

            } else { //Si no hay sesión iniciada, mostramos opciones de hacer login o registrarse
                echo <<<EOT
                    <button type="button" class="btn btn-primary" onClick="window.location.href='login.php'">Login</button>
                    <button type="button" class="btn btn-primary" onClick="window.location.href='register.php'">Registrarse</button>
                EOT;
            }
        ?>
    </div>

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
                    <div class="mt-3 alert" id="feedback"></div>
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
                <input type="checkbox" id="checkbox" class="checkbox" name="skills" id="radio" value="Listado" checked="true">Listado
            </label>
            <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox" name="skills" value="Mapa">Mapa
            </label>
            </div>
            <div class="send-consulta pl-4 pb-4 row">
                <form class="col-2">
                    <button type="submit" class='btn btn-primary' id="fetch-data" name="filtros">Realizar consulta</button>
                </form>
                <form class="col-2" id="borrar-filtros">
                    <button type="submit" class='btn btn-primary' name="sinfiltros">Borrar filtros</button>
                </form>
            </div>
        </form>
    </div>

    <div id="resultados">
        <div id="card-container" class="container-fluid py-2">
            <div id="cardList" class="row">
            </div>
        </div>
        <div id="resMapa">
            <div id="map">
            </div>
        </div>
        <h1 id="noResult" class="pt-4" style="text-align:center;"> No se han encontrado resultados<h1>
        
    </div>
    <script src="app/app.js"></script>
</body>
</html>