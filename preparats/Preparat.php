<?php

class Preparat
{
    private $conn;
    private $table_name = "препарат";

    // свойства объекта
    public $id;
    public $name;
    public $doz;
    public $date;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read(){

        // выбираем все записи
        $query = "SELECT
                ID_Препарата as id, Международное_непатент_наименование as `name`, Дозировка as doz, срок_годности as `date`
            FROM препарат";

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
}