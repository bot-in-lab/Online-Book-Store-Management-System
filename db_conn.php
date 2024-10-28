<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sName = "localhost";
$uName = "root";
$pass = "";
$db_Name = "online_book_store_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_Name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
