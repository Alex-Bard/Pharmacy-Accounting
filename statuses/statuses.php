<?php

include_once '../db/db.php';
include_once 'Status.php';


$database = new Database();
$db = $database->getConnection();

$status = new Status($db);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $status->getAll();
    $num = $stmt->rowCount();


    if ($num > 0) {


        $postavshik_arr = array();
        $postavshik_arr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            $product_item = array(
                "id" => $id,
                "name" => $name,
            );

            array_push($postavshik_arr, $product_item);
        }

        http_response_code(200);

        echo json_encode($postavshik_arr);
    }
    else {

        http_response_code(404);

        echo json_encode(array("message" => "Состояния не найдены."), JSON_UNESCAPED_UNICODE);
    }
}