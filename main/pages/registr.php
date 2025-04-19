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
    $password1 = $_POST['password'];
    $confirm_pass = $_POST['confirm-password'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_error = 1;
        $error = 'Формат почты неправильный';
    }
    if ($confirm_pass != $password1){
        $error = 'Повтор пароля неверен';
    }

    if (($users->check_email($email) == false)){
        $error = 'пользователь с таким логином уже существует';
    }

    if (!isset($error)){
        $users->add(htmlspecialchars($email), htmlspecialchars($password1));
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Подключение стилей -->
</head>
<body>
    <div class="auth-container">
        <div id="register-form">
            <h2>Регистрация</h2>
            <form action="registr.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Введите ваш email">

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required minlength="4" placeholder="Введите ваш пароль">

                <label for="confirm-password">Подтвердите пароль:</label>
                <input type="password" id="confirm-password" name="confirm-password" required placeholder="Подтвердите пароль">

                <button type="submit">Зарегистрироваться</button>

                <p>Уже есть аккаунт? <a href="index.php">Войдите</a></p>
            </form>
            <!-- Ошибка регистрации -->
            <div id="register-error" style="color: red;">
            <?php if (isset($error)){
                    echo($error);
                }?>
            </div>
        </div>
    </div>

    <script>
        // Простая валидация формы на клиенте
        document.getElementById('register-form').addEventListener('submit', function(event) {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm-password').value;

            // Проверка, чтобы пароли совпадали
            if (password !== confirmPassword) {
                alert('Пароли не совпадают!');
                event.preventDefault();
            }

            // Проверка на заполненность полей
            if (!email || password.length < 3) {
                alert('Пожалуйста, заполните все поля правильно!');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
