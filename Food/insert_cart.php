<?php
include '../connection.php'; 

// Check if the POST data is set
if (isset($_POST['foodID']) && isset($_POST['quantity']) && isset($_POST['bookingTime'])) {
    // Sanitize and validate the input data
    $foodID = intval($_POST['foodID']);
    $quantity = intval($_POST['quantity']);
    $bookingTime = $_POST['bookingTime']; // No need to sanitize since it's a datetime string

    // Prepare and execute the SQL query to insert into the foodBookings table
    $stmt = $conn->prepare("INSERT INTO foodBookings (FoodID, Quantity, bookingTime) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $foodID, $quantity, $bookingTime);
    
    if ($stmt->execute()) {
        echo "Food added to cart successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case where POST data is not set
    echo "Error: POST data is not set";
}
?>
