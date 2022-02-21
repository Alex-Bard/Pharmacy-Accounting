<?php

class Postavshik
{

    private $conn;
    private $table_name = "поставщик";

    // свойства объекта
    public $id;
    public $name;
    public $adress;
    public $phone;
    public $country;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read($mode, $sort, $serch){
        $query = "";
        if ($mode =="sortOnly"){
            $query = "SELECT
                ID_Поставщика as id, Название as name, Адрес as adress, Телефон as phone, Страна as country
            FROM поставщик ORDER BY Название $sort";
        }
        elseif ($mode == "sortAndSearch") {
            $query = "SELECT
                ID_Поставщика as id, Название as name, Адрес as adress, Телефон as phone, Страна as country
            FROM поставщик WHERE Название LIKE '%$serch%' ORDER BY Название $sort";
        }
        // выбираем все записи


        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
    public function readById($id){

        // выбираем все записи
        $query = "SELECT
                ID_Поставщика as id, Название as name, Адрес as adress, Телефон as phone, Страна as country
            FROM поставщик WHERE ID_Поставщика = $id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    function change(){
        $sql = "UPDATE поставщик SET `Название`='$this->name',`Адрес`='$this->adress',`Телефон`='$this->phone',
`Страна`='$this->country' WHERE 	ID_Поставщика = '$this->id'";
        if ($this->conn->query($sql) == TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    function create(){
        $sql = "INSERT INTO поставщик (Название, Адрес, Телефон, Страна)
            VALUES ('$this->name', '$this->adress', '$this->phone','$this->country');";
        if ($this->conn->query($sql) == TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }


    function delete()
    {
        $sql = "DELETE FROM поставщик WHERE ID_Поставщика = '$this->id'";
        if ($this->conn->query($sql) == TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

}

