<?php 
session_start();
if (isset($_SESSION['id'])){
    header('Location: main_page.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" and !empty($_POST)){
    include('../php/users.php');
    include('../php/config.php');
    if ($_POST['email'] == '' or $_POST['password'] == ''){
        $error = 'Вы не заполнили обязательные поля';
    }else if(strlen($_POST['password']) < 5){
        $error = 'Недостаточная длина пароля';
    }
    $users = new Users($pdo1);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    if ($users->check_email($email)){
        $error = 'Неверно указана почта';
    }
    if ($users->check_user($email, $password)){
        $error = 'Неверный логин или пароль';
    }
    if (!isset($error)){
        $_SESSION['id'] = $users->get_id($email);
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
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Введите ваш email">

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required placeholder="Введите ваш пароль">

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
