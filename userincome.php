<?php
include("./conn.php");
include("functions/requests.php");
include("functions/validators.php");


if ($_SERVER["REQUEST_METHOD"] == "GET") {
  
  // $category = request_get("category", "");
  // $search = request_get("search", "");
  // $start_date = request_get("start_date", "1920-01-01");
  // $end_date = request_get("end_date", "2080-01-01");
  // $sort = request_get("sort", "txn_id");

  // $page_count_sql = "SELECT COUNT(txn_id) as total FROM `transaction` WHERE category='$category' AND user_id='$user_id'  AND (title LIKE '%$search%'OR description LIKE '%$search%')  AND date BETWEEN '$start_date' AND '$end_date' ;";
  // // $sql = "SELECT * FROM `transaction` WHERE category='$category' AND user_id='$user_id' AND (title LIKE '%$search%' OR description LIKE '%$search%') AND date BETWEEN '$start_date' AND '$end_date' ORDER BY txn_id DESC LIMIT $limit OFFSET $offset;";
  // $sql = "SELECT * FROM `transaction` WHERE category='$category' AND user_id='$user_id' AND (title LIKE '%$search%' OR description LIKE '%$search%') AND date BETWEEN '$start_date' AND '$end_date' ORDER BY $sort DESC LIMIT $limit OFFSET $offset;";

  $category = $_GET['category'];
  $token = $_GET['token'];

  $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
  $result = mysqli_query($conn, $sql_token);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];

  $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
  $limit = 5;
  $offset = ($page - 1) * $limit;

  $search_string = " ";
  if (isset($_GET["search"])) {
    $search_string = $_GET["search"];
  }

  $from = "1920-01-01";
  $from_date = date("Ymd", strtotime($from));
  $to = "2080-01-01";
  $to_date = date("Ymd", strtotime($to));

  if (isset($_GET["from"]) && isset($_GET["to"])){
    $from_date = $_GET["from"];
    $to_date = $_GET["to"];
  }
  
  $sort = "txn_id";
  if (isset($_GET["sort"]) && !empty(($_GET["sort"]))) {
    $sort = $_GET["sort"];
  }

  $page_count_sql = "SELECT COUNT(txn_id) as total FROM `transaction` WHERE category='$category' AND user_id='$user_id'  AND (title LIKE '%$search_string%'OR description LIKE '%$search_string%')  AND date BETWEEN '$from_date' AND '$to_date' ;";
  // $sql = "SELECT * FROM `transaction` WHERE category='$category' AND user_id='$user_id' AND (title LIKE '%$search_string%' OR description LIKE '%$search_string%') AND date BETWEEN '$from_date' AND '$to_date' ORDER BY txn_id DESC LIMIT $limit OFFSET $offset;";
  $sql = "SELECT * FROM `transaction` WHERE category='$category' AND user_id='$user_id' AND (title LIKE '%$search_string%' OR description LIKE '%$search_string%') AND date BETWEEN '$from_date' AND '$to_date' ORDER BY $sort DESC LIMIT $limit OFFSET $offset;";

  $page_count_result = mysqli_query($conn, $page_count_sql);
  $page_count_data = mysqli_fetch_assoc($page_count_result);
  $result = mysqli_query($conn,$sql);  

  if (mysqli_num_rows($result) >= 1) {
    $response = array();
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($response, $row);
    }
    $paginated_response = [
      "total_page" => ceil((int)$page_count_data["total"]/$limit),
      "current_page" => $page,
      "data" => $response
    ];
    api_success_response($paginated_response);
  } else {
    api_error_response("No data found.");
  }
}

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // $header = $_SERVER['HTTP_token'];
  // $sql_token = "SELECT `user_id`,FROM `tokens` WHERE token ='$header' ";
  // $result = mysqli_query($conn, $sql_token);

  // if (mysqli_num_rows($result) >= 1) {
  //   $row = mysqli_fetch_assoc($result);
  //   // $user_id = $row["user_id"];
  // }

  post_data_validator(["title", "date", "amount", "desc"]);


  $header = $_POST['token'];
  $date = $_POST['date'];
  $title = $_POST['title'];
  $amount = $_POST['amount'];
  $remark = $_POST[get_value_or_null("remark")];
  $desc = $_POST['desc'];
  $category = $_POST['category'];
  // $user_id = $_POST['user_id'];
  // $user_id = 2;

  $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$header' ";
  $result = mysqli_query($conn, $sql_token);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];


  $sql = "INSERT INTO `transaction`(`title`, `user_id`, `description`, `amount`, `date`, `remark`, `category`) VALUES ('$title', '$user_id','$desc','$amount','$date','$remark', '$category')";

  if ($conn->query($sql) === TRUE) {
    api_success_response("Item Added Successfully");
  } else {
  api_error_response("Error: " . $sql . "<br>" . $conn->error);
  }
}
} else if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
  echo "patch";
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {


  $token = $_GET['token'];

  $sql_token = "SELECT `user_id` FROM `tokens` WHERE token ='$token' ";
  $result = mysqli_query($conn, $sql_token);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["user_id"];


  $txn_id = $_GET['txn_id'];

  $sql_title ="SELECT title FROM `transaction` WHERE txn_id='$txn_id'";

  $row = mysqli_fetch_assoc(mysqli_query($conn, $sql_title));
  $title = $row['title'];

  $sql = "DELETE FROM `transaction` WHERE txn_id='$txn_id' AND user_id='$user_id';";
  
  if ($conn->query($sql) === TRUE) {
    api_success_response("$title Deleted Sucessfully ");
  }
  else {
      api_error_response("Error: " . $sql . "<br>". $conn->error);
    }
  }  else {
    api_error_response("Error");
  }
} else {
  echo "request method not accepted";
}





  $conn->close();
?>
