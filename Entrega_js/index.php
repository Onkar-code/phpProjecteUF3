<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
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

        <form id="consulta">
            <div class="row">
                <div class="col-9">
                    <h3> Filtros </h3>
                </div>
                <div class="col-3">
                    <h3> Ordenación </h3>
                </div>
            </div>
            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="categoria">Categoria:</label>
                        <select class="form-control" id="categoria" name="categoria"></select>
                    </div>
                    <div class="form-group">
                        <label for="search">¿Qué buscas?</label>
                        <input class="form-control" id="search" type="text" maxlength="200" placeholder="Buscar por texto"/>
                    </div>
                </div>
                <div class="col-1"></div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="precioMax">Precio máximo:</label>
                        <input class="form-control" id="precioMax" type="text" placeholder="Precio máximo"/>
                        <div class="invalid-feedback">
                        El precio debe contener sólo números.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="precioMax">Precio mínimo:</label>
                        <input class="form-control" id="precioMin" type="text" placeholder="Precio mínimo"/>
                        <div class="invalid-feedback">
                        El precio debe contener sólo números.
                        </div>
                        <div id="price-feedback" class="alert mt-2"></div>
                    </div>
                </div>
                <div class="col-1"></div>

                <div class="col-3">
                    <div class="form-group">
                        <label for="ordenarPrecio">Precio:</label>
                        <select class="form-control" id="ordenarPrecio">
                            <option value="ASC">ASC</option>
                            <option value="DESC">DESC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ordenarFecha">Fecha:</label>
                        <select class="form-control" id="ordenarFecha">
                            <option value="ASC">ASC</option>
                            <option value="DESC">DESC</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="list" checked="true">
                <label class="form-check-label" for="list">Listado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="map-radio">
                <label class="form-check-label" for="map">Mapa</label>
            </div>

            <div class="ml-1 mt-3 mb-3 row">
                <button type="submit" class='btn btn-success mr-3'>Realizar consulta</button>
                <button type="button" id="borrar" class='btn btn-secondary' onClick="location.reload()">Borrar filtros</button>
            </div>
        </form>
    </div>

    <div id="resultados">
        <div id="card-container" class="container my-5">
            <div id="cardList" class="row">
            </div>
        </div>
        <div id="resMapa">
            <div id="map">
            </div>
        </div>
        <h1 id="noResult" class="pt-4"> No se han encontrado resultados<h1>
    </div>
    
    <script src="app/app.js"></script>
</body>
</html>