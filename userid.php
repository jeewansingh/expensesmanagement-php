<?php

include("./conn.php");

$token =  $_POST['token']; 
$sql = "SELECT `user_id`, `token` FROM `tokens` WHERE token='$token' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $token = $row['token'];
    $user_id = $row['user_id'];
    $response = [
        "token" => $token,
        "user_id" => $user_id,

    ];
    http_response_code(200);
    echo json_encode($response);
    exit();
} else {
    $response = [
        "detail" => "Not Found"
    ];
}

?>