<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../db/db.php';
include_once 'Preparat.php';

$database = new Database();
$db = $database->getConnection();


$preparat = new Preparat($db);
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {

        $stmt = $preparat->read();
        $num = $stmt->rowCount();


        if ($num > 0) {


            $postavshik_arr = array();
            $postavshik_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $product_item = array(
                    "id" => $id,
                    "name" => $name,
                    "doz" => $doz,
                    "date" => $date,
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