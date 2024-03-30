<?php
include ("../conn.php");
include ("../functions/requests.php");
include("../functions/validators.php");

$token = request_get("token");
if ($token == null) {
    api_error_response("Please provide token.");
}
$sql = "SELECT user_autho.is_admin FROM user_autho JOIN tokens ON tokens.user_id = user_autho.user_id WHERE tokens.token = '$token';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) != 1) {
    api_error_response("Invalid token");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = request_get("user_id");
    if ($user_id == null) {
        api_error_response("Invalid user ID.");
    }

    $make_admin_sql = "UPDATE user_autho SET `is_admin` = CASE WHEN `is_admin` = 0 THEN 1 ELSE 0 END WHERE `user_id`= $user_id;";
    $make_admin_result = mysqli_query($conn, $make_admin_sql);

    if ($make_admin_result) {
        
        api_success_response("Admin Toggled.");
    } else {
        api_error_response("Unknown error occurred.");
    }
} 
else if ($_SERVER["REQUEST_METHOD"] == "PATCH") {

}

api_error_response("Request method not allowed.", 405);

