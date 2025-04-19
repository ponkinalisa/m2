<?php 
include('config.php');

# класс для работы с таблицей books

class Books{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    # добавление элементов

    public function add($user_id, $genre, $author, $year_of_publication, $path_to_cover, $last_page){
        try{
            $sql = "INSERT INTO books(user_id, genre, author, year_of_publication, path_to_cover, last_page) VALUES(:user_id, :genre, :author, :year_of_publication, :path_to_cover, :last_page)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id, 'genre' => $genre, 'author' => $author, 'year_of_publication' => $year_of_publication, 'path_to_cover' => $path_to_cover, 'last_page' => $last_page]);
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
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
            return null;
        }
    }
}


?>