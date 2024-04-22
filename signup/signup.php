
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
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Construct SQL query
    $sql = "INSERT INTO signup ( FullName,  Email, Phone, DOB, Gender, Address, Password,Confirmpassword)
     VALUES ('$fullname', '$email', '$phone', '$dob', '$gender', '$address', '$password','$confirm_password')";
   


if ($password !== $confirm_password) {
   // echo "<script>alert('Passwords do not match. Please try again.')</script>";
   // echo "<script>window.location.href = 'signup.html';</script>";
    exit;
}

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }



    // For security reasons, don't echo passwords in real application
    $conn->close();

}
?>
