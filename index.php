<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/home.css">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
    </head>

    <body>
        <!-- Header-->
        <?php
            include("php/header.php");
        ?>


        <!-- Intro -->
        <div class="intro">
            <div class="container">
                <h1 id="typing"></h1>
                <p>Take Control of Your Fiances, One Click at a Time: Your Personal Finance Manager</p>
                <button>See More</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="slideshow">
            <div class="slides">
                <div class="container">
                    <img src="Images/budget.png" alt="Image">
                    <div class="slide-text">
                        <h2>Organise your money</h2>
                        <p>Improve your savings and set goals to stay on track</p>
                    </div>
                </div>
            </div>

            <div class="slides">
                <div class="container">
                    <img src="Images/dartboard.png" alt="Image">
                    <div class="slide-text">
                        <h2>Track your spending habits and budget</h2>
                        <p>Change your relationship with money using a friendly method for managing your finances</p>
                    </div>
                </div>
            </div>
            
            <div class="slides">
                <div class="container">
                    <img src="Images/wallet.png" alt="Image">
                    <div class="slide-text">
                        <h2>Save money and get deals</h2>
                        <p>Track products and get notified when the price reduce</p>
                    </div>
                </div>
            </div>

            <!-- Nav Buttons -->
            <a class="prev" onclick="slideChange(-1)">&#10094;</a>
            <a class="next" onclick="slideChange(1)">&#10095;</a>
        </div>

        <div class="dots-box">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <div class="homeContent">
            <div class="container">
                <h1>Get started for 
                    <span style="color: #5959c5;">free</span>
                </h1>
                <p>Track your expenditures, Set goals and Budget like a Pro</p>
            </div>
        </div>
        
        <!-- Footer -->
        <footer>
            <h3>Cash Control</h3>
            <p>Built By Chirag</p>
            <a href="#top">Back to top</a>
        </footer>
    
    </body>

    <script src="Scripts/wordType.js"></script>
    <script src="Scripts/slideshow.js"></script>
</html>