<?php
include ("../conn.php");
include ("../functions/requests.php");
include("../functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT  `name`, `username`, `is_active`, `date_created`, `is_admin` FROM `user_autho`";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) >= 1) {
        $response = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($response, $row);
        }
        $user_data = [
            "data" => $response
        ];
        api_success_response($user_data);
    } else {
        api_error_response("No data found.");
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}


?>