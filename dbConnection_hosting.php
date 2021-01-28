<?php
    //Variables de conexión
    $db_host = 'localhost';
    $db_user = '240159';
    $db_password = 'daw2php';
    $db_name = '240159';

    //iniciamos conexión
    try{
        $db=new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password); 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $ex) {
        die($ex->getMessage());
    }
?>