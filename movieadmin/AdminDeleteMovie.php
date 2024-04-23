<?php
include '../connection.php';

if(isset($_GET['MovieID'])) {
    $movieID = $_GET['MovieID'];

    // Delete movie from the database
    $sql = "DELETE FROM movie WHERE MovieID='$movieID'";

    if ($conn->query($sql) === TRUE) {
        echo "Movie deleted successfully";
        header("location:AdminShowMovieList.php");
    } else {
        echo "Error deleting movie: " . $conn->error;
    }
}
  
    

?>
