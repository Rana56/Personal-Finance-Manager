<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/money.png">
        <link rel="stylesheet" href="css/logout.css">
        <title>Final Year Project</title>
    </head>

    <body>
        <!-- Header-->
        <?php
            session_start();

            unset($_SESSION["username"]);               //removes the session variable username
        
        ?>

        <header id="top">
            <div class="logo">
                <p>Cash Control</p>
            </div>

            <div class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="savings.php">Savings</a></li>
                    <li><a href="trackings.php">Tracking</a></li>
                    <li id="login"><a href="login.php">Log-In</a></li>
                    <li id="register"><a href="signup.php">Sign-Up</a></li>
                </ul>
            </div>
        </header>

        <div class="intro">
            <div class="container">
                <h1>You have been logged out</h1>
                <p>Need to login again?</p>
                <button onclick="location.href='login.php'">Login</button>
            </div>
        </div>

    </body>

</html>