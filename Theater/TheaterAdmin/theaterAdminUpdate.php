<?php
include '../../connection.php';
include 'theaterAdminUpdate.html';

// Check if MovieID is provided in the URL
if(isset($_GET['id'])) {
    // Sanitize the input
    $movieID = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch the movie information based on MovieID
    $selectQuery = "SELECT * FROM theatermovie WHERE MovieID = '$movieID'";
    $result = mysqli_query($conn, $selectQuery);

    if(mysqli_num_rows($result) == 1) {
        // Fetch the movie details
        $row = mysqli_fetch_assoc($result);
        $title = $row['Title'];
        $category = $row['Category'];
        $startTime = $row['StartTime'];
        $endTime = $row['EndTime'];
        $location = explode(", ", $row['Location']); // Use explode to split locations into an array
        $ticketPrice = $row['TicketPrice'];
    } else {
        // If no movie found with the provided MovieID, redirect to the movie list page
        header("Location: theaterAdminList.php");
        exit();
    }
} else {
    // If no MovieID is provided, redirect to the movie list page
    header("Location: theaterAdminList.php");
    exit();
}

// Check if the update form is submitted
if(isset($_POST['submit'])) {
    // Sanitize the input
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $startTime = mysqli_real_escape_string($conn, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($conn, $_POST['endTime']);
    $locations = $_POST['location']; // Locations is an array
    $ticketPrice = mysqli_real_escape_string($conn, $_POST['ticketPrice']);
    
    // Convert start time and end time to DateTime objects
    $startDateTime = new DateTime($startTime);
    $endDateTime = new DateTime($endTime);
    
    // Check if start time is before end time
    if($startDateTime >= $endDateTime) {
        echo "<script>alert('Start time must be before end time');</script>";
    } else {
        // Flag to check for conflicts
        $conflict = false;
        
        // Check for conflicts with existing movies
        foreach($locations as $location) {
            // Query to check for conflicts
            $query = "SELECT * FROM theatermovie WHERE Location = '$location' AND ((StartTime <= '$startTime' AND EndTime >= '$endTime') OR (StartTime >= '$startTime' AND StartTime <= '$endTime') OR (EndTime >= '$startTime' AND EndTime <= '$endTime')) AND MovieID != '$movieID'";
            
            // Execute the query
            $result = mysqli_query($conn, $query);
            
            // Check if any conflicting movies exist
            if(mysqli_num_rows($result) > 0) {
                $conflict = true;
                break;
            }
        }
        
        // If there's a conflict, display an alert message
        if($conflict) {
            echo "<script>alert('Movie cannot be updated. There is a conflict with an existing movie at one of the selected locations.');</script>";
        } else {
            // No conflicts found, proceed with updating the movie
            
            // Query to update the movie entry in the theaterMovie table
            $updateQuery = "UPDATE theatermovie SET Title = '$title', Category = '$category', StartTime = '$startTime', EndTime = '$endTime', Location = '$location', TicketPrice = '$ticketPrice' WHERE MovieID = '$movieID'";

            // Execute the update query
            if(mysqli_query($conn, $updateQuery)) {
                // Movie updated successfully, redirect to the movie list page
                header("Location: theaterAdminList.php");
                exit();
            } else {
                // If update fails, display an error message
                echo "Error updating movie: " . mysqli_error($conn);
            }
        }
    }
}
?>
