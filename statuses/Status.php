<?php

class Status
{
    private $conn;
    private $table_name = "состояние";

    // свойства объекта
    public $id;
    public $name;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }


    function getAll()
    {
        // выбираем все записи
        $query = "SELECT
                ID_Состояния as id, Состояние as name
            FROM состояние";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
}