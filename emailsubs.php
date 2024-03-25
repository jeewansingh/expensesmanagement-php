<?php
include("./conn.php");

$email =  $_POST['email'];

$sql = "INSERT INTO `email_collect`(`email`) VALUES ('$email');";

if ($conn->query($sql) === TRUE) {
   
    $response = [
        "detail" => "Subscribed Sucessfully"];
        http_response_code(200);
        echo json_encode($response);
        exit();
    
  } else {
    $response = [
        "detail" => "Failed"
    ];
    http_response_code(404);
    echo json_encode($response);
    exit();
  }
?>