<?php
header("Content-Type: application/json; charset=utf-8");

$name = "";
http_response_code(400);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_REQUEST['fname'];
    http_response_code(200);
}


$data = [
    "class" => [
        "grade" => 10,
        "section" => "A"
    ],
    "student" => $name
];


echo json_encode($data);

?>