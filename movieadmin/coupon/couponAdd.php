<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Coupon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            padding: 10px 15px;
            background: #28a745;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .form-group button:hover {
            background: #218838;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Coupon</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="code">Coupon Code:</label>
                <input type="text" id="code" name="code" required>
            </div>
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="number" step="0.01" id="discount" name="discount" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="minimum_order">Minimum Order Amount:</label>
                <input type="number" step="0.01" id="minimum_order" name="minimum_order" required>
            </div>
            <div class="form-group">
                <label for="usage_limit">Usage Limit:</label>
                <input type="number" id="usage_limit" name="usage_limit" value="1" required>
            </div>
            <div class="form-group">
                <label for="validity_duration">Validity Duration (in days):</label>
                <input type="number" id="validity_duration" name="validity_duration" value="1" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Add Coupon</button>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include '../../connection/connection.php';

            $code = $_POST['code'];
            $discount = $_POST['discount'];
            $expiry_date = $_POST['expiry_date'];
            $description = $_POST['description'];
            $minimum_order = $_POST['minimum_order'];
            $usage_limit = $_POST['usage_limit'];
            $validity_duration = $_POST['validity_duration'];

            // Check if the coupon code already exists
            $checkSql = "SELECT * FROM Coupon WHERE code='$code'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                echo "<div class='message error'>Error: Coupon code already exists.</div>";
            } else {
                $sql = "INSERT INTO Coupon (code, discount, expiry_date, description, minimum_order, usage_limit, validity_duration) 
                        VALUES ('$code', $discount, '$expiry_date', '$description', $minimum_order, $usage_limit, $validity_duration)";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='message success'>Coupon added successfully!</div>";
                } else {
                    echo "<div class='message error'>Error: " . $conn->error . "</div>";
                }
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
