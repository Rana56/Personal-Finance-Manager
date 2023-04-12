<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <link rel="stylesheet" href="css/accountTrack.css">
    </head>

    <body>

        <?php
            session_start();
            //checks if user is logged in
            
            if (!isset($_SESSION['username'])){
                header("Location: login.php");
                exit();
            }
            
            include_once("connectdb.php");

            try {
                //gets the user's name
                $fname = $db->prepare("SELECT first_name FROM user WHERE email = ?");
                $fname->execute(array($_SESSION['username']));
                $fname = $fname->fetch();
            } catch (PDOException $ex) {
                echo $ex;
            }
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
                    <li id="logout"><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <!-- Sidebar -->
            <aside>
                <div class="top">
                    <div class="logo">
                        <p>Cash Control</p>
                    </div>
                    <div class="closeTab" id="close-btn">
                        <span class="material-icons-round">close</span>
                    </div>
                </div>

                <div class="sidebar">
                    <a href="accounts.php">
                        <span class="material-icons-round">grid_view</span>
                        <h3>Overview</h3>
                    </a>
                    <a href="finance.php">
                        <span class="material-icons-round">person_outline</span>
                        <h3>Finance</h3>
                    </a>
                    <a href="budget.php">
                        <span class="material-icons-round">assignment</span>
                        <h3>Budget</h3>
                    </a>
                    <a href="accountTrack.php" class="active">
                        <span class="material-icons-round">insights</span>
                        <h3>Tracking</h3>
                    </a>
                    <a href="#">
                        <span class="material-icons-round">settings</span>
                        <h3>Settings</h3>
                    </a>
                    <a href="logout.php">
                        <span class="material-icons-round">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>

            <!-- Main -->
            <main>
                <h1>Trackings</h1>
                <h2>Enter your product link to start tracking</h2>

                <div class="center">
                    <div class="track">
                        <form class="form">
                            <div class="form-element">
                                <label for="itemName">Item Name</label>
                                <input type="text" id="itemName" placeholder="Enter Item Name" required name="money-form">
                            </div>
                            <div class="form-element">
                                <label for="url">URL</label>
                                <input type="text" id="url" placeholder="Enter Amazon Item URL - e.g. https://www.amazon.co.uk" required name="money-form">
                            </div>
                            <div class="form-element">
                                <label for="money">Amount</label>
                                <input type="text" id="money" placeholder="Enter Alert Amount" required name="money-form">
                            </div>
    
                            <button type="submit" name="submit-1">Add</button>
    
                            <input type="hidden" name="form-submit" value="true" />
                        </form>
                        
                    </div>         

                </div>

                <!-- Recent Activities  -->
                <div class="recent-activity">
                    <h2>Tracked Items</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Money</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tesco</td>
                                <td>24/3/2023</td>
                                <td class="danger">Expense</td>
                                <td class="warning">£20</td>
                            </tr>
                            <tr>
                                <td>Test</td>
                                <td>24/3/2023</td>
                                <td class="danger">Expense</td>
                                <td class="warning">£20</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="#">Show All</a>
                </div>

                <?php
                    //include_once('php/webScrape.php');
                ?>
            </main>

            <div class="right">
                <!-- Info Top -->
                <div class="top">
                    <button id="menu_btn">
                        <span class="material-icons-round">menu</span>
                    </button>
                    <div class="colour-toggle">
                        <span class="material-icons-round active">light_mode</span>
                        <span class="material-icons-round">nightlight</span>
                    </div>
                    <div class="profile">
                        <div class="info">
                            <h3>Hi, <?= $fname["first_name"] ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Budget Content -->
                <div class="budget-goals">
                <h2>Learn More</h2>
                    <div class="card-container">
                        <?php
                        try {
                        //gets random row
                        $qry = $db->prepare("SELECT * FROM resources ORDER bY RAND() LIMIT 2");
                        $qry->execute();

                        if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                            foreach ($qry as $row){                                         //loops trough queried object
                                //adds path to image and creates id for buttons
                                $image = "images/resources/" . $row["image"];
                                $title =  $row["title"];
                                $text = $row["text"];
                                $link = $row["link"];
                                ?>
                                
                                <div class="card">
                                    <div class="card-img" style="background-image: url(<?= $image ?>);"></div>
                                    <div class="card-content">
                                        <h2> <?= $title ?> </h2>
                                        <p> <?= $text ?> </p>
                                        
                                    </div>
                                    <div class="card-link">
                                            <a href="<?= $link ?>">Read More</a>
                                    </div>
                                    
                                </div>

                                <?php
                                }
                            }
                        } catch (PDOException $ex) {
                            echo $ex;
                        }
                        ?>
                    </div>
                </div>

            </div>

        </div> 
    </body>

    <script src="Scripts/colourToggle.js"></script>
    <!-- <script src="Scripts/accountFunctions.js"></script> -->
</html>