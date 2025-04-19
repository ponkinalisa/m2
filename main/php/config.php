<?php 
$host = "localhost";
$db_name="module_b";
$user = "root";
$password = "root";
try{
    $pdo1 = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo 'ошибка' . $e->getMessage();
}
?>