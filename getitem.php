<?php
include("./conn.php");

$sql = "SELECT * FROM `transaction` WHERE category='income'";
$result = mysqli_query($conn,$sql);  

if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_assoc($result);
    $txn_id = $row['txn_id'];
    $title = $row['title'];
    $description = $row['description'];
    $date = $row['date'];
    $remark = $row['remark'];
    $amount = $row['amount'];
    
    $response = [
        "txn_id" => $txn_id,
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
?>