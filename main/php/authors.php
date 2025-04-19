<?php 
include('config.php');

# класс для работы с таблицей authors

class Authors{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    # добавление элементов

    public function add($name){
        try{
            $sql = "INSERT INTO authors(name) VALUES(:name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['name' => $name]);
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
        }
    }

    public function get_id($name){
        try{
            $sql = "SELECT id FROM authors WHERE name = :name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['name' => $name]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
        }
    }
    
    # проверка наличия авторов с таким именем

    public function availability($name){
        try{
            $sql = "SELECT * FROM authors WHERE name = :name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['name' => $name]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return count($result) !== 0;
        }catch (PDOException $e){
            echo('Ошибка в users' . $e->getMessage());
            return null;
        }
    }
}


?>