<?php
include '../../connection.php';

if(isset($_GET['id'])) {
    $movieID = $_GET['id'];

     // Delete movie from the database
    $sql = "DELETE FROM movie WHERE MovieID='$movieID'";


    if ($conn->query($sql) === TRUE) {
        echo "Movie deleted successfully";
        header("location:theaterAdminShow.php");
    } else {
        echo "Error deleting movie: " . $conn->error;
    }
}
  
    

?>
