<?php
include("../conn.php");
include("../functions/requests.php");
include("../functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "POST";
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $token = $_GET['token'];

    // $sql = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
    $sql = "SELECT user_autho.user_id
    FROM user_autho
    INNER JOIN tokens
    ON user_autho.user_id = tokens.user_id WHERE token = '$token' AND is_active = true AND is_admin = true AND is_delete=false;";
    $result = mysqli_query($conn, $sql);

    $status = false;
    if (mysqli_num_rows($result) === 1 ) {
        // $row = mysqli_fetch_assoc($result);
        // $user_id = $row["user_id"];
        $status = true;
    }
    api_success_response(["status" => $status]);
}

?>