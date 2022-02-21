<?php

include_once '../db/db.php';
include_once 'Status.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

$status = new Status($db);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $status->getAll();
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
                "id" => $id,
                "name" => $name,
            );

            array_push($postavshik_arr, $product_item);
        }

        // устанавливаем код ответа - 200 OK
        http_response_code(200);

        // выводим данные о товаре в формате JSON
        echo json_encode($postavshik_arr);
    }
    else {

        // установим код ответа - 404 Не найдено
        http_response_code(404);

        // сообщаем пользователю, что товары не найдены
        echo json_encode(array("message" => "Состояния не найдены."), JSON_UNESCAPED_UNICODE);
    }
}