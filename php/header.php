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
                    <li class="dropdown">
                        <div class="dropdownMain">
                            <a href="#">Account</a>
                            <span class="material-icons-round">arrow_drop_down</span>
                        </div>
                        
                        <div class="dropdown-content">
                            <a href="accounts.php" id="myAccount">My Account</a>
                            <a id="logout" href="logout.php">Logout</a>
                        </div>
                    </li>
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
                    <li id="login"><a href="login.php">Login</a></li>
                    <li id="register"><a href="signup.php">Sign Up</a></li>
                </ul>
            </div>
        </header>
        
        <?php
    }
?>



