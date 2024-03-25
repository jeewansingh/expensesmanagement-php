<?php

include("./conn.php");

$username = $_GET["username"];

$sql = "SELECT * FROM `user_autho` WHERE username='$username';";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0){
    http_response_code(400);
    echo json_encode(["detail" => "Username not available"]);
} else {
    http_response_code(200);
    echo json_encode(["detail" => "Username available"]);
}

?>