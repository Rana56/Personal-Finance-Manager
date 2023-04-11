<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <!-- Chart library -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>

        <link rel="stylesheet" href="css/budget.css">
    </head>

    <body>

        <?php
            session_start();
            //checks if user is logged in
            
            /*
            if (!isset($_SESSION['username'])){
                header("location:login.php");
                exit();
            }*/

            include_once("connectdb.php");

            try {
                //gets the user's name
                $fname = $db->prepare("SELECT first_name FROM user WHERE email = ?");
                $fname->execute(array($_SESSION['username']));
                $fname = $fname->fetch();

                //gets the user id from the user email stored in session data
                $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                $userid->execute(array($_SESSION['username']));
                //gets the first row of pdo object
                $user = $userid->fetch();
        
                $qry_income = $db->prepare("SELECT SUM(amount) AS total FROM budgets WHERE userID = :userid");
                $qry_income->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                $qry_income->execute();
                $qry_income = $qry_income->fetch();
        
                //data structure
                $totalBudget = $qry_income['total'];

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
                    <a href="budget.php" class="active">
                        <span class="material-icons-round">assignment</span>
                        <h3>Budget</h3>
                    </a>
                    <a href="#">
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

            <!------------ Budget Popup ------------>
            <div class="popup" id="budgetPopup">
                <span class="material-icons-round" id="popup-close-budget">close</span>
                
                <form class="form" method="post" id="budgetForm">
                    <h2>Enter <span style="color: #f0950e;">Budget</span></h2>
                    <div class="form-element">
                        <label for="budget-money">Amount</label>
                        <input type="text" id="budget-money" placeholder="Enter Budget - e.g. 20.00" required name="money-form">
                    </div>
                    <div class="form-element">
                        <label for="budget-note">Note</label>
                        <input type="text" id="budget-note" placeholder="Enter Note" required name="note-form">
                    </div>
                    <div class="form-element-select">
                        <label for="budget-select">Category</label>
                        <select name="category-form" id="budget-select" required>
                            <?php
                            include_once("connectdb.php");
                            try {
                                $qry = $db->prepare("SELECT * FROM categories ORDER BY categoryName ASC");
                                $qry->execute();
                                
                                //gets the user id from the user email stored in session data
                                $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                                $userid->execute(array($_SESSION['username']));
                                //gets the first row of pdo object
                                $user = $userid->fetch();

                                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                                    foreach ($qry as $row){                                         //loops trough queried object
                                        $category = $row["categoryName"];
                                        
                                        //check if category budget already added
                                        $check = $db->prepare("SELECT budgetID FROM budgets WHERE userID = :userid and categoryID = :cID");
                                        $check->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                        $check->bindParam(':cID', $row['categoryID'], PDO::PARAM_STR);
                                        $check->execute();

                                        if ($check->rowCount() == 0){
                                            ?>
                                                <option value="<?=$category?>"><?=$category?></option>
                                            <?php
                                        }
                                    }
                                }
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="submit-1">Submit</button>

                    <input type="hidden" name="income-submit" value="true" />
                </form>
            </div>

            <!-- Main -->
            <main>
                <h1>Budget</h1>

                <div class="budget-activity">
                    <h2>Budget Breakdown</h2>
                    <h3 id="totalInfo">Total Budget: 
                        <span class="success">£<?= $totalBudget?></span>
                    </h3>
                    
                    <div class="budgetGraph">
                        <canvas id="currentBalance" style="width:100%;max-width:700px" aria-label="Element not supported"></canvas>
                    </div>
                </div>

                <div class="budget-btn">
                    <div class="add-btn budget" id="show-budget">
                        <div>
                            <span class="material-icons-round active">add</span>
                            <h3>Add Budget</h3>
                        </div>
                    </div>
                    <!--
                    <div class="add-btn savings" id="show-saving">
                        <div>
                            <span class="material-icons-round active">add</span>
                            <h3>Add Savings Goal</h3>
                        </div>
                    </div>
                    -->
                </div>
                
                <!-- Budget  -->
                <div class="set-budgets">
                    <h2>Category Budgets</h2>
                    
                    <div class="trackedBudget" id="budgets">

                        <!-- Recent budggets  -->
                        <?php 
                            include_once("connectdb.php");

                            include('php/budgetLoad.php');
                        ?>

                    </div>
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

                <!-- Budget notes -->
                <div class="budget-note">
                    <h2>Notes</h2>
                    <div class="notes">
                        <?php
                            include_once("connectdb.php");
                            try {
                                
                                //gets the user id from the user email stored in session data
                                $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                                $userid->execute(array($_SESSION['username']));
                                //gets the first row of pdo object
                                $user = $userid->fetch();
                                
                                //check if category budget already added
                                $qry = $db->prepare("SELECT budgets.description, categories.categoryName FROM budgets INNER JOIN categories ON budgets.categoryID=categories.categoryID WHERE userID = :userid");
                                $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                $qry->execute();
                                
                                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                                    foreach ($qry as $row){                                         //loops trough queried object
                                        $category = $row["categoryName"];
                                        $description = $row["description"];
                                        
                                        ?>
                                        <div class="item">
                                            <div class="info">
                                                <h3><?=$category?></h3>
                                                <p><b><?=$description?></b></p>
                                            </div>
                                        </div>
                                        <?php
                                        
                                    }
                                }
                                else {
                                    echo "No Budget Notes";
                                }
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                            ?>
                        
                    </div>
                </div>

                <div class="budget-note">
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

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="Scripts/colourToggle.js"></script>
    <script src="Scripts/budget-popup.js"></script>
    <script src="Scripts/budget-change.js"></script>
    <script src="Scripts/budget-graph.js"></script>
</html> 