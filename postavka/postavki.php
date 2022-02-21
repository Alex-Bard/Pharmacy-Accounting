<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db/db.php';
include_once 'Postavka.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$postavka = new Postavka($db);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
$data = json_decode(file_get_contents("php://input"));
$data = $data;
if (!empty($data->docNum) &&
    !empty($data->date) &&
    !empty($data->postId) &&
    !empty($data->statusId)) {

    $postavka->docNum = $data->docNum;
    $postavka->date = $data->date;
    $postavka->postId =(int) $data->postId;
    $postavka->statusId =(int) $data->statusId;

    $id = 0;

    if ($id = $postavka->create()) {
        http_response_code(201);
        $product_item = array(
            "idPost" => $id,
        );
        http_response_code(201);
        echo json_encode($product_item);

    }
    else {
        http_response_code(503);
    }
}
else {
    http_response_code(400);
}
}