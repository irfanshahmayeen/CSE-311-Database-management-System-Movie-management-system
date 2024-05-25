<?php 
ob_start();
include '../connection/connection.php';
ob_end_clean();
session_start();
$user_email = $_SESSION['user_email'];
$query1 = "SELECT Image FROM usersignup WHERE Email='$user_email'";
 $result1 = $conn->query($query1);
$row1 = $result1->fetch_assoc();
$user_image = $row1['Image'];
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
            --bg-color: #00ffff;
            --main-color: #04f929;
            --h1-font: 6rem;
            --h2-font: 3rem;
            --p-font: 1rem;
            --card-color: #137db1;
            z-index: 1000;
        }

        header {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1000;
            background: linear-gradient(135deg, #43144f 0%, #193b38 100%);
            padding: 5px 1%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.5s ease;
        }

        .logo {
            font-size: 25px;
            font-weight: 600;
            color: var(--text-color);
        }

        span {
            color: var(--main-color);
        }

        .navbar {
            display: flex;
            align-items: center;
        }

        .navbar a {
            color: var(--text-color);
            font-size: var(--p-font);
            font-weight: bold;
            margin: -5px 12px;
            transition: all 0.2s ease;
        }

        .navbar a:hover {
            color: var(--main-color);
        }

        .search-form {
            display: flex;
            align-items: center;
        }

        .search-bar input[type=text] {
            padding: 8px;
            border: none;
            font-size: 17px;
            border-radius: 6px;
            margin-right: 10px;
        }

        .submit-button button {
            background-color: var(--main-color);
            color: white;
            padding: 8px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 17px;
            margin-right: 10px;
        }

        .submit-button button:hover {
            background-color: var(--main-color);
        }

        .user-image {
            display: flex;
            align-items: right;
        }

        .user-image img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
     /* This will float the image to the left */
    margin-right: 90px; /* Adjust as needed for spacing */
    margin-top: -20px;
}

        .user-image1 img {
            width:30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            
        margin-left: 10px;
        }

        .submit-button button:hover {
            background-color: var(--main-color);
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

.dropdowncorner {
  position: relative;
  display: inline-block;
}

.dropdown-contentcorner {
    
  display: none;
  position: absolute;
  background-color: #0080ff;
  width: 160px; /* Width remains the same */
  min-height: 200px; /* Adjust the height as needed */

  
  box-shadow: 0px 8px 16px 0px rgba(1,2,0,0.2);
  z-index: 1;
}

.dropdowncorner:hover .dropdown-contentcorner {
  display: block;
}

/* Style for the menu items */
.dropdown-contentcorner a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-contentcorner a:hover {
  background-color: #f1f1f1;
}

/* Style for the logout link */
.dropdown-contentcorner a.logout {
  color: red;
}
    </style>
</head>
<body>

<header>
    <a href="homepage.php" class="logo">IZI <span>Movie</span></a>
    <ul class="navbar">
        <li><a href="../test/homepage.php">Home</a></li>
        <li><a href="../userview/movie.php">All Movies</a></li>
        <!-- genre -->
        <li class="dropdown">
            <a href="#">Genre</a>
            <div class="dropdown-content">
                <?php
                $genreSearch = "SELECT * FROM genres";
                $result = $conn->query($genreSearch);
                while($row = $result->fetch_assoc()){
                    echo "<a href='../userview/genremovie.php?genre_name=".$row['genre_name']."'>" . $row['genre_name'] . "</a>";
                }
                ?>
            </div>
        </li>
        <!--Language-->
        <li class="dropdown">
            <a href="#">Language</a>
            <div class="dropdown-content">
                <?php
                $languageSearch = "SELECT * FROM languages";
                $result = $conn->query($languageSearch);
                while($row = $result->fetch_assoc()){
                    echo "<a href='../userview/languagemovie.php?language_name=".$row['language_name']."'>" . $row['language_name'] . "</a>";
                }
                ?>
            </div>
        </li>
        <!-- Actor -->
        <li class="dropdown">
            <a href="#">Actor</a>
            <div class="dropdown-content">
                <?php
                $actorSearch = "SELECT * FROM casts WHERE Gender ='male'";
                $result = $conn->query($actorSearch);
                $count = 0;
                while($row = $result->fetch_assoc()){
                    if($count >= 4){
                        echo ' <a href="../userview/">See all</a> ';
                        break;
                    } else {
                        echo "<a href='../userview/languagemovie.php?language_name=".$row['Name']."'>" . $row['Name'] . "</a>";
                        $count++;
                    }
                }
                ?>
            </div>
        </li>

        <!--Actress -->
        <li class="dropdown">
            <a href="#">Actress</a>
            <div class="dropdown-content">
                <?php
                $actressSearch = "SELECT * FROM casts WHERE Gender ='female'";
                $result = $conn->query($actressSearch);
                $count = 0;
                while($row = $result->fetch_assoc()){
                    if($count >= 4){
                        echo ' <a href="../userview/">See all</a> ';
                        break;
                    } else {
                        echo "<a href='../userview/languagemovie.php?language_name=".$row['Name']."'>" . $row['Name'] . "</a>";
                        $count++;
                    }
                }
                ?>
            </div>
        </li>

        <!-- Director -->
        <li class="dropdown">
            <a href="#">Directors</a>
            <div class="dropdown-content">
                <?php
                $directorSearch = "SELECT * FROM directors ";
                $result = $conn->query($directorSearch);
                $count = 0;
                while($row = $result->fetch_assoc()){
                    if($count >= 4){
                        echo ' <a href="../userview/">See all</a> ';
                        break;
                    } else {
                        echo "<a href='../userview/languagemovie.php?language_name=".$row['Name']."'>" . $row['Name'] . "</a>";
                        $count++;
                    }
                }
                ?>
            </div>
        </li>

        <!--Producer-->
        
         <li class="dropdown">
            <a href="#">Producers</a>
            <div class="dropdown-content">
                <?php
                $directorSearch = "SELECT * FROM producer ";
                $result = $conn->query($directorSearch);
                $count = 0;
                while($row = $result->fetch_assoc()){
                    if($count >= 4){
                        echo ' <a href="../userview/">See all</a> ';
                        break;
                    } else {
                        echo "<a href='../userview/languagemovie.php?language_name=".$row['Name']."'>" . $row['Name'] . "</a>";
                        $count++;
                    }
                }
                ?>
            </div>
        </li>

        <!--Rating -->
        <li class="dropdown">
            <a href="#">Rating</a>
            <div class="dropdown-content">
               
                    <a href=''> Movie Rating</a>
                    <a href=''> Actor actrss  Rating</a>
                    <a href=''> Director  Rating</a>
                
        
            </div>
        </li>
         <!-- TOP 10 -->
         <li class="dropdown">
            <a href="#">TOP10</a>
            <div class="dropdown-content">
               
                    <a href=''> Movies</a>
                    <a href=''> Actor</a>
                    <a href=''> Actress</a>
                    <a href=''> Director</a>
                    
                
        
            </div>
        </li>
        


        <!--<li><a href="#">Watchlist</a></li> -->
        
        <li><a href="#">NEWS</a></li>

         <!-- Theater -->
         <li class="dropdown">
            <a href="#">Theater</a>
            <div class="dropdown-content">
                    <a href=''>List running movie shows</a>
                    <a href=''>Buy Movie Tickets</a>
                    <a href=''> Buy Food</a>
            </div>
        </li>
        <!--Coupons -->
        <li><a href="#">Coupons</a></li>
     <!--Notification -->
     <a href="../connection.php"><div class="user-image1">
        <img src="../image_bacground/NotificationIcon.png" alt="NotificationIcon">
    </div></a>

    <!--cart -->
    <a href="../connection.php"><div class="user-image1">
        <img src="../image_bacground/cartIcon.png" alt="NotificationIcon">
    </div></a>


       
    </ul>
    <form class="search-form" action="/search" method="GET">
        <div class="search-bar">
            <input type="text" name="query" placeholder="Search...">
        </div>
        <div class="submit-button">
            <button type="submit">Search</button>
        </div>
    </form>
    

    <!-- Profile corner-->
    <li class="dropdowncorner">
            <a href="../connection.php"><div class="user-image">
        <img src="../signup/signupimages/<?php echo $user_image; ?>" alt="User Image">
    </div></a>
            <div class="dropdown-contentcorner">
                    <a href=''>Edit Profile </a>
                    <a href=''>Chnage Password</a>
                    <a href=''>Order History</a>
                    <a href='' class='logout'>LogOUT</a>
                 
            </div>
          
        </li>
       









</header>
</body>
</html>
