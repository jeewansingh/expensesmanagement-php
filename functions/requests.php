<?php

// $token = isset($_GET["token"]) ? $_GET["token"] : null;
// if ($token == null) {
//     api_error_response("Token required.");
// }
// $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
// $result = mysqli_query($conn, $sql_token);

// if (mysqli_num_rows($result) === 1) {
//     $row = mysqli_fetch_assoc($result);
//     $GLOBALS["user_id"] = $row["user_id"];
// } else {
//     api_error_response("Invalid Credentials.");
// }

function api_success_response($data) {
    if (is_string($data)) {
        $data =  [
            "detail" => $data
        ];
    }
    http_response_code(200);
    echo json_encode($data);
    exit();
}

function api_error_response($data) {
    if (is_string($data)) {
        $data =  [
            "detail" => $data
        ];
    }
    http_response_code(400);
    echo json_encode($data);
    exit();
}

function api_nodata_response($data) {
    if (is_string($data)) {
        $data =  [
            "detail" => $data
        ];
    }
    http_response_code(200);
    echo json_encode($data);
    exit();
}


function request_get($key, $default=null) {
    if (isset($_REQUEST[$key]) && !empty(($_REQUEST[$key]))) {
        return $_REQUEST[$key];
      }
    return $default;
}

?>