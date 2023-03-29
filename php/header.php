<?php
    session_start();

    if (isset($_SESSION['username'])){
        ?>
        <!--Header if logged in-->
        <header id="top">
            <div class="logo">
                <p>Cash Control</p>
            </div>
<!--
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
-->
            <div class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="savings.php">Savings</a></li>
                    <li><a href="trackings.php">Tracking</a></li>
                    <li><a href="accounts.php">Account</a></li>
                    <li id="logout"><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </header>

        <?php
    }   
    else{
        ?>

        <!--Header if not logged in-->
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
        
        <?php
    }
?>



