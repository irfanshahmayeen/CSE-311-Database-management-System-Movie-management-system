<?php
//session_start();

include '../connection.php';
include 'login.html';

if(isset($_POST['email'], $_POST['password'], $_POST['user_type'])) {

    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_type = $_POST['user_type'];  
    
    if($user_type === 'user'){

    $sql = "SELECT * FROM usersignup WHERE Email='$user_email' AND Password='$user_password' AND User_Type='$user_type'";
    }
    else if ($user_type==='admin'){
        $sql = "SELECT * FROM adminsignup WHERE Email='$user_email' AND Password='$user_password' AND User_Type='$user_type'";
    }

    $query = $conn->query($sql);

    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $user_full_name = $data['FullName'];
        $user_id = $data['UserID'];
        $user_email =$data['Email'];

        session_start();

        $_SESSION['user_email'] = $user_email;
        
        if($user_type === 'admin') {
            header("location:../movieadmin/AdminShowMovieList.php");
        } else if ($user_type === 'user'){
            header("location:../dashboard/user.php");
        }
        exit();
    } else {
        header("location:login.php"); // Redirect back to login page
        exit();
        

    }
}
?>
