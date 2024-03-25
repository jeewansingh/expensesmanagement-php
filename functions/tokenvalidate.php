<?php
$token = $_GET['token'];
$sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
$result = mysqli_query($conn, $sql_token);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $GLOBALS["user_id"] = $row["user_id"];
} else {
    api_error_response("Invalid Credentials.");
}

?>
