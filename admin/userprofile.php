<?php
include ("../conn.php");
include ("../functions/requests.php");
include("../functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET['user_id'];
    $sql = "SELECT  * FROM `user_autho` WHERE user_id = $user_id ORDER BY txn_id DESC";
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
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
}
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   
}

?>