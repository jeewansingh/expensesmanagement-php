<?php
include ("../conn.php");
include ("../functions/requests.php");
include("../functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT  `user_id`, `name`, `username`, `is_active`, `date_created`, `is_admin` FROM `user_autho` WHERE  is_delete=false";
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
    $token = $_GET['token'];

    $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
    $result = mysqli_query($conn, $sql_token);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $admin_id = $row["user_id"];
    }

    $user_id = $_GET['user_id'];
    
    if ($user_id == $admin_id){
        api_error_response("You can not delete yourself");
    } else {
        $sql = "DELETE FROM `user_autho` WHERE user_id='$user_id';";
    if ($conn->query($sql) === TRUE) {
        api_success_response("Deleted Sucessfully ");
    }
    else {
        api_error_response("Error: " . $sql . "<br>". $conn->error);
    }
    }
}

?>