<?php

use Dom\Mysql;

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS','');
define('DB_NAME', 'classes');


define('PDO_DSN', 'mysql:host=127.0.0.1;dbname=classes;charset=utf8mb4');
define('PDO_USER', 'root');
define('PDO_PASS','');



function get_mysqli_connection(): mysqli{
    $mysqli = new mysqli( DB_HOST,DB_USER ,DB_PASS ,DB_NAME);
    if($mysqli->connect_errno){
        throw new RuntimeException("Mysqli Erreur de Connexion :". $mysqli->connect_error);
        
    }
    $mysqli->set_charset('utf8mb4');
    return $mysqli;

}


function get_pdo_connection(): PDO {
    try {
        $pdo = new PDO(PDO_DSN, PDO_USER, PDO_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        throw new RuntimeException("Erreur de connexion". $e->getMessage());
        
    }
}
?>