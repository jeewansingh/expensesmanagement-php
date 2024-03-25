<?php


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


?>