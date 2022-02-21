<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db/db.php';
include_once 'postavshik.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();


$postavshik = new Postavshik($db);
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $postavshik->readById($id);
        $num = $stmt->rowCount();

        if ($num > 0) {

            $postavshik_arr = array();
            $postavshik_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $product_item = array(
                    "id" => $id,
                    "name" => $name,
                    "adress" => $adress,
                    "phone" => $phone,
                    "country" => $country,
                );

                array_push($postavshik_arr, $product_item);
            }

            http_response_code(200);
            echo json_encode($postavshik_arr);
        }
        else {

            http_response_code(404);

            echo json_encode(array("message" => "Поставщики не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }
    elseif (isset($_GET['post_name'])) {


        $stmt = $postavshik->read("sortAndSearch",$_GET['sort'] , $_GET['post_name']);
        $num = $stmt->rowCount();

        if ($num > 0) {

            // массив товаров
            $postavshik_arr = array();
            $postavshik_arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $product_item = array(
                    "id" => $id,
                    "name" => $name,
                    "adress" => $adress,
                    "phone" => $phone,
                    "country" => $country,
                );

                array_push($postavshik_arr, $product_item);
            }
            http_response_code(200);
            echo json_encode($postavshik_arr);
        }
        else {
            http_response_code(404);
            echo json_encode(array("message" => "Поставщики не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }
    else {
        $stmt = $postavshik->read("sortOnly",$_GET['sort'] , 0);
        $num = $stmt->rowCount();

        if ($num > 0) {

            $postavshik_arr = array();
            $postavshik_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                // извлекаем строку
                extract($row);

                $product_item = array(
                    "id" => $id,
                    "name" => $name,
                    "adress" => $adress,
                    "phone" => $phone,
                    "country" => $country,
                );

                array_push($postavshik_arr, $product_item);
            }
            http_response_code(200);
            echo json_encode($postavshik_arr);
        }
        else {
            http_response_code(404);
            echo json_encode(array("message" => "Поставщики не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }
}



elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $data = $data[0];
    if (!empty($data->name) &&
        !empty($data->id) &&
        !empty($data->phone) &&
        !empty($data->adress) &&
        !empty($data->country)) {

        $postavshik->id = (int) $data->id;
        $postavshik->name = $data->name;
        $postavshik->phone = $data->phone;
        $postavshik->adress = $data->adress;
        $postavshik->country = $data->country;

        if ($postavshik->change()) {
            http_response_code(201);

        }
        else {
            http_response_code(503);
        }
    }
    else {
        http_response_code(400);
    }
}

elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id)) {
        $postavshik->id = (int) $data->id;
        if ($postavshik->delete()) {
            http_response_code(201);
        }
        else{
            http_response_code(503);
        }
    }
    else{
        http_response_code(400);
    }
}

elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->name) &&
        !empty($data->phone) &&
        !empty($data->adress) &&
        !empty($data->country)) {

    $postavshik->name = $data->name;
    $postavshik->phone = $data->phone;
    $postavshik->adress = $data->adress;
    $postavshik->country = $data->country;

        if ($postavshik->create()) {
            http_response_code(201);
        }
        else {
            http_response_code(503);
        }
    }
    else {
        http_response_code(400);
    }
}