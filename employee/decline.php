<?php
include '../connection.php';

// Retrieve email and user_type from URL parameters
$email = $_GET['email'] ?? '';
$user_type = $_GET['user_type'] ?? '';

// Check if email and user_type are provided
if (empty($email) || empty($user_type)) {
    echo "Email and user type are required.";
    exit;
}

// Delete image
$image_filename = '';
switch ($user_type) {
    case "user":
        $find_sql = "SELECT * FROM tempusersignup WHERE Email ='$email'";
        break;
    case "admin":
        $find_sql = "SELECT * FROM tempadminsignup WHERE Email ='$email'";
        break;
    case "employee":
        $find_sql = "SELECT * FROM tempemployeesignup WHERE Email ='$email'";
        break;
    default:
        echo "Invalid user type.";
        exit;
}

$result = $conn->query($find_sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image_filename = $row['Image'];
    $image_path = "../signup/signupImages/" . $image_filename;

    // Check if the file exists before attempting to delete it
    if (file_exists($image_path)) {
        // Attempt to delete the image file
        if (unlink($image_path)) {
            echo "Image file deleted successfully<br>";
        } else {
            echo "Error deleting image file<br>";
        }
    } else {
        echo "Image file not found<br>";
    }
}

// Delete data from database
switch ($user_type) {
    case "user":
        $delete_sql = "DELETE FROM tempusersignup WHERE Email ='$email'";
        break;
    case "admin":
        $delete_sql = "DELETE FROM tempadminsignup WHERE Email ='$email'";
        break;
    case "employee":
        $delete_sql = "DELETE FROM tempemployeesignup WHERE Email ='$email'";
        break;
    default:
        echo "Invalid user type.";
        exit;
}

if ($conn->query($delete_sql) === TRUE) {
    echo "Record deleted successfully<br>";
} else {
    echo "Error deleting record: " . $conn->error . "<br>";
}

// Close connection
mysqli_close($conn);

// Redirect to pendingsignup.php
header('location:pendingsignup.php');
?>
