
<?php
session_start();
$user_email = $_SESSION['user_email'];

if (!empty($user_email)) {
?>


<?php


// Establish connection to database
include '../connection/connection.php';

// Fetch user details from the database
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM usersignup WHERE Email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Close statement and connection
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form action="updateProfile.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="fullname" placeholder="Full Name" value="<?php echo $row['Fullname']; ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo $row['Email']; ?>" required readonly>
            <input type="tel" name="phone" placeholder="Phone" value="<?php echo $row['Phone']; ?>" required>
            <input type="date" name="dob" value="<?php echo $row['DOB']; ?>" required>
            
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="male" <?php if ($row['Gender'] == 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($row['Gender'] == 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if ($row['Gender'] == 'other') echo 'selected'; ?>>Other</option>
            </select>

            <input type="text" name="address" placeholder="Address" value="<?php echo $row['Address']; ?>" required>

            <select name="user_type" required>
                <option value="">Select user type</option>
                <option value="user" <?php if ($row['User_Type'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($row['User_Type'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="employee" <?php if ($row['User_Type'] == 'employee') echo 'selected'; ?>>Employee</option>
            </select>

            <!--For Image Upload-->
            <label for="Upload profile picture" style="color: aliceblue;">Upload Profile Picture:</label>
            <input class="filee" type="file" name="upfile" id="image" onchange="previewImage(event)">
            <br>
            <img id="preview" src="<?php echo $row['Image']; ?>" alt="Image Preview" style="max-width: 100%; max-height: 200px; margin-top: 10px;">

            <button type="submit" name="submit">Update Profile</button>
        </form>
        <p style="color: aliceblue;">Already have an account? <a href="../login/login.php">Login</a></p>
    </div>

    <!-- pop up when password and confirmed password doesn't match -->
    <script>
        //live image preview in form 
        function previewImage(event) {
            var preview = document.getElementById('preview');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    </script>

<?php  }else{
  header('location:../login/login.php');
} ?>
</body>
</html>
