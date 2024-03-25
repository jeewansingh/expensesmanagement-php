<?php
include("./conn.php");
include("functions/requests.php");
include("functions/validators.php");


$date = $_POST['date'];
$title = $_POST['title'];
$amount = $_POST['amount'];
$remark = $_POST['remark'];
$description = $_POST['desc'];
$category = $_POST['category'];
$user_id = $_POST['user_id'];
$txn_id = $_POST['txn_id'];


$sql= "UPDATE `transaction` SET `title`='$title',`description`='$description',`amount`='$amount',`date`='$date',`remark`='$remark' WHERE txn_id='$txn_id'";

if ($conn->query($sql) === TRUE) {
    api_success_response("Item Updated Successfully");
  } else {
   api_error_response("Error: " . $sql . "<br>" . $conn->error);
  }
?>
