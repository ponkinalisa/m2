<?php 
# класс для работы с таблицей users
include('config.php');


class Users{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    # функция для проверки уникальности почты

    public function check_email($email){
        try{
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $result = $stmt->fetchAll();
            return count($result) === 0;
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
            return false;
        }
    }

    # проверка соответствия логина и пароля

    public function check_user($email, $password){
        try{
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['password'])){
                return true;
            }
            return false;
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
            return false;
        }
    }

    # добавление пользователя

    public function add($email, $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        try{
            $sql = "INSERT INTO users (email, password) VALUES(:email, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email, 'password' => $password]);
            $stmt->fetch();
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
        }
    }

    # получение id пользователя по email

    public function get_id($email){
        try{
            $sql = "SELECT id FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
            return false;
        }
    }
}
?>