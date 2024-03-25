<?php
include("./conn.php");
include("functions/requests.php");
include("functions/validators.php");



if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $token = $_GET['token'];

  $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
  $result = mysqli_query($conn, $sql_token);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];

  $limit = 4;
  
  $sql = "SELECT * FROM `transaction` WHERE user_id='$user_id' ORDER BY txn_id DESC LIMIT $limit;";

  $result = mysqli_query($conn,$sql);  

  if (mysqli_num_rows($result) >= 1) {
    $response = array();
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($response, $row);
    }
    $response = [
      "data" => $response
    ];
    api_success_response($response);
  } else {
      api_error_response("No data found.");
  }
  }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "post";
} else if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    echo "patch";
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
     echo "delete";
} else {
     echo "request method not accepted";
}





  $conn->close();
?>
