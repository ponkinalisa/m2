<?php 
include('config.php');

include('users.php');

session_start();

if (!empty($_POST)){
    $users = new Users($pdo1);
    $name = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $page = $_POST['page-number'];
    $cover = $_FILES['cover'];
    $ext = mb_split('\.', $cover['name'])[count(mb_split('\.', $cover['name'])) - 1];
    $name = random_int(0, 1000000000000);

    $img = imagecreatefromjpeg($cover['tmp_name']);
    if (imagesx($img) > imagesy($img)){
        $width = 300;  // Новая ширина
        $height =  (int)(imagesy($img) * 300 / imagesx($img));  // Новая высота
    }else{
        $height = 450;  // Новая ширина
        $width =  (int)(imagesx($img) * 450 / imagesy($img));  // Новая высота
    } 
    if ($width > 300){
        $width = 300;  // Новая ширина
        $height =  (int)($height * 300 / $width);  // Новая высота
    }
    if ($height > 450){
        $height = 450;  // Новая ширина
        $width =  (int)($width * 450 / $height);  // Новая высота
    }

    $tmp1 = imagecreatetruecolor(300, 450); 

    $tmp = imagecreatetruecolor($width, $height); 

    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $width, $height, imagesx($img), imagesy($img));  // Масштабируем изображение

    $dir = '../user_img/'.$_SESSION['id'];

    if (!file_exists($dir)){
        mkdir($dir);
    }
    imagecopy($tmp1, $tmp, (300 - imagesx($tmp)) / 2,  (450 - imagesy($tmp)) / 2, 0, 0, imagesx($tmp), imagesy($tmp)); 

    $path = $dir . '/' . $name . '.' . $ext;


    header('Content-Type: image/jpeg');
    imagejpeg($tmp1, $path);
    imagedestroy($tmp);
    imagedestroy($img);
    exit();
}
?>