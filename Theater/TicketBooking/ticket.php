<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Management</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        /* Container Styles */
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            overflow-x: auto; /* Allow horizontal scrolling for small screens */
        }

        /* Heading Styles */
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 20px;
            border: 2px solid #1464a5; /* Add border to the table */
            border-radius: 10px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #1464a5;
        }

        th {
            background-color: #1464a5;
            color: #fff;
            font-weight: bold;
        }

        /* Apply alternating background colors to table rows */
        tr:nth-child(even) {
            background-color: #eaf2ff;
        }

        /* Image Styles */
        img {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
            border: 2px solid #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            cursor: pointer; /* Change cursor to pointer on hover */
        }

        /* Link Styles */
        a {
            text-decoration: none;
            color: #2d68c4;
            font-weight: bold;
        }

        a:hover {
            color: #1a4d94;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hall Running Show Movies</h1>
    <table>
        <thead>
        <tr>
            <th>Movie Name</th>
            <th>Poster</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Ticket Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include '../../connection.php';

        // Query to fetch movie information from theaterMovie and movie tables
        $query = "SELECT theatermovie.*, movie.* FROM theatermovie INNER JOIN movie ON theatermovie.MovieID = movie.MovieID";
        $result = mysqli_query($conn, $query);

        // Check if query executed successfully and returned a valid result
        if ($result && mysqli_num_rows($result) > 0) {
            // Loop through each movie entry
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td>
                        <!-- Movie name with a link -->
                        <a href="#" onclick="selectMovie('<?php echo $row['Title']; ?>')"><?php echo $row['Title']; ?></a>
                    </td>
                    <td>
                        <!-- Clickable poster with confirmation popup -->
                        <a href="javascript:void(0);" onclick="showConfirmation('<?php echo $row['Title']; ?>', '<?php echo $row['HallMovieID']; ?>')">
                            <img src="../../movieadmin/images/<?php echo $row['Image']; ?>" alt="<?php echo $row['Title']; ?>">
                        </a>
                    </td>
                    <td><?php echo $row['StartTime']; ?></td>
                    <td><?php echo $row['EndTime']; ?></td>
                    <td>$<?php echo $row['TicketPrice']; ?></td>
                </tr>
                <?php
            }
        } else {
            // Display a message if no movies found
            echo "<tr><td colspan='5'>No movies found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- JavaScript function to select a movie -->
<script>
    function selectMovie(movieName) {
        // You can perform any action here, like storing the selected movie name in a variable or redirecting to another page
        alert("You have selected: " + movieName);
    }

    function showConfirmation(movieName, hallMovieID) {
        if (confirm("Are you sure you want to book tickets for '" + movieName + "'?")) {
            window.location.href = "booking.php?hallMovieID=" + hallMovieID;
        }
    }
</script>
</body>
</html>
