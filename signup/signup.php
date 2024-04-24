
<?php
include '../connection.php';
include 'signup.html';

?>  


<?php
 
     

// Process signup form data
if (isset($_POST['email'])) {
    $fullname = $_POST["fullname"];
    
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $user_type = $_POST['user_type'];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    //checking is the any duplicate email or phone number or user id 
    $checkUser = "SELECT * FROM signup 
                WHERE Email = '$email' OR Phone = '$phone'  ";
    $result  = mysqli_query($conn,$checkUser);
    $count   = mysqli_num_rows($result);

    if($count>0){
        echo '<script>alert("user Already sign up using this Phone Number Or Email.")</script>'; 
       // echo "user Already sign up using this Phone Number Or Email.";
       // header("location:signup:.html");
    }
    else{


    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.')</script>";
        echo "<script>window.location.href = 'signup.html';</script>";
        exit;
    }
    

    // Construct SQL query
    $sql = "INSERT INTO signup ( FullName,  Email, Phone, DOB, Gender, Address, Password,User_Type)
                        VALUES ('$fullname', '$email', '$phone', '$dob', '$gender', '$address', '$password','$user_type')";
   



    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }



    // For security reasons, don't echo passwords in real application
    $conn->close();

}
}
?>
