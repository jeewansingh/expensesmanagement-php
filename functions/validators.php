<?php

function post_data_validator(array $data) {
    $error = false;
    $errors = array();
    foreach ($data as $field ) {
        if (empty($_REQUEST[$field])) {
            $error = true;
            $errors[$field] = "$field is required.";
        }
    }
    if ($error) {
        api_error_response($errors);
    }
}

function get_value_or_null($data) {
    if (empty($_REQUEST[$data])) {
        return null;
    }
    return $data;
}

function validate_admin_token($token){
    if ($token == null) {
        api_error_response("Please provide token.");
    }
    $sql = "SELECT user_autho.is_admin FROM user_autho JOIN tokens ON tokens.user_id = user_autho.user_id WHERE tokens.token = '$token';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) != 1) {
        api_error_response("Invalid token");
    }
}


?>