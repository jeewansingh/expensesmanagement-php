<?php

include("./conn.php");
include("functions/requests.php");
include("functions/tokenvalidate.php");
include("functions/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $token = $_GET['token'];

    $user_id = $GLOBALS["user_id"];

    $sql = " SELECT
    user_autho.user_id,
    username,
    COALESCE(SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END), 0) AS TotalIncome,
    COALESCE(SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END), 0) AS TotalExpense,
    COALESCE(SUM(CASE WHEN category = 'receivable-debts' THEN amount ELSE 0 END), 0) AS TotalReceive,
    COALESCE(SUM(CASE WHEN category = 'payable-debts' THEN amount ELSE 0 END), 0) AS TotalPay,
    COALESCE((SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END) + SUM(CASE WHEN category = 'receivable-debts' THEN amount ELSE 0 END)) - (SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END) + SUM(CASE WHEN category = 'payable-debts' THEN amount ELSE 0 END)), 0) AS TotalBalance,
    COALESCE(SUM(CASE WHEN category = 'income' THEN amount ELSE 0 END), 0) - COALESCE(SUM(CASE WHEN category = 'expense' THEN amount ELSE 0 END), 0) AS TotalSaving
    FROM transaction
    INNER JOIN user_autho ON transaction.user_id = user_autho.user_id
    WHERE user_autho.user_id = $user_id;";


    $sql2 = "SELECT
    user_autho.user_id,
    username,
    COALESCE(SUM(CASE WHEN category = 'income' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND date <= CURDATE() THEN amount ELSE 0 END), 0) AS Income7Day,
    COALESCE(SUM(CASE WHEN category = 'expense' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND date <= CURDATE() THEN amount ELSE 0 END), 0) AS Expense7Day,
    COALESCE(SUM(CASE WHEN category = 'income' AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND date <= CURDATE() THEN amount ELSE 0 END), 0) AS Income30Day,
    COALESCE(SUM(CASE WHEN category = 'expense' AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND date <= CURDATE() THEN amount ELSE 0 END), 0) AS Expense30Day
    FROM transaction
    INNER JOIN user_autho ON transaction.user_id = user_autho.user_id
    WHERE user_autho.user_id = $user_id;";

    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_array($result);
        $row2 = mysqli_fetch_array($result2);
        $totalincome = $row["TotalIncome"];   
        $totalexpense = $row["TotalExpense"];   
        $totalreceive = $row["TotalReceive"];   
        $totalpay = $row["TotalPay"];
        $totalbalance = $row["TotalBalance"];   
        $totalsaving = $row["TotalSaving"];
        $Income7Day = $row2["Income7Day"];
        $Expense7Day = $row2['Expense7Day'];
        $Income30Day = $row2['Income30Day'];
        $Expense30Day = $row2['Expense30Day'];
        $response =[
        "status"=> "success",
        "totalBalance"=> $totalbalance,
        "totalSaving" => $totalsaving,
        "totalIncome" => $totalincome,
        "totalExpense" => $totalexpense,
        "totalReceive"=> $totalreceive,
        "totalPay"=> $totalpay,
        "income7day" => $Income7Day,
        "expense7day" => $Expense7Day,
        "income30day" => $Income30Day,
        "expense30day" => $Expense30Day
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