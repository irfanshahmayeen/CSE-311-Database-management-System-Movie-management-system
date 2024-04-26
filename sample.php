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
        .seat.booked {
            background-color: red;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>Movie Theater Seat Selection</h1>
    <div class="container">
        <!-- Create seats using PHP -->
        <?php
        // Include database connection
        include 'connection.php';
       

        // Fetch booked seats from the database
        $sql = "SELECT SeatNumber FROM bookings WHERE HallMovieID = 101";
        $result = mysqli_query($conn, $sql);

        // Array to store booked seats
        $bookedSeats = [];

        // Check if there are booked seats
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bookedSeats[] = $row['SeatNumber'];
            }
        }

        // Function to check if a seat is booked
        function isSeatBooked($seatNumber, $bookedSeats) {
            return in_array($seatNumber, $bookedSeats);
        }

        // Function to create seats
        function createSeats($bookedSeats) {
            $numRows = 6;
            $seatsPerRow = 10;

            for ($i = 0; $i < $numRows; $i++) {
                for ($j = 0; $j < $seatsPerRow; $j++) {
                    // Create a seat element
                    $seatNumber = chr(65 + $i) . ($j + 1);
                    $class = isSeatBooked($seatNumber, $bookedSeats) ? 'seat booked' : 'seat';
                    echo "<div class='$class' data-seat='$seatNumber'>$seatNumber</div>";
                }
            }
        }

        // Call the function to create seats
        createSeats($bookedSeats);

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="bookingForm">
        <input type="hidden" name="HallMovieID" value="101">
        <input type="hidden" name="SeatNumber" id="seatNumbers">
        <input type="hidden" name="bookingTime" id="bookingTime">
        <input type="hidden" name="paymentStatus" value="paid">
        <button type="submit" id="submitBtn">Submit</button>
    </form>

    <script>
        // Function to select/deselect a seat
        function selectSeat() {
            if (this.classList.contains('booked')) {
                alert('This seat is already booked.');
                return;
            }
            this.classList.toggle('selected');
            updateForm();
        }

        // Get all seat elements
        const seats = document.querySelectorAll('.seat');

        // Add click event listener to each seat
        seats.forEach(seat => {
            seat.addEventListener('click', selectSeat);
        });

        // Function to update hidden form fields with selected seats and booking time
        function updateForm() {
            const selectedSeats = document.querySelectorAll('.seat.selected');
            const seatNumbers = Array.from(selectedSeats).map(seat => seat.dataset.seat);
            document.getElementById('seatNumbers').value = seatNumbers.join(',');
            document.getElementById('bookingTime').value = new Date().toISOString().slice(0, 19).replace('T', ' ');
        }
    </script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connection.php';

    // Prepare data for insertion
    $HallMovieID = $_POST['HallMovieID'];
    $SeatNumber = $_POST['SeatNumber'];
    $bookingTime = $_POST['bookingTime'];
    $paymentStatus = $_POST['paymentStatus'];

    // Insert data into the database
    $sql = "INSERT INTO bookings (HallMovieID, SeatNumber, bookingTime, paymentStatus) VALUES ('$HallMovieID', '$SeatNumber', '$bookingTime', '$paymentStatus')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Booking successfully inserted into the database.')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
</body>
</html>
