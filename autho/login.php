<?php

include("./conn.php");

$username =  $_POST['username']; 
$password = $_POST['password']; 
// $password = md5($password);



$sql = "SELECT `user_id`, `username`, `password` FROM `user_autho` WHERE username='$username' AND password ='$password' AND is_active=true;";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

  
    $user_id = $row['
    user_id'];

    $sql = "SELECT `token` FROM `tokens` WHERE user_id='$user_id';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 0) {
        //   $token = "tokeeeeeeeennnnnnnnn";
      $token = random_bytes(10);
        $sql = "INSERT INTO `tokens`(`user_id`, `token`) VALUES ('$user_id','$token');";
        $result = mysqli_query($conn, $sql);
    } else {
        $token_row = mysqli_fetch_assoc($result);
        $token = $token_row['token'];
    }

    $response = [
        "detail" => "Logged in successfully",
        "token" => $token,
        "username" => $row['username']
    ];
    http_response_code(200);
    echo json_encode($response);
    exit();
} else {
    $response = [
        "detail" => "Invalid username or password"  . mysqli_error($conn)
    ];
    http_response_code(404);
    echo json_encode($response);
    exit();
}

// $response = [
//     "detail" => "Invalid request or server error"
// ];
// http_response_code(400);
// echo json_encode($response);
?>