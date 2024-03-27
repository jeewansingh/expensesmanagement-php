<?php
include ("../conn.php");
include ("../functions/requests.php");
include("../functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT 
    TotalUser.totalUser,
    TotalActiveUser.totalActiveUser,
    TotalAdmin.totalAdmin,
    TotalTxn.totalTxn
FROM 
    (SELECT COUNT(user_id) AS totalUser FROM user_autho) AS totalUser
CROSS JOIN
    (SELECT COUNT(user_id) AS totalActiveUser FROM user_autho WHERE is_active = true) AS totalActiveUser
CROSS JOIN
    (SELECT COUNT(user_id) AS totalAdmin FROM user_autho WHERE is_admin = true) AS totalAdmin
CROSS JOIN
    (SELECT COUNT(txn_id) AS totalTxn FROM transaction) AS totalTxn;
";
    $result = mysqli_query($conn, $sql);

   

    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        $totalUser = $row['totalUser'];
        $totalActiveUser = $row['totalActiveUser'];
        $totalAdmin = $row['totalAdmin'];
        $totalTxn = $row['totalTxn'];
        $response = [
            "totalUser" => $totalUser,
            "totalActiveUser" => $totalActiveUser,
            "totalAdmin" => $totalAdmin,
            "totalTxn" => $totalTxn
        ];
        api_success_response($response);
    } else {
        api_error_response("No data found.");
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}

?>