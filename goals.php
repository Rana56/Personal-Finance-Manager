<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <link rel="stylesheet" href="css/goals.css">
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
                    <!--<li><a href="trackings.php">Tracking</a></li>-->
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
                    <a href="goals.php" class="active">
                        <span class="material-icons-round">insights</span>
                        <h3>Goals</h3>
                    </a>
                    <!--
                    <a href="#">
                        <span class="material-icons-round">settings</span>
                        <h3>Settings</h3>
                    </a> -->
                    <a href="logout.php">
                        <span class="material-icons-round">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>

            <!-- Main -->
            <main>
                <h1>Goals</h1>
                <h2>Enter your goals</h2>

                <div class="center">
                    <div class="track">
                        <form class="form" id="goalForm">
                            <div class="form-element">
                                <label for="itemName">Goal Name</label>
                                <input type="text" id="itemName" placeholder="Enter Goal Name" required name="goal-name">
                            </div>
                            <div class="form-element">
                                <label for="url">Note</label>
                                <input type="text" id="url" placeholder="Enter details about your goals" required name="notes">
                            </div>
    
                            <button type="submit" name="submit-1">Add</button>
    
                            <input type="hidden" name="form-submit" value="true" />
                        </form>
                        
                    </div>         

                </div>

                <!-- Recent Activities  -->
                <div class="recent-activity">
                    <h2>Goals</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include_once("connectdb.php");
                            try {
                                //gets the user id from the user email stored in session data
                                $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                                $userid->execute(array($_SESSION['username']));
                                //gets the first row of pdo object
                                $user = $userid->fetch();
                                
                                //gets data in descening - i.e. most recent
                                $qry = $db->prepare("SELECT * FROM goals where userID = :userid");
                                $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                $qry->execute();

                                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                                    $i = 0;

                                    //loop 5 times or less
                                    while (($row = $qry->fetch(PDO::FETCH_ASSOC))){
                                        $goalID = $row['goal_ID'];
                                        $goal = $row['goalName'];
                                        $note = $row['note'];
                                        
                                        ?>

                                        <tr>
                                        <td><?= $goal ?></td>
                                        <td><?= $note ?></td>
                                        <td>
                                            <button class="remove-goal" type="button" data-goal-id="<?=$goalID?>">
                                                Remove
                                            </button>
                                        </td>
                                        </tr>

                                        <?php
                                    }
                                    
                                }                                     
                                else {
                                    echo("<h4 class='warning' style='margin-bottom: 5px;'>Currently no goals</h4>");
                                }
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                        ?>
                        </tbody>
                    </table>
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

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="Scripts/colourToggle.js"></script>
    <script src="Scripts/goal-change.js"></script>
    <!-- <script src="Scripts/accountFunctions.js"></script> -->
</html>