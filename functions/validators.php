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


?>