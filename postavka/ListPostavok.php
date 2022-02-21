<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db/db.php';
include_once 'ListPostavki.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$listPostavki = new ListPostavki($db);


if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $listPostavki->readByIdPostav($id);
        $num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
        if ($num > 0) {

            // массив товаров
            $postavshik_arr = array();
            $postavshik_arr = array();

            // получаем содержимое нашей таблицы
            // fetch() быстрее, чем fetchAll()
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //echo json_encode($row);
                // извлекаем строку
                extract($row);

                $product_item = array(
                    "name" => $name,
                    "idPost" => $idPost,
                    "idPrep" => $idPrep,
                    "count" => $count,
                    "cost" => $cost,
                    "dateIzg" => $date,
                    "doze" => $doze,
                    "date_post"=>$date_post,
                );

               // array_push($postavshik_arr, $product_item);
                array_push($postavshik_arr, $row);
            }

            // устанавливаем код ответа - 200 OK
            http_response_code(200);

            // выводим данные о товаре в формате JSON
            echo json_encode($postavshik_arr);
        } else {

            // установим код ответа - 404 Не найдено
            http_response_code(404);

            // сообщаем пользователю, что товары не найдены
            echo json_encode(array("message" => "Поставщики не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }
    elseif (isset($_GET['id_postavki'])) {
        $id = (int)$_GET['id_postavki'];
        $stmt = $listPostavki->readByIdPost($id);
        $num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
        if ($num > 0) {

            // массив товаров
            $postavshik_arr = array();
            $postavshik_arr = array();

            // получаем содержимое нашей таблицы
            // fetch() быстрее, чем fetchAll()
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                // извлекаем строку
                extract($row);

                $product_item = array(
                    "name" => $name,
                    "idPost" => $idPost,
                    "idPrep" => $idPrep,
                    "count" => $count,
                    "cost" => $cost,
                    "dateIzg" => $date,
                    "doze" => $doze,
                    "date_post"=>$date_post,
                );

                array_push($postavshik_arr, $product_item);
            }

            // устанавливаем код ответа - 200 OK
            http_response_code(200);

            // выводим данные о товаре в формате JSON
            echo json_encode($postavshik_arr);
        } else {

            // установим код ответа - 404 Не найдено
            http_response_code(404);

            // сообщаем пользователю, что товары не найдены
            echo json_encode(array("message" => "Поставщики не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }
    else{
        $stmt = $listPostavki->read();
        $num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
        if ($num > 0) {

            // массив товаров
            $postavshik_arr = array();
            $postavshik_arr = array();

            // получаем содержимое нашей таблицы
            // fetch() быстрее, чем fetchAll()
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                // извлекаем строку
                extract($row);

                $product_item = array(
                    "name" => $name,
                    "idPost" => $idPost,
                    "idPrep" => $idPrep,
                    "count" => $count,
                    "cost" => $cost,
                    "dateIzg" => $date,
                    "doze" => $doze,
                    "date_post"=>$date_post,
                );

                array_push($postavshik_arr, $product_item);
            }

            // устанавливаем код ответа - 200 OK
            http_response_code(200);

            // выводим данные о товаре в формате JSON
            echo json_encode($postavshik_arr);
        } else {

            // установим код ответа - 404 Не найдено
            http_response_code(404);

            // сообщаем пользователю, что товары не найдены
            echo json_encode(array("message" => "Поставщики не найдены."), JSON_UNESCAPED_UNICODE);
        }
    }



} elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->aPreparatId) &&
        !empty($data->count) &&
        !empty($data->cost) &&
        !empty($data->idPost) &&
        !empty($data->date)) {

        $listPostavki->idAPrep = (int)$data->aPreparatId;
        $listPostavki->count = $data->count;
        $listPostavki->cost = $data->cost;
        $listPostavki->dateIzg = $data->date;
        $listPostavki->idPost = $data->idPost;

        if ($listPostavki->addToList()) {
            http_response_code(201);

        } else {
            http_response_code(503);
        }
    } else {
        http_response_code(400);
    }
}
//elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
//    $data = json_decode(file_get_contents("php://input"));
//    if (!empty($data->id)) {
//        $postavshik->id = (int)$data->id;
//        if ($postavshik->delete()) {
//            http_response_code(201);
//        } else {
//            http_response_code(503);
//        }
//    } else {
//        http_response_code(400);
//    }
//}elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
//    $data = json_decode(file_get_contents("php://input"));
//    if (!empty($data->name) &&
//        !empty($data->phone) &&
//        !empty($data->adress) &&
//        !empty($data->country)) {
//
//        $postavshik->name = $data->name;
//        $postavshik->phone = $data->phone;
//        $postavshik->adress = $data->adress;
//        $postavshik->country = $data->country;
//
//        if ($postavshik->create()) {
//            http_response_code(201);
//        } else {
//            http_response_code(503);
//        }
//    } else {
//        http_response_code(400);
//    }

elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->idPost) &&
        !empty($data->idPrep)) {
        $listPostavki->idPost = (int) $data->idPost;
        $listPostavki->idPrep = (int) $data->idPrep;
        if ($listPostavki->delete()) {
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