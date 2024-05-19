<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Coupons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            text-align: center;
            display: inline-block;
        }
        .btn-update {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-add {
            background-color: #008000;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Coupons</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Expiry Date</th>
                    <th>Description</th>
                    <th>Minimum Order</th>
                    <th>Usage Limit</th> <!-- New column -->
                    <th>Validity Duration (Days)</th> <!-- New column -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../connection/connection.php';

                $sql = "SELECT * FROM Coupon";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['coupon_id'] . "</td>";
                        echo "<td>" . $row['code'] . "</td>";
                        echo "<td>" . $row['discount'] . "</td>";
                        echo "<td>" . $row['expiry_date'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['minimum_order'] . "</td>";
                        echo "<td>" . $row['usage_limit'] . "</td>"; // Output usage_limit column
                        echo "<td>" . $row['validity_duration'] . "</td>"; // Output validity_duration column
                        echo "<td class='actions'>
                                <a class='btn btn-update' href='couponUpdate.php?id=" . $row['coupon_id'] . "'>Update</a>
                                <a class='btn btn-delete' href='couponDelete.php?id=" . $row['coupon_id'] . "'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No coupons found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="btn-container">
            <a class="btn btn-add" href="couponAdd.php">Add New Coupon</a>
        </div>
    </div>
</body>
</html>
