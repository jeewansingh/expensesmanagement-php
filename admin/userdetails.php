<?php
include ("../conn.php");
include ("../functions/requests.php");
include("../functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = request_get("user_id");
    try {
        if (is_numeric($user_id)) {
            $user_id = (int)$user_id;
            if ($user_id == 0){
                throw new Exception("Invalid");
            }
        } else {
            throw new Exception("Invalid");
        }
    } catch(Exception $exc) {
        api_error_response("Invalid user ID.");
    }
    $user_query_sql= "SELECT `name`, `username`, `is_active`, `date_created`, `is_admin` FROM `user_autho` WHERE user_id= $user_id";
    $user_query_result = mysqli_query($conn, $user_query_sql);
    
    if (mysqli_num_rows($user_query_result) == 1) {
        $userresposne = mysqli_fetch_assoc($user_query_result);
    } else {
        api_error_response("User not found.");
    }

    $txn_query_sql = "SELECT  * FROM `transaction` WHERE user_id = $user_id ORDER BY txn_id DESC";
    $txn_query_result = mysqli_query($conn, $txn_query_sql);

    $response = array();
    if (mysqli_num_rows($txn_query_result) >= 1) {
        while ($row = mysqli_fetch_assoc($txn_query_result)) {
            array_push($response, $row);
        }
    }

    $user_data = [
        "user" => $userresposne,
        "data" => $response
        
    ];
    api_success_response($user_data);
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
}
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
   
}

?>