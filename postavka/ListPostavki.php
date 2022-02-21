<?php

class ListPostavki
{
    private $conn;
    private $table_name = "Список_поставки";

    // свойства объекта
    public $idPost;
    public $idPrep;
    public $idAPrep;
    public $name;
    public $count;
    public $cost;
    public $dateIzg;
    public $doze;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read(){

        // выбираем все записи
        $query = "SELECT sp.ID_поставки as idPost, sp.ID_им_препарата as idPrep, pr.Международное_непатент_наименование as name, pr.Дозировка as doze, ip.дата_изготовления as `date`,
                            ip.Стоимость_за_единицу as cost, sp.количество as `count`, post.Дата_поставки as `date_post`
            FROM список_поставки sp 
            LEFT JOIN имеющиеся_препараты ip ON (sp.ID_им_препарата = ip.ID_им_препарата)
            LEFT JOIN препарат pr ON (ip.ID_Препарата = pr.ID_Препарата)
            LEFT JOIN поставка post ON (sp.ID_поставки = post.Id_поставки)";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
    public function readByIdPostav($id){

        $query = "SELECT sp.ID_поставки as idPost, sp.ID_им_препарата as idPrep, pr.Международное_непатент_наименование as name, pr.Дозировка as doze, ip.дата_изготовления as `date`,
                            ip.Стоимость_за_единицу as cost, sp.количество as `count`, post.Дата_поставки as `date_post`
            FROM список_поставки sp 
            LEFT JOIN имеющиеся_препараты ip ON (sp.ID_им_препарата = ip.ID_им_препарата)
            LEFT JOIN препарат pr ON (ip.ID_Препарата = pr.ID_Препарата)
            LEFT JOIN поставка post ON (sp.ID_поставки = post.Id_поставки)
            where post.ID_Поставщика = '$id' ";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

public function readByIdPost($id){

    $query = "SELECT sp.ID_поставки as idPost, sp.ID_им_препарата as idPrep, pr.Международное_непатент_наименование as name, pr.Дозировка as doze, ip.дата_изготовления as `date`,
                            ip.Стоимость_за_единицу as cost, sp.количество as `count`, post.Дата_поставки as `date_post`
            FROM список_поставки sp 
            LEFT JOIN имеющиеся_препараты ip ON (sp.ID_им_препарата = ip.ID_им_препарата)
            LEFT JOIN препарат pr ON (ip.ID_Препарата = pr.ID_Препарата)
            LEFT JOIN поставка post ON (sp.ID_поставки = post.Id_поставки)
            where sp.ID_поставки = '$id' ";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();

    return $stmt;
}

    public function addToList(){
        $this->idPrep = $this->createPrepatatAndReturnHisId();
        if (!$this->idPrep){
            echo "Error: ";
            return false;
        }
         return $this->addPrepToListPost();

    }

    private function createPrepatatAndReturnHisId(){
        $sql = "INSERT INTO имеющиеся_препараты (ID_Препарата, Стоимость_за_единицу, дата_изготовления)
            VALUES ('$this->idAPrep', '$this->cost', '$this->dateIzg');";
        if ($this->conn->query($sql) == TRUE) {
            return $this->conn->lastInsertId();
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    private function addPrepToListPost(){
        $sql = "INSERT INTO список_поставки (ID_им_препарата, ID_поставки, количество)
            VALUES ('$this->idPrep', '$this->idPost', '$this->count');";
        if ($this->conn->query($sql) == TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
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
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }

    function delete()
    {
        $sql = "DELETE FROM список_поставки WHERE ID_поставки = '$this->idPost' AND ID_им_препарата = '$this->idPrep'";
        if ($this->conn->query($sql) == TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return false;
        }
    }


}