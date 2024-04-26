<?php
// booking.php

// Start the session to persist selected seats across pages
session_start();

// Check if a movie is selected
if (isset($_GET['movie'])) {
    // Assuming you have a database connection established
    include '../../connection.php';

    // Fetch the selected movie name from the URL
    $movieName = $_GET['movie'];

    // Retrieve selected seats from the session if available
    $selectedSeats = isset($_SESSION['selected_seats']) ? $_SESSION['selected_seats'] : [];

    // Handle form submission for seat booking
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assuming you have a table named 'bookings' with columns 'movie_name' and 'seat_number'
        
        // Insert the booked seats into the database
        foreach ($_POST['seats'] as $seat) {
            $query = "INSERT INTO bookings (movie_name, seat_number) VALUES ('$movieName', '$seat')";
            mysqli_query($conn, $query);
        }
        
        // Redirect back to the movie selection page
        header("Location: index.php");
        exit;
    }
} else {
    // If no movie is selected, redirect to the main page
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Theater Ticket System</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 600px;
            margin: 0 auto;
        }
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            background-color: #bdc3c7;
            cursor: pointer;
            border-radius: 5px;
        }
        .seat.selected {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <h1>Movie Theater Seat Selection</h1>
    <form method="post">
        <div class="container">
            <?php
            // Define the number of rows and seats per row
            $numRows = 6;
            $seatsPerRow = 10;

            // Function to create seats
            function createSeats($selectedSeats) {
                for ($i = 0; $i < $numRows; $i++) {
                    for ($j = 0; $j < $seatsPerRow; $j++) {
                        // Create a seat element
                        $seatNumber = chr(65 + $i) . ($j + 1);
                        $isSelected = in_array($seatNumber, $selectedSeats);
                        $class = $isSelected ? 'selected' : '';
                        echo "<div class='seat $class' data-seat='$seatNumber'>$seatNumber</div>";
                    }
                }
            }

            // Call the function to create seats
            createSeats($selectedSeats);
            ?>
        </div>
        <button type="submit">Book Selected Seats</button>
    </form>
</body>
</html>
