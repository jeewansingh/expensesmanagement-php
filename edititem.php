<?php
include("./conn.php");

$txn_id = $_GET['txn_id'];
$token = $_GET['token'];

  $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
  $result = mysqli_query($conn, $sql_token);

if (mysqli_num_rows($result) === 1) {
  $row = mysqli_fetch_assoc($result);
  $user_id = $row["user_id"];

$sql = "SELECT * FROM `transaction` WHERE txn_id='$txn_id' AND user_id='$user_id'";
$result = mysqli_query($conn,$sql);  

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $title = $row['title'];
    $description = $row['description'];
    $date = $row['date'];
    $remark = $row['remark'];
    $amount = $row['amount'];
    
    $response = [
        "title" => $title,
        "description" => $description,
        "amount"=> $amount, 
        "remark"=> $remark,
        "date" => $date,
    ];
    http_response_code(200);
    echo json_encode($response);
    exit();
} else {
    $response = [
        "detail" => "Not Found"
    ];
}
}
?>
