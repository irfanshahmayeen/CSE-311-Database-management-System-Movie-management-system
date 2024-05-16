<?php
session_start();
$user_email = $_SESSION['user_email'];


if (!empty($user_email)) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Movie Theater Ticket System</title>
    <style>
        body{
            background-image:url("../../image_bacground/bg2012cinema0709_008.jpg"); /* Replace with your image */
    background-size: cover;
        }
        :root {
    --text-color: #fff;
    --bg-color: #F9E3E3;
    --main-color: #04f929;
    --h1-font: 6rem;
    --h2-font: 3rem;
    --p-font: 1rem;
    --card-color: #137db1;
}

        header {
    position:relative;
    background: #000;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1000;
    background: transparent;
    padding: 30px 2%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.5s ease;
}

.logo {
    font-size: 33px;
    font-weight: 700;
    color: var(--text-color);
}

span {
    color: var(--main-color);
}

.navbar {
    display: flex;
}

.navbar a {
    color: var(--text-color);
    font-size: var(--p-font);
    font-weight: bold;
    margin: 15px 22px;
    transition: all 0.5s ease;
}

.navbar a:hover {
    color: var(--main-color);
}

.search-form {
    display: flex;
    align-items: center;
}

.search-bar {
    margin-right: 20px;
}

.search-bar input[type=text] {
    padding: 8px;
    border: none;
    font-size: 17px;
    border-radius: 5px;
}

.submit-button button {
    background-color: var(--main-color);
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 17px;
}

.submit-button button:hover {
    background-color: var(--main-color);
}

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
        #addFoodLink {
        display: inline-block;
        background-color: var(--main-color);
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 17px;
        text-decoration: none;
        margin-left: 10px; /* Add some space between the buttons */
    }

    #addFoodLink:hover {
        background-color: #1abc9c;
    }
    #addpayLink {
        display: inline-block;
        background-color: var(--main-color);
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 17px;
        text-decoration: none;
        margin-left: 10px; /* Add some space between the buttons */
    }

    #addpayLink:hover {
        background-color: #1abc9c;
    }
    </style>
</head>
<body>
<header>
    <a href="homepage.php" class="logo">IZI <span>Movie</span></a>
    <ul class="navbar">
        <li><a href="../test/homepage.php">Home</a></li>
        <li><a href="../movieadmin/AdminShowMovieList.php">Movies</a></li>
        <li><a href="#">Watchlist</a></li>
        <li><a href="#">Directors</a></li>
        <li><a href="#">Top10</a></li>
        <li><a href="#">Trailer</a></li>
        <li><a href="#">Theater</a></li>
    </ul>
    <form class="search-form" action="/search" method="GET">
        <div class="search-bar">
            <input type="text" name="query" placeholder="Search...">
        </div>
        <div class="submit-button">
            <button type="submit">Search</button>
        </div>
    </form>
    
</header>
    <h1 style="text-align: center; color:#fff;">Movie Theater Seat Selection</h1>


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
        $bookingDate='';
        //recieving data from sent by ticket.php
       if(isset($_GET['hallMovieID'])){
            $HallMovieID  = $_GET['hallMovieID'];
           
           
   
            //$findsql = "SELECT * FROM  theatermovie WHERE  = HallMovieID='$HallMovieID'";
            //$result1 = mysqli_query($conn,$findsql);
            //$row1 =mysqli_fetch_array($result1);
           // $HallLocation = $row1['Location'];
        }
        if(isset($_GET['bookingDate'])){
           
            $bookingDate  = $_GET['bookingDate'];
           
   
         
        }




        // Fetch booked seats from the database
        $sql = "SELECT SeatNumber FROM bookings WHERE HallMovieID ='$HallMovieID' AND BookingDate='$bookingDate'";
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
    <input type="hidden" name="HallMovieID" value='<?php echo $HallMovieID; ?>'>
    <input type="hidden" name="SeatNumber" id="seatNumbers">
    <input type="hidden" name="bookingTime" id="bookingTime">
    <input type="hidden" name="paymentStatus" value="unpaid">
    <!-- Add the following line to include bookingDate in the form -->
    <input type="hidden" name="bookingDate" value='<?php echo $bookingDate; ?>'>
    <button type="submit" id="submitBtn">Submit</button>
    <a href="../../Food/foodOrder.php" id="addFoodLink">Add a Food</a>
    <a href="../../cart/cart.php" id="addpayLink">pay card</a>

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


        // Retrieve bookingDate from the $_POST array
$bookingDate = isset($_POST['bookingDate']) ? $_POST['bookingDate'] : '';


// Prepare data for insertion
$HallMovieID = $_POST['HallMovieID'];
$SeatNumbers = explode(',', $_POST['SeatNumber']); // Split seat numbers into an array
$bookingTime = $_POST['bookingTime'];
$paymentStatus = $_POST['paymentStatus'];


// Array to store successfully inserted seat numbers
$successSeatNumbers = [];


// Insert data into the database
foreach ($SeatNumbers as $SeatNumber) {
    $sql = "INSERT INTO bookings (HallMovieID,Email ,SeatNumber, bookingDate, bookingTime, paymentStatus) VALUES ('$HallMovieID','$user_email', '$SeatNumber', '$bookingDate', '$bookingTime', '$paymentStatus')";
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
            echo "<script>window.location = 'booking.php?hallMovieID=$HallMovieID&bookingDate=$bookingDate';</script>";
            exit; // Terminate further execution
        }
    }
    ?>


    <?php  }else{
  header('location:../login/login.php');
} ?>


</body>
</html>

