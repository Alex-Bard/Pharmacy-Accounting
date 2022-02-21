<?php

class Postavka
{
    private $conn;
    private $table_name = "поставщик";

    // свойства объекта
    public $id;
    public $date;
    public $docNum;
    public $statusId;
    public $postId;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read(){

        // выбираем все записи
        $query = "SELECT
                Id_поставки as id, Дата_поставки as `date`, Номер_документа as docNum, ID_Поставщика as PostId, ID_Состояния as statusId
            FROM поставка";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
    public function readById($id){

        // выбираем все записи
        $query = "SELECT
                Id_поставки as id, Дата_поставки as `date`, Номер_документа as docNum, ID_Поставщика as PostId, ID_Состояния as statusId
            FROM поставка where Id_поставки = $id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

//    function change(){
//        $sql = "UPDATE поставщик SET `Название`='$this->name',`Адрес`='$this->adress',`Телефон`='$this->phone',
//`Страна`='$this->country' WHERE 	ID_Поставщика = '$this->id'";
//        if ($this->conn->query($sql) == TRUE) {
//            return true;
//        } else {
//            echo "Error: " . $sql . "<br>" . $this->conn->error;
//            return false;
//        }
//    }

    function create(){
        $sql = "INSERT INTO поставка (Дата_поставки, Номер_документа, ID_Поставщика, ID_Состояния)
            VALUES ('$this->date', '$this->docNum', '$this->postId','$this->statusId');";
        if ($this->conn->query($sql) == TRUE) {
            return $this->conn->lastInsertId();
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

}