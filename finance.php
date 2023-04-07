<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <link rel="stylesheet" href="css/finance.css">
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
            } catch (PDOException $ex) {
                echo $ex;
            }
        ?>
        
        <!------------ Header ------------>
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

        <!------------ Main content ------------>
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
                    <a href="#" class="active">
                        <span class="material-icons-round">person_outline</span>
                        <h3>Finance</h3>
                    </a>
                    <a href="budget.php">
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

            <!------------ Income Popup ------------>
            <div class="popup" id="incomePopup">
                <span class="material-icons-round" id="popup-close-income">close</span>
                
                <form class="form" method="post" action="finance.php">
                    <h2>Enter <span style="color: #227459;">Income</span></h2>
                    <div class="form-element">
                        <label for="income-money">Amount</label>
                        <input type="text" id="income-money" placeholder="Enter Income - e.g. 20.00" required name="money-income">
                    </div>
                    <div class="form-element">
                        <label for="income-date">Date</label>
                        <input type="date" id="income-date" required name="date-income">
                    </div>
                    <div class="form-element">
                        <label for="income-note">Note</label>
                        <input type="text" id="income-note" required name="note-income">
                    </div>
                    <div class="form-element-select">
                        <label for="income-select">Category</label>
                        <select name="category-income" id="income-select" required>
                            <?php
                            include_once("connectdb.php");
                            try {
                                $qry = $db->prepare("SELECT * FROM categories ORDER BY categoryName ASC");
                                $qry->execute();

                                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                                    foreach ($qry as $row){                                         //loops trough queried object
                                        //adds path to image and creates id for buttons
                                        $category = $row["categoryName"];

                                        ?>
                                        <option value="<?=$category?>"><?=$category?></option>
                                        <?php
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

            <!------------ Expense Popup ------------>
            <div class="popup" id="expensePopup">
                <span class="material-icons-round" id="popup-close-expense">close</span>
                <form class="form" method="post" action="finance.php">
                    <h2>Enter <span style="color: #ad6d0d;">Expense</span></h2>
                    <div class="form-element">
                        <label for="expense-money">Amount</label>
                        <input type="text" id="expense-money" placeholder="Enter Expense - e.g. 20.00" required name="money-expense">
                    </div>
                    <div class="form-element">
                        <label for="expense-date">Date</label>
                        <input type="date" id="expense-date" required name="date-expense">
                    </div>
                    <div class="form-element">
                        <label for="expense-note">Note</label>
                        <input type="text" id="expense-note" required name="note-expense">
                    </div>
                    <div class="form-element-select">
                        <label for="expense-select">Note</label>
                        <select name="category-expense" id="expense-select" required>
                        <?php
                            include_once("connectdb.php");
                            try {
                                $qry = $db->prepare("SELECT * FROM categories ORDER BY categoryName ASC");
                                $qry->execute();

                                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                                    foreach ($qry as $row){                                         //loops trough queried object
                                        //adds path to image and creates id for buttons
                                        $category = $row["categoryName"];

                                        ?>
                                        <option value="<?=$category?>"><?=$category?></option>
                                        <?php
                                    }
                                }
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="submit-2">Submit</button>

                    <input type="hidden" name="expense-submit" value="true" />
                </form>
            </div>

            <!-- Main -->
            <main>
                <h1>Finance</h1>

                <div class="income-expense-btn">
                     <div class="add-product income" id="show-incomePopup">
                        <div>
                            <a href="#" ></a>
                            <span class="material-icons-round active">add</span>
                            <h3>Add Income</h3>
                        </div>
                    </div>
                    <div class="add-product expense" id="show-expensePopup">
                        <div>
                            <a href="#"></a>
                            <span class="material-icons-round active">add</span>
                            <h3>Add Expense</h3>
                        </div>
                    </div>
                </div>
               
                
                <!-- Recent Activities  -->
                <div class="recent-activity">
                    <h2>Recent Activites</h2>
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
                    <h2>Income</h2>
                    <div class="goals">
                        <div class="goal">
                            <h3>Goal Name</h3>
                            <h4>£250 / £350</h4>
                            <p><b>71% </b></p>
                        </div>
                        <div class="goal">
                            <h3>Goal Name</h3>
                            <h4>£50 / £450</h4>
                            <p><b>71% </b></p>
                        </div>
                        <div class="goal">
                            <h3>Goal Name</h3>
                            <h4>£30 / £10050</h4>
                            <p><b>1% </b></p>
                        </div>
                    </div>
                    <a href="#">Show All</a>
                </div>

                <!-- Tracking Content -->
                <div class="tracking-content">
                    <h2>Trackings</h2>
                    <div class="trackings">
                        <div class="item">
                            <!--
                            <div class="info">
                                <h3>Item Name</h3>
                                <h4>£250</h4>
                                <p><b>Price increase</b></p>
                            </div>
                            -->
                            <div class="info">
                                <h3>Item Name</h3>
                                <h4>£250</h4>
                                <p><b>Increase</b></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="info">
                                <h3>Item Name</h3>
                                <h4>£250</h4>
                                <p><b>Decrease</b></p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="info">
                                <h3>Item Name</h3>
                                <h4>£250</h4>
                                <p><b>No Change</b></p>
                            </div>
                        </div>
                        
                </div>

            </div>

        </div> 
    </body>

    <script src="Scripts/colourToggle.js"></script>
    <script src="Scripts/financePopup.js"></script>
</html>


<?php
    if (isset($_POST["income-submit"])){

        if (isset($_POST['money-income'])) {
            $money_income = $_POST['money-income'];
        
            if (!is_numeric($money_income)) {
                echo "<p class='text-danger text-center'>Invalid input - please enter a number</p>";
                exit();
            } else {
                $money_income = number_format((float)$money_income, 2, '.', '');
            }
        }

        if (isset($_POST["date-income"])){
            $date_income = $_POST['date-income'];
            
        } else {
            exit;
        }

        if (isset($_POST["note-income"])){
            $note_income = $_POST['note-income'];
            
        } else {
            exit;
        }

        if (isset($_POST["category-income"])){
            $category_income = $_POST['category-income'];
            
        } else {
            exit;
        }

        include("connectdb.php");
        
        try {
            
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();
            
            //get category id from database
            $categoryQry = $db->prepare("SELECT categoryID FROM categories WHERE categoryName = :category_name");
            $categoryQry->execute([':category_name' => $category_income]);
            $category_id = $categoryQry->fetch(PDO::FETCH_ASSOC);
            
            //insert income into database
            $qstr = $db->prepare("INSERT INTO income VALUES(null, :userID, :categoryID, :amount, :dates, :note)");				//adds values to database, sql query
            $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
            $qstr->bindParam(':categoryID', $category_id['categoryID'], PDO::PARAM_STR);
            $qstr->bindParam(':amount', $money_income, PDO::PARAM_STR);
            $qstr->bindParam(':dates', $date_income, PDO::PARAM_STR);
            $qstr->bindParam(':note', $note_income, PDO::PARAM_STR);

            $qstr->execute();

            header("Location: accounts.php");
            exit;
        }
        catch (PDOException $ex) {
            echo("<h4 class='notification'> Error - Failed to connect to the database.<br /> </h4>");
            echo($ex->getMessage());
            exit;
    
        }
        
    }
    
    
    if (isset($_POST["expense-submit"])){

        if (isset($_POST['money-expense'])) {
            $money_expense = $_POST['money-expense'];
        
            if (!is_numeric($money_expense)) {
                echo "<p class='text-danger text-center'>Invalid input - please enter a number</p>";
                exit();
            } else {
                $money_expense = number_format((float)$money_expense, 2, '.', '');
            }
        }

        if (isset($_POST["date-expense"])){
            $date_expense = $_POST['date-expense'];
        } else {
            exit;
        }

        if (isset($_POST["note-expense"])){
            $note_expense = $_POST['note-expense'];
        } else {
            exit;
        }

        if (isset($_POST["category-expense"])){
            $category_expense = $_POST['category-expense'];
        } else {
            exit;
        }

        include("connectdb.php");
        
        try {
            
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();
            
            //get category id from database
            $categoryQry = $db->prepare("SELECT categoryID FROM categories WHERE categoryName = :category_name");
            $categoryQry->execute([':category_name' => $category_expense]);
            $category_id = $categoryQry->fetch(PDO::FETCH_ASSOC);
            
            //insert income into database
            $qstr = $db->prepare("INSERT INTO expense VALUES(null, :userID, :categoryID, :amount, :dates, :note)");				//adds values to database, sql query
            $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
            $qstr->bindParam(':categoryID', $category_id['categoryID'], PDO::PARAM_STR);
            $qstr->bindParam(':amount', $money_expense, PDO::PARAM_STR);
            $qstr->bindParam(':dates', $date_expense, PDO::PARAM_STR);
            $qstr->bindParam(':note', $note_expense, PDO::PARAM_STR);

            $qstr->execute();

            header("Location: finance.php");
            exit;
        }
        catch (PDOException $ex) {
            echo("<h4 class='notification'> Error - Failed to connect to the database.<br /> </h4>");
            echo($ex->getMessage());
            exit;
    
        }
        
    }
?>