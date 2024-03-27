<?php

include("./conn.php");
include("functions/requests.php");

$username =  $_POST['username']; 
$password = $_POST['password']; 
if (empty($username) && empty($password)){
    api_error_response("Username and Password required");
}

if (empty($username)){
    api_error_response("Username Required");
}
if (empty($password)){
    api_error_response("Password Required");
}
$password = md5($password);


$sql = "SELECT `user_id`, `username`, `password` FROM `user_autho` WHERE username='$username' AND password='$password' AND is_active=true;";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];

    $sql = "SELECT `token` FROM `tokens` WHERE user_id='$user_id';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 0) {
        $token = uniqid();
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
    api_success_response($response);
} else {
    api_error_response("Invalid username or password.");

}

?>