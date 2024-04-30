<?php
// Connect to the database
include '../connection.php';

// Retrieve email and user_type from URL parameters
$email = $_GET['email'] ?? '';
$user_type = $_GET['user_type'] ?? '';

// Check if email and user_type are provided
if (empty($email) || empty($user_type)) {
    echo "Email and user type are required.";
    exit;
}

// Determine the source and target tables based on user_type
switch ($user_type) {
    case "user":
        $source_table = "tempusersignup";
        $target_table = "usersignup";
        break;
    case "admin":
        $source_table = "tempadminsignup";
        $target_table = "adminsignup";
        break;
    case "employee":
        $source_table = "tempemployeesignup";
        $target_table = "employeesignup";
        break;
    default:
        echo "Invalid user type.";
        exit;
}

// Prepare select statement for retrieving data from the source table
$select_sql = "SELECT * FROM $source_table WHERE Email = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Data found, fetch and store in variables
    $row = $result->fetch_assoc();
    $UserID = $row["UserID"];
    $FullName = $row["FullName"];
    $Email = $row["Email"];
    $Phone = $row["Phone"];
    $DOB = $row["DOB"];
    $Gender = $row["Gender"];
    $Address = $row["Address"];
    $Password = $row["Password"];
    $User_Type = $row["User_Type"];
    $Image = $row["Image"];

    // Prepare insert statement for inserting data into target table
    $insert_sql = "INSERT INTO $target_table (FullName, Email, Phone, DOB, Gender, Address, Password, User_Type, Image) 
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssssssss", $FullName, $Email, $Phone, $DOB, $Gender, $Address, $Password, $User_Type, $Image);
    $stmt->execute();

    // Data inserted successfully, now delete from source table
    $delete_sql = "DELETE FROM $source_table WHERE Email = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    echo "Data inserted and moved successfully.";
} else {
    echo "No data found for this email.";
}

// Close statement
$stmt->close();

// Close connection
$conn->close();
?>
