<?php
include("../conn.php");


class User {
    public $id;
    public $username;
    public $password;
    public $created_at;

    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    public static function get( $id ){
        $sql = "SELECT *  FROM USERS WHERE ID = ". $this->id ."";
        $result = mysqli_query($this->link,$sql);
        $row = mysqli_fetch_array($result);
        $user = new self($row[""],$row[""],$row[])

    }


    public function save(){
        $sql = "INSERT INTO `users`(`username`, `password`) VALUES ('$this->username','$this->password')";
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }

        }

}



?>