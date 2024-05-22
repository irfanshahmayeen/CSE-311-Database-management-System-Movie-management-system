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
    <title>User Profile</title>
    <style>
        :root {
            --text-color: #fff;
            --bg-color: #F9E3E3;
            --main-color: #04f929;
            --h1-font: 6rem;
            --h2-font: 3rem;
            --p-font: 1rem;
            --card-color: #137db1;
            --color1: #FF5733; /* Color for initial set of buttons */
            --color2: #33FFBD; /* Color for clicked functionality buttons */
            --color3: #FF33A1; /* Color for next functionality buttons */
        }

        header {
            position: relative;
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://cdn.dribbble.com/users/1646263/screenshots/3549733/camera_build_-_loop_1.gif') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .profile-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .profile-info {
            flex: 1;
            margin-right: 20px;
        }

        .profile-actions {
            flex: 2;
            margin-left: 20px;
            display: flex;
            flex-direction: column;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ff0000;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 5px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ffff80;
        }

        .menu {
            text-align: center;
            margin-top: 30px;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
        }

        .menu ul li {
            display: inline;
            margin: 0 10px;
        }

        .menu ul li a {
            text-decoration: none;
            color: #ffffff;
            font-size: 18px;
        }

        .menu ul li a:hover {
            color: #00ff00;
        }

        .profile-image {
            display: block;
            margin: 0 auto;
            width: 150px;
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .action-buttons button {
            margin: 5px 0;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: var(--color1);
            color: white;
            text-align: left;
        }

        .secondary-btn, .child-btn {
            display: none;
            flex-direction: column;
        }

        .secondary-btn.active, .child-btn.active {
            display: flex;
        }

        .intermediate-btn {
            background-color: var(--color2);
            margin: 5px 0;
            padding: 10px 20px;
            width: 100%;
            text-align: left;
        }

        .child-btn div {
            display: none;
            flex-direction: column;
        }

        .child-btn div.active {
            display: flex;
            background-color: var(--color3);
        }

        .child-btn a {
            color: white;
            text-decoration: none;
            padding: 5px;
            display: block;
        }

        .child-btn a:hover {
            text-decoration: underline;
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

<div class="profile-container">
    <div class="profile-info">
        <?php
        include '../connection.php';

        echo '<div class="container">';
        echo '<h2>User Profile</h2>';

        $sql = "SELECT * FROM usersignup WHERE Email='$user_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<img src="../signup/signupImages/' . $row['Image'] . '" alt="User Image" class="profile-image">';
            echo "<table>";
            echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th><th>DOB</th><th>Gender</th><th>Address</th></tr>";
            echo "<tr>";
            echo "<td>".$row["UserID"]."</td>";
            echo "<td>".$row["FullName"]."</td>";
            echo "<td>".$row["Email"]."</td>";
            echo "<td>".$row["Phone"]."</td>";
            echo "<td>".$row["DOB"]."</td>";
            echo "<td>".$row["Gender"]."</td>";
            echo "<td>".$row["Address"]."</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "0 results";
        }

        echo '</div>';
        ?>

        <div class="action-buttons">
            <button id="main-btn">Main</button>
            <button id="movies-btn">Movies</button>
            <button id="food-btn">Food</button>
            <button id="review-btn">Review</button>
        </div>
    </div>

    <div class="profile-actions">
        <div class="secondary-btn" id="secondary-btn">
            <div class="main-btn">
                <button class="intermediate-btn" data-target="lang-gen">Language and Genre</button>
                <button class="intermediate-btn" data-target="director">Director</button>
                <button class="intermediate-btn" data-target="cast">Cast</button>
                <button class="intermediate-btn" data-target="producer">Producer</button>
            </div>

            <div class="movies-btn">
                <button class="intermediate-btn" data-target="add-movies">Add Movies</button>
                <button class="intermediate-btn" data-target="movie-show">Show Movies</button>
                <button class="intermediate-btn" data-target="update-movies">Update Movies</button>
                <button class="intermediate-btn" data-target="delete-movies">Delete Movies</button>
            </div>

            <div class="food-btn">
                <button class="intermediate-btn" data-target="add-food">Add Food</button>
                <button class="intermediate-btn" data-target="show-food">Show Food</button>
                <button class="intermediate-btn" data-target="delete-food">Delete Food</button>
            </div>

            <div class="review-btn">
                <button class="intermediate-btn" data-target="add-review">Add Review</button>
                <button class="intermediate-btn" data-target="show-review">Show Review</button>
                <button class="intermediate-btn" data-target="delete-review">Delete Review</button>
            </div>
        </div>

        <div class="child-btn" id="child-btn">
            <div class="lang-gen">
                <button><a href="" class="add-lang-gen">Add Language and Genre</a></button>
                <button><a href="" class="show-lang-gen">Show Language and Genre</a></button>
                <button><a href="" class="up-lang-gen">Update</a></button>
                <button><a href="" class="del-lang-gen">Delete</a></button>
            </div>

            <div class="director">
                <button><a href="" class="add-director">Add Director</a></button>
                <button><a href="" class="show-director">Show Director</a></button>
                <button><a href="" class="up-director">Update</a></button>
                <button><a href="" class="del-director">Delete</a></button>
            </div>

            <div class="cast">
                <button><a href="" class="add-cast">Add Cast</a></button>
                <button><a href="" class="show-cast">Show Cast</a></button>
                <button><a href="" class="up-cast">Update</a></button>
                <button><a href="" class="del-cast">Delete Cast</a></button>
            </div>

            <div class="producer">
                <button><a href="" class="add-prod">Add Producer</a></button>
                <button><a href="" class="show-prod">Show Producer</a></button>
                <button><a href="" class="up-prod">Update</a></button>
                <button><a href="" class="del-prod">Delete Producer</a></button>
            </div>

            <div class="add-movies">
                <button><a href="" class="add-movies2">Add Movies</a></button>
            </div>

            <div class="movie-show">
                <button><a href="" class="movie-show2">Show Movies</a></button>
            </div>

            <div class="update-movies">
                <button><a href="" class="update-movies2">Update</a></button>
            </div>

            <div class="delete-movies">
                <button><a href="" class="delete-movies2">Delete Movies</a></button>
            </div>

            <div class="add-food">
                <button><a href="" class="add-food2">Add Foods</a></button>
            </div>

            <div class="show-food">
                <button><a href="" class="show-food2">Show Foods</a></button>
            </div>

            <div class="delete-food">
                <button><a href="" class="delete-food2">Delete Foods</a></button>
            </div>

            <div class="add-review">
                <button><a href="" class="add-review2">Add Reviews</a></button>
            </div>

            <div class="show-review">
                <button><a href="" class="show-review2">Show Reviews</a></button>
            </div>

            <div class="delete-review">
                <button><a href="" class="delete-review2">Delete Reviews</a></button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const actionButtons = document.querySelectorAll('.action-buttons button');
        const secondaryBtnContainer = document.getElementById('secondary-btn');
        const secondarySections = secondaryBtnContainer.querySelectorAll('div');
        const intermediateButtons = document.querySelectorAll('.intermediate-btn');
        const childBtnContainer = document.getElementById('child-btn');
        const childSections = childBtnContainer.querySelectorAll('div');

        actionButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetClass = button.id.replace('-btn', '');
                secondarySections.forEach(section => section.classList.remove('active'));
                document.querySelector(`.${targetClass}-btn`).classList.add('active');
                secondaryBtnContainer.classList.add('active');
                childSections.forEach(section => section.classList.remove('active'));
                // Hide all child sections initially
                childBtnContainer.classList.remove('active');
            });
        });

        intermediateButtons.forEach(button => {
            button.addEventListener('click', () => {
                const target = button.dataset.target;
                childSections.forEach(section => section.classList.remove('active'));
                document.querySelector(`.${target}`).classList.add('active');
                childBtnContainer.classList.add('active');
            });
        });
    });
</script>

</body>
</html>

<?php
} else {
    header('location:../login/login.php');
}
?>
