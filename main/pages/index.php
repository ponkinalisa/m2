<?php 
session_start();
if (isset($_SESSION['id'])){
    header('Location: main_page.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" and !empty($_POST)){
    include('../php/users.php');
    include('../php/config.php');
    if ($_POST['email'] == ''){
        $email_error = 1;
        $error = 'Вы не заполнили обязательные поля';
    }if ($_POST['password'] == ''){
        $pass_error = 1;
        $error = 'Вы не заполнили обязательные поля';
    }if(strlen($_POST['password']) < 5){
        $pass_error = 1;
        $error = 'Недостаточная длина пароля';
    }
    $users = new Users($pdo1);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_error = 1;
        $error = 'Формат почты неправильный';
    }
    if ($users->check_email($email)){
        $email_error = 1;
        $error = 'Такого пользователя не существует. Неверная почта.';
    }
    if (!$users->check_user($email, $password)){
        $email_error = 1;
        $pass_error = 1;
        $error = 'Неверный логин или пароль';
    }
    if (!isset($error)){
        $_SESSION['id'] = $users->get_id($email);
        $_SESSION['limit'] = 0;
        header('Location: main_page.php');
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="../css/styleInd.css"> <!-- Подключение стилей -->
</head>
<body>
    <div class="auth-container">
        <div id="login-form">
            <h2>Авторизация</h2>
            <form id="login-form" action="index.php" method="POST">
                <label for="email" >Email:</label>
                <input type="email" id="email" name="email" required placeholder="Введите ваш email" <?php if(isset($email_error)){echo('style="background-color: red"');} ?>>

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required placeholder="Введите ваш пароль" <?php if(isset($pass_error)){echo('style="background-color: red"');} ?>>

                <button type="submit">Войти</button>

                <p>Нет аккаунта? <a href="registr.php">Зарегистрируйтесь</a></p>
            </form>
            <!-- Ошибка авторизации -->
            <div id="login-error" style="color: red;">
                <?php if (isset($error)){
                    echo($error);
                }?>
            </div>
        </div>
    </div>

    <script>
        // Простая валидация формы на клиенте
        document.getElementById('login-form').addEventListener('submit', function(event) {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            
            // Проверка, чтобы поля были заполнены
            if (!email || !password) {
                alert('Пожалуйста, заполните все поля!');
                event.preventDefault(); // Отменяет отправку формы
            } else {
                // Если поля заполнены, перенаправляем на главную страницу
                window.location.href = "main_page.html";
            }
        });
    </script>
</body>
</html>
