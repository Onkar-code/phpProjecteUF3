
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
                        <option value="Todas">Todas las categorias </option>
                        <option value="Libros">Libros</option>
                        <option value="Moviles">Moviles</option>
                        <option value="Videojuegos">Videojuegos</option>
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="app/app.js"></script>
</body>
</html>