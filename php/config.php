<?php
$db_server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_dbname = "cnre";

try {
    $conn = new PDO("mysql:host=$db_server_name;dbname=$db_dbname", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

$conn->exec("SET CHARACTER SET utf8");
?>
