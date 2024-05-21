<?php
include '../connection.php';
session_start();

$user_email = $_SESSION['user_email'];
$couponCode = $_GET['coupon_code']; // Assuming you get the coupon code via POST method
$totalPrice = $_GET['totalPrice']; // Assuming total price is sent via POST method

// Check if the coupon is valid and calculate the discount
$discount = 0;
$couponSql = "SELECT * FROM coupon WHERE code = '$couponCode'";
$couponResult = $conn->query($couponSql);

if ($couponResult->num_rows > 0) {
    $coupon = $couponResult->fetch_assoc();
    $discount = $coupon['minimum_order'];
}

// Redirect to cartAfterCoupon.php with total price and discount
header("Location: cartAfterCoupon.php?total_price=$totalPrice & discount_price=$discount");
exit();
?>
