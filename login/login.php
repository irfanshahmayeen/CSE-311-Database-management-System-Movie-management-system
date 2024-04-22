<?php

include '../connection.php';
include 'login.html';


if(isset($_POST['email'])){

    $user_email = $_POST['email'];
    $user_password = $_POST['password'];   

    $sql = "SELECT * FROM signup WHERE 
            Email='$user_email' AND Password = '$user_password'";

    $query = $conn->query($sql);

    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_array($query);
        $user_full_name = $data['FullName'];
        session_start();

        $_SESSION['user_full_name'] = $user_full_name;
        
       
       // header("location:../welcome/welcome.php");
       header("location:test.php");
    }
    
    else{
       header("location:login.php");
      // echo 'not ok';
    }
}


  

?>
