<?php 
$host = "localhost";
$db_name="module_b";
$user1 = "root";
$password1 = "root";
try{
    $pdo1 = new PDO("mysql:host=$host;dbname=$db_name", $user1, $password1);
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo 'ошибка' . $e->getMessage();
}
?>