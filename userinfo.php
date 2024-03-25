<?php
include("./conn.php");
include("functions/requests.php");
include("functions/validators.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "POST";
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $token = $_GET['token'];

  $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
  $result = mysqli_query($conn, $sql_token);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];

    $sql = " SELECT `user_id`,`name`, `username`, `password`, `is_active`, `date_created` FROM `user_autho` WHERE user_id='$user_id' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $username = $row['username'];
        $is_active = $row['is_active'];
        $date = $row['date_created'];
        $user_id = $row['user_id'];
    
        $response = [
        "name" => $name,
        "username" => $username,
        "status" => $is_active,
        "date" => $date,
        "user_id" => $user_id,
        ];
        api_success_response($response);
        exit();
    } else {
        api_error_response("Not Found");
    }
} else {
    api_error_response("Not Found");
}
} else if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
   
    $username = $_GET["username"];
    $name = $_GET["name"];

    $sql= "UPDATE `user_autho` SET `name`='$name' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        api_success_response("Item Updated Successfully");
    } else {
       api_error_response("Error: " . $sql . "<br>" . $conn->error);
    }



} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
     echo "delete";
} else {
     echo "request method not accepted";
}

  $conn->close();
  
// include("./conn.php");

// $username =  $_POST['username']; 

// $sql = " SELECT `user_id`,`name`, `username`, `password`, `is_active`, `date_created` FROM `user_autho` WHERE username='$username' ";
// $result = mysqli_query($conn, $sql);


// if (mysqli_num_rows($result) === 1) {
//     $row = mysqli_fetch_assoc($result);
//     $name = $row['name'];
//     $username = $row['username'];
//     $is_active = $row['is_active'];
//     $date = $row['date_created'];
//     $user_id = $row['user_id'];
    
//     $response = [
//         "name" => $name,
//         "username" => $username,
//         "status" => $is_active,
//         "date" => $date,
//         "user_id" => $user_id,
//     ];
//     http_response_code(200);
//     echo json_encode($response);
//     exit();
// } else {
//     $response = [
//         "detail" => "Not Found"
//     ];
// }
// 


?>
