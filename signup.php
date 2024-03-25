<?php

include("./conn.php");

$name = $_POST['name']; 
$username =  $_POST['username']; 
$password = $_POST['password'];
 $password = md5($password); 


// $user = User($username, $password);
// try {
//   $user->save();
// } catch (Exception $e) {
//   echo ''. $e->getMessage();
// }


$sql = "INSERT INTO `user_autho`( `name`, `username`, `password`) VALUES ('$name','$username','$password')";
// $sql1 = "SELECT `username`, `password` FROM `user_autho` WHERE username='$username' AND password ='$password';";

if ($conn->query($sql) === TRUE) {
  http_response_code(200);
  echo "Sign up successful, Please login to proceed.";
} else {
  http_response_code(400);
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
