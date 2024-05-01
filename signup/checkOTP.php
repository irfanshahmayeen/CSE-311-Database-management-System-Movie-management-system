<?php
session_start();
$email = $_GET['email'];
$user_type = $_GET['user_type'];

if (isset($_POST['submit'])) {
    $otpEntered = $_POST['otp'];
    if ($_SESSION['otp'] == $otpEntered ) {
        include '../connection.php'; // Include your database connection script

        // Update OTP based on user type
        if ($user_type === 'user') {
            $sql = "UPDATE tempusersignup SET OTP='valid' WHERE Email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "OTP updated successfully.";
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } elseif ($user_type === 'admin') {
            $sql = "UPDATE tempadminsignup SET OTP='valid' WHERE Email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "OTP updated successfully.";
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } elseif ($user_type === 'employee') {
            $sql = "UPDATE tempemployeesignup SET OTP='valid' WHERE Email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "OTP updated successfully.";
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } else {
            echo "Invalid user type.";
        }

        $conn->close();
    } else {
        echo "Invalid OTP. Please try again.";
         // Update OTP based on user type
         if ($user_type === 'user') {
            $sql = "UPDATE tempusersignup SET OTP='invalid' WHERE Email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "OTP updated successfully.";
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } elseif ($user_type === 'admin') {
            $sql = "UPDATE tempadminsignup SET OTP='invalid' WHERE Email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "OTP updated successfully.";
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } elseif ($user_type === 'employee') {
            $sql = "UPDATE tempemployeesignup SET OTP='invalid' WHERE Email='$email'";
            if ($conn->query($sql) === TRUE) {
                echo "OTP updated successfully.";
            } else {
                echo "Error updating OTP: " . $conn->error;
            }
        } else {
            echo "Invalid user type.";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style></style>
</head>

<body>
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required><br><br>
        <input type="submit" name="submit" value="Submit OTP">
    </form>
</body>

</html>
