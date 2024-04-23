<?php
include '../connection.php';
include 'AdminUpdateMovie.html';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve movie details from the form
    $movieID = $_POST['movieID'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_date = $_POST['release_date'];
    $duration = $_POST['duration'];
    $language = $_POST['language'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];

    // Update movie details in the database
    $sql = "UPDATE movie SET Title='$title', Genre='$genre', Release_date='$release_date', Duration='$duration', Language='$language', Description='$description', Budget=$budget 
    WHERE MovieID='$movieID'";

    if ($conn->query($sql) === TRUE) {
        echo "Movie updated successfully";
        header('location:AdminShowMovieList.php');
    } else {
        echo "Error updating movie: " . $conn->error;
    }
}
?>
