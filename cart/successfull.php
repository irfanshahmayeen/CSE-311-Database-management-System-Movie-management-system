<?php
include '../connection.php';
session_start();
$user_email = $_SESSION['user_email'];
if (!empty($user_email)) {
?>


<?php
     $transactionID = uniqid('txn', true);

           $sql1 = "SELECT * FROM foodbookings WHERE Email ='$user_email' AND PaymentStatus ='unpaid'";
           $result1  = $conn->query($sql1);
           if(mysqli_num_rows($result1) > 0){
            

     INSERT INTO orderhistory (Email, TranxactionID, ProductType, Product_Name, Quantity, OrderDate, PaymentStatus)
     VALUES ('$user_email', '$transactionID', 'food', 'Laptop', 1, NOW(), 'Paid'); 
     
     }





$query1 = "UPDATE bookings SET PaymentStatus = 'paid' WHERE Email = '$user_email'";
$query2 = "UPDATE foodbookings SET PaymentStatus = 'paid' WHERE Email = '$user_email'";

// Execute the queries
if ($conn->query($query1) === TRUE) {
    echo "Record updated successfully in bookings.";
} else {
    echo "Error updating record in bookings: " . $mysqli->error;
}

if ($conn->query($query2) === TRUE) {
    echo "Record updated successfully in foodbookings.";
} else {
    echo "Error updating record in foodbookings: " . $mysqli->error;
}









?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
        }
        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: inline-block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill 0.4s ease-in-out 0.4s forwards, draw 1s ease-in-out 0.4s forwards;
        }
        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
        }
        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful</h1>
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
        <p>Thank you for your payment! Your transaction has been completed successfully.</p>
        <a href="cart.php" class="button">Go to Cart</a>
    </div>

    <?php  }else{
  header('location:../login/login.php');
} ?>
</body>
</html>
