<?php include '../connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .add-movie-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-movie-btn:hover {
            background-color: #45a049;
        }

        .action-btns {
            display: flex;
            justify-content: space-around;
        }

        .action-btns button {
            padding: 5px 10px;
            margin-right: 5px;
            cursor: pointer;
            border: none;
            border-radius: 3px;
        }

        .action-btns button.delete-btn {
            background-color: #f44336;
            color: white;
        }

        .action-btns button.update-btn {
            background-color: #007bff;
            color: white;
        }

        .action-btns button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Movie Management</h1>

    <table>
        <thead>
            <tr>
                <th>MovieID</th>
                <th>Title</th>
                <th>Poster</th>
                <th>Genre</th>
                <th>Director</th>
                <th>Release Date</th>
                <th>Duration</th>
                <th>Language</th>
                <th>Description</th>
                <th>Budget</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM movie";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["MovieID"] . "</td>";
                    echo "<td>" . $row["Title"] . "</td>";
                    // Fetching image filename from the database
                    $image_filename = $row["Image"];
                    // Generating the image path
                    $image_path = "images/" . $image_filename;
                    // Displaying the image
                    echo "<td><img src='" . $image_path . "' alt='" . $row["Title"] . "' width='100'></td>";
                    echo "<td>" . $row["Genre"] . "</td>";
                    echo "<td>" . $row["Director"] . "</td>";
                    echo "<td>" . $row["Release_date"] . "</td>";
                    echo "<td>" . $row["Duration"] . "</td>";
                    echo "<td>" . $row["Language"] . "</td>";
                    echo "<td>" . $row["Description"] . "</td>";
                    echo "<td>" . $row["Budget"] . "</td>";
                    echo "<td class='action-btns'>";
                    echo "<button class='delete-btn' onclick='window.location.href=\"AdminDeleteMovie.php?MovieID=" . $row["MovieID"] . "\"'>Delete</button>";
                    echo "<button class='update-btn' onclick='window.location.href=\"AdminUpdateMovie.php?MovieID=" . $row["MovieID"] . "\"'>Update</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No movies found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <button class="add-movie-btn" onclick="window.location.href='AdminAddMovie.php'">Add Movie</button>
</body>
</html>
