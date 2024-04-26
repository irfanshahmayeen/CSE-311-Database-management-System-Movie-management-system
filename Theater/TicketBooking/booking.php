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
            border: 2px solid #000; /* Add border to the container */
            padding: 10px;
        }
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            background-color: #48CAE4;
            cursor: pointer;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 0.9em;
        }
        .seat.selected {
            background-color: #2ecc71;
        }
        .seat.booked {
            background-color: #e74c3c;
            cursor: not-allowed;
        }
        .side-view {
            margin-top: 20px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .side-view h2 {
            margin-bottom: 10px;
            font-size: 1.5em;
            color: #333;
        }
        .selected-seats {
            margin-bottom: 15px;
        }
        .selected-seats div {
            margin-bottom: 5px;
            font-size: 1.2em;
            color: #333;
        }
        .total-price {
            font-size: 1.5em;
            font-weight: bold;
            color: #2ecc71;
        }
        #submitBtn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #2ecc71;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
        }
        #submitBtn:hover {
            background-color: #1abc9c;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Movie Theater Seat Selection</h1>

    <div class="container">
        <!-- Create seats using PHP -->
        <?php
        // Start output buffering to capture any output
        ob_start();

        // Include database connection
        include '../../connection.php';

        // End output buffering and discard any captured output
        ob_end_clean();
        $HallMovieID='6';
        //recieving data from sent by ticket.php
       if(isset($_GET['hallMovieID'])){
            $HallMovieID  = $_GET['hallMovieID'];
    
            //$findsql = "SELECT * FROM  theatermovie WHERE  = HallMovieID='$HallMovieID'";
            //$result1 = mysqli_query($conn,$findsql);
            //$row1 =mysqli_fetch_array($result1);
           // $HallLocation = $row1['Location'];
        }

        // Fetch booked seats from the database
        $sql = "SELECT SeatNumber FROM bookings WHERE HallMovieID ='$HallMovieID'";
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
                    echo "<div class='$class' data-seat='$seatNumber' data-price='10'>$seatNumber</div>"; // Change 10 to the actual price
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
        <input type="hidden" name="HallMovieID" value='<?php echo $HallMovieID; ?>'> <!-- Use PHP echo to output the value -->
        <input type="hidden" name="SeatNumber" id="seatNumbers">
        <input type="hidden" name="bookingTime" id="bookingTime">
        <input type="hidden" name="paymentStatus" value="paid">
        <button type="submit" id="submitBtn">Submit</button>
    </form>

    <!-- Side view of the seat booking cart -->
    <div class="side-view">
        <h2>Selected Seats</h2>
        <div class="selected-seats" id="selected-seats"></div>
        <div class="total-price" id="total-price">Total Price: $0</div>
    </div>

    <script>
        // Get all seat elements
        const seats = document.querySelectorAll('.seat');
        // Get selected seats container
        const selectedSeatsContainer = document.getElementById('selected-seats');
        // Get total price container
        const totalPriceContainer = document.getElementById('total-price');

        // Add click event listener to each seat
        seats.forEach(seat => {
            seat.addEventListener('click', selectSeat);
        });

        // Function to select/deselect a seat
        function selectSeat() {
            if (this.classList.contains('booked')) {
                alert('This seat is already booked.');
                return;
            }
            this.classList.toggle('selected');
            updateForm();
            updateSideView();
        }

        // Function to update hidden form fields with selected seats and booking time
        function updateForm() {
            const selectedSeats = document.querySelectorAll('.seat.selected');
            const seatNumbers = Array.from(selectedSeats).map(seat => seat.dataset.seat);
            document.getElementById('seatNumbers').value = seatNumbers.join(',');
            document.getElementById('bookingTime').value = new Date().toISOString().slice(0, 19).replace('T', ' ');
        }

        // Function to update side view with selected seats and total price
        function updateSideView() {
            const selectedSeats = document.querySelectorAll('.seat.selected');
            let totalPrice = 0;
            let seatsInfo = '';
            selectedSeats.forEach(seat => {
                const seatNumber = seat.dataset.seat;
                const seatPrice = parseInt(seat.dataset.price); // Assuming seat price is stored in 'data-price'
                totalPrice += seatPrice;
                seatsInfo += `<div>Seat ${seatNumber} - $${seatPrice}</div>`;
            });
            selectedSeatsContainer.innerHTML = seatsInfo;
            totalPriceContainer.textContent = `Total Price: $${totalPrice}`;
        }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../../connection.php';

        // Prepare data for insertion
        $HallMovieID = $_POST['HallMovieID'];
        $SeatNumbers = explode(',', $_POST['SeatNumber']); // Split seat numbers into an array

        $bookingTime = $_POST['bookingTime'];
        $paymentStatus = $_POST['paymentStatus'];

        // Array to store successfully inserted seat numbers
        $successSeatNumbers = [];

        // Insert data into the database
        foreach ($SeatNumbers as $SeatNumber) {
            $sql = "INSERT INTO bookings (HallMovieID, SeatNumber, bookingTime, paymentStatus) VALUES ('$HallMovieID', '$SeatNumber', '$bookingTime', '$paymentStatus')";
            if (mysqli_query($conn, $sql)) {
                $successSeatNumbers[] = $SeatNumber; // Add successfully inserted seat number to the array
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Display the alert message with the successfully inserted seat numbers
        if (!empty($successSeatNumbers)) {
            $message = 'Booking successfully inserted into the database for seat(s): ' . implode(', ', $successSeatNumbers);
            echo "<script>alert('$message')</script>";
        }

        mysqli_close($conn);
        if (!empty($successSeatNumbers)) {
            echo "<script>window.location = 'booking.php?hallMovieID=$HallMovieID';</script>";
            exit; // Terminate further execution
        }
    }
    ?>

</body>
</html>
