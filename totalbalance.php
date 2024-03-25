<?php

include("./conn.php");
include("functions/requests.php");
include("functions/tokenvalidate.php");
include("functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $token = $_GET['token'];

    $user_id = $GLOBALS["user_id"];
        // $sql = "SELECT user_autho.user_id, username, SUM(amount) AS Total FROM transaction INNER JOIN user_autho WHERE user_autho.user_id = '$user_id' AND category = '$category';";
    $sql = "
    SELECT
    user_autho.user_id,
    username,
    COALESCE(SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END), 0) AS TotalIncome,
    COALESCE(SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END), 0) AS TotalExpense,
    COALESCE(SUM(CASE WHEN category = 'receivable-debts' THEN amount ELSE 0 END), 0) AS TotalReceive,
    COALESCE(SUM(CASE WHEN category = 'payable-debts' THEN amount ELSE 0 END), 0) AS TotalPay,
    COALESCE((SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END) + SUM(CASE WHEN category = 'receivable-debts' THEN amount ELSE 0 END)) - (SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END) + SUM(CASE WHEN category = 'payable-debts' THEN amount ELSE 0 END)), 0) AS TotalBalance,
    SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END) - SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END) AS TotalSaving
    FROM transaction INNER JOIN user_autho ON transaction.user_id = user_autho.user_id
    WHERE user_autho.user_id = $user_id;";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $totalincome = $row["TotalIncome"];   
        $totalexpense = $row["TotalExpense"];   
        $totalreceive = $row["TotalReceive"];   
        $totalpay = $row["TotalPay"];
        $totalbalance = $row["TotalBalance"];   
        $totalsaving = $row["TotalSaving"];
        $response =[
        "status"=> "success",
        "totalBalance"=> $totalbalance,
        "totalSaving" => $totalsaving,
        "totalIncome" => $totalincome,
        "totalExpense" => $totalexpense,
        "totalReceive"=> $totalreceive,
        "totalPay"=> $totalpay 
        ];
            api_success_response($response);
        } else {
            api_error_response("No Data Found");
        }

   
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {}
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {}
else if ($_SERVER["REQUEST_METHOD"] == "PATCH") {}
else {
    echo "Requestes method is not accepted.";
}
?>