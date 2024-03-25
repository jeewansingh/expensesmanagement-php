<?php
include("../conn.php");

function authenticate($token) {
    $sql = "select * from token where token = token";
    $result = mysqli_query($GLOBALS["conn"], $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row["user id"];

        $user = new User::get("id", $user_id);


        $user->username;
    return $user;
}





?>