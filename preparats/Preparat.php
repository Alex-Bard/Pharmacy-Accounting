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
        $query = "SELECT
                ID_Препарата as id, Международное_непатент_наименование as `name`, Дозировка as doz, срок_годности as `date`
            FROM препарат";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    public function readById($id){

        $query = "SELECT
                Id_поставки as id, Дата_поставки as `date`, Номер_документа as docNum, ID_Поставщика as PostId, ID_Состояния as statusId
            FROM поставка where Id_поставки = $id";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}