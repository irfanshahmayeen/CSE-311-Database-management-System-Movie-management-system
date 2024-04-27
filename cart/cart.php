<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .payment-details {
            margin-top: 20px;
            border-top: 2px solid #ccc;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .logo {
            width: 150px;
            height: 150px;
            /* Add styling for your logo */
        }

        .info {
            flex-grow: 1;
            padding-left: 20px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Slip</h1>
        <div class="payment-details">
            <div class="logo">
                <!-- Your logo here -->
            </div>
            <div class="info">
                <?php
                include '../connection.php';

                // Fetch data from the database
                $sql = "SELECT foods.FoodName, foodbookings.Quantity, foods.FoodPrice FROM foods
                        INNER JOIN foodbookings ON foods.FoodID = foodbookings.FoodID";
                $result = $conn->query($sql);

                $totalPrice = 0;

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<p><strong>".$row["FoodName"]."</strong> - Quantity: ".$row["Quantity"]." - Unit Price: $".$row["FoodPrice"]." - Subtotal: $".($row["Quantity"] * $row["FoodPrice"])."</p>";
                        $totalPrice += ($row["Quantity"] * $row["FoodPrice"]);
                    }
                    // Output total price
                    echo "<p><strong>Total Price: $totalPrice</strong></p>";
                } else {
                    echo "0 results";
                }

                $conn->close();
                ?>
            </div>
        </div>
        <form action="pdf.php" method="post">
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
            <button type="submit">Download PDF</button>
        </form>
    </div>
</body>
</html>
