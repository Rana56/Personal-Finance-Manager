<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <link rel="stylesheet" href="css/accounts.css">
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
                    <a href="#" class="active">
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
                    <a href="goals.php">
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
                <h1>Account Overview</h1>

                <div class="dropdown">
                    <div class="select">
                        <span class="selected">
                            This Month
                        </span>
                        <div class="caret"></div>
                    </div>
                    <ul class="menu">
                        <li><a href="#" onclick="loadFilter('week')">This Week</a></li>
                        <li class="active"><a href="#" onclick="loadFilter('month')">This Month</a></li>
                        <li><a href="#" onclick="loadFilter('year')">This Year</a></li>
                        <li><a href="#" onclick="loadFilter('all')">All</a></li>
                    </ul>
                </div>

                <div class="insights">
                    <!-- Budget -->
                    <!-- <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>20%</p>
                                </div>
                            </div> -->

                    <div class="remaining-budget">
                        <span class="material-icons-round">payments</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Balance</h3>
                                <?php             
                                    include_once("connectdb.php");

                                    try {
                                        //gets the user id from the user email stored in session data
                                        $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                                        $userid->execute(array($_SESSION['username']));
                                        //gets the first row of pdo object
                                        $user = $userid->fetch();

                                        //overall balance
                                        $balance_income = $db->prepare("SELECT SUM(amount) AS bIncome FROM income WHERE userID = :userid");
                                        $balance_income->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                        $balance_income->execute();
                                        $balance_income = $balance_income->fetch();

                                        $balance_expense = $db->prepare("SELECT SUM(amount) AS bExpense FROM expense WHERE userID = :userid");
                                        $balance_expense->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                        $balance_expense->execute();
                                        $balance_expense = $balance_expense->fetch();
                                        
                                        $totalBalance = floatval($balance_income['bIncome']) - floatval($balance_expense['bExpense']);
                                        if($totalBalance < 0){
                                            echo "<h1 class='danger'>£$totalBalance</h1> ";
                                        }
                                        else {
                                            echo "<h1 class='success'>£$totalBalance</h1> ";
                                        }

                                    } catch (PDOException $ex) {
                                        echo $ex;
                                    }
                                ?>
                                  
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="25"></circle>
                                </svg>
                            </div>
                        </div>
                        <small class="text-muted">Overall</small>
                    </div>

                    <!-- Expenses -->
                    <div class="expense">
                        <span class="material-icons-round">trending_down</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Expense</h3>
                                <h1 id="filterExpense"></h1>   
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="25"></circle>
                                </svg>
                            </div>
                        </div>
                        <small class="text-muted filterDetails">This month</small>
                    </div>

                    <!-- Expenses -->
                    <div class="income">
                        <span class="material-icons-round">trending_up</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Income</h3>
                                <h1 id="filterIncome"></h1>   
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="25"></circle>
                                </svg>
                            </div>
                        </div>
                        <small class="text-muted filterDetails">This month</small>
                    </div>
                </div>

                <!-- Recent Activities  -->
                <div class="recent-activity">
                    <h2>Recent Activites</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Money</th>
                                <th>Date</th>
                                <th>Note</th>
                                <th>Type</th>
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
                                $qry = $db->prepare("SELECT * FROM income where userID = :userid ORDER BY date DESC");
                                $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                $qry->execute();

                                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                                    $i = 0;

                                    //loop 5 times or less
                                    while (($row = $qry->fetch(PDO::FETCH_ASSOC)) && ($i < 4)){
                                        $money = '£' . $row['amount'];
                                        $date = $row['date'];
                                        $note = $row['note'];
                                        ?>

                                        <tr>
                                            <td  class="success"><?= $money ?></td>
                                            <td><?= $date ?></td>
                                            <td><?= $note ?></td>
                                            <td class="success">Income</td>
                                        </tr>

                                        <?php
                                        $i++;
                                    }                                    
                                }                                     
                                else {
                                    echo("<h4 class='warning' style='margin-bottom: 5px;'>Currently No Income Activties </h4>");
                                }
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                        ?>
                        </tbody>
                        <tbody>
                        <?php
                            try {
                                //expense recent
                                $qryE = $db->prepare("SELECT * FROM expense where userID = :userid ORDER BY date DESC");
                                $qryE->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                $qryE->execute();

                                if ($qryE->rowCount() > 0){                                     //checks if a rows are returned
                                    $i = 0;

                                    while (($row = $qryE->fetch(PDO::FETCH_ASSOC)) && ($i < 4)){
                                        $money = '£' . $row['amount'];
                                        $date = $row['date'];
                                        $note = $row['note'];
                                        ?>

                                        <tr>
                                            <td  class="danger"><?= $money ?></td>
                                            <td><?= $date ?></td>
                                            <td><?= $note ?></td>
                                            <td class="danger">Expense</td>
                                        </tr>

                                        <?php
                                        $i++;
                                    }
                                    
                                }                                     
                                else {
                                    echo("<h4 class='warning' style='margin-bottom: 5px;'>Currently Expense Activties </h4>");
                                }
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                        ?>
                        </tbody>
                    </table>

                    <a href="finance.php">Show All</a>
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

                <!-- Tracking Content -->
                <div class="tracking-content">
                    <h2>Progress</h2>
                    <div class="trackings">
                        <div class="item">
                            <h3>This month</h3>
                            <hr class='dashed'>
                            <?php 
                                            
                                include_once("connectdb.php");
                                try {                                    
                                    //total income for last month
                                    $lastIncome = $db->prepare("SELECT SUM(amount) AS lastmonthIncome FROM income WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(date) = YEAR(CURRENT_DATE())");
                                    $lastIncome->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                    $lastIncome->execute();
                                    $lastIncome = $lastIncome->fetch();
                                    
                                    //total expense for last month
                                    $lastExpense = $db->prepare("SELECT SUM(amount) AS lastmonthExpense FROM expense WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(date) = YEAR(CURRENT_DATE())");
                                    $lastExpense->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                    $lastExpense->execute();
                                    $lastExpense = $lastExpense->fetch();

                                    //total income for current month
                                    $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                                    $qry_income->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                    $qry_income->execute();
                                    $qry_income = $qry_income->fetch();
                                    
                                    //total expense for current month
                                    $qry_expense = $db->prepare("SELECT SUM(amount) AS monthExpense FROM expense WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                                    $qry_expense->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                                    $qry_expense->execute();
                                    $qry_expense = $qry_expense->fetch();
                            
                                    //data
                                    $incomeMonth = $qry_income['monthIncome'];
                                    $expenseMonth = $qry_expense['monthExpense'];
                            
                                    //data
                                    $lastincomeMonth = floatval($lastIncome['lastmonthIncome']);
                                    $lastexpenseMonth = floatval($lastExpense['lastmonthExpense']);
                                    
                                    if ($lastincomeMonth == 0){
                                        $incomeChange = 0;
                                    }
                                    else{
                                        $incomeChange = (($incomeMonth - $lastincomeMonth) / $lastincomeMonth) * 100;
                                    }
                                    
                                    if ($lastexpenseMonth == 0){
                                        $expenseChange = 0;
                                    } 
                                    else {
                                        $expenseChange = (($incomeMonth - $lastincomeMonth) / $lastincomeMonth) * 100;
                                    }

                                    $incomeStat = number_format($incomeChange, 1);
                                    $expenseStat = number_format($expenseChange, 1);
                                    
                                    //$incomeInfo = "<h3>Income Change: <span class='danger'>'$incomeChange'%<h3>";

                                    if($incomeChange < 0){
                                        echo "<h3>Income Decreased By: <span class='danger'>$incomeStat% </span><h3>";
                                    } else {
                                        echo "<h3>Income Increased By: <span class='success'>$incomeStat% </span><h3>";
                                    }

                                    if($expenseChange < 0){
                                        echo "<h3>Expense Decreased By: <span class='success'>$expenseStat% </span><h3>";
                                    } else {
                                        echo "<h3>Expense Increased By: <span class='danger'>$expenseStat% </span><h3>";
                                    }
                            
                                } catch (PDOException $ex) {
                                    echo $ex;
                                }

                            ?>
                            
                        </div>

                        <div class="item encourage">
                            <span class="material-icons-round active">sentiment_very_satisfied</span>

                            <?php
                                include_once("connectdb.php");
                                try {
                                    
                                    //gets random row
                                    $qry = $db->prepare("SELECT * FROM encouragement ORDER BY RAND() LIMIT 1");
                                    $qry->execute();
                                    $sentence = $qry->fetch()['sentence'];

                                    echo "<p>$sentence</p>";

                                } catch (PDOException $ex) {
                                    echo $ex;
                                }
                            ?>
                        </div>    
                    </div>
                </div>

                <!-- Budget Content -->
                <div class="budget-goals">
                    <h2>Budgets</h2>
                    <div class="goals">                      
                        <?php
                            include_once("connectdb.php");
                            
                            include("php/accountBudgetLoad.php")
                        ?>
                    </div>

                    <div class="add-product" onclick="window.location.href='budget.php'">
                        <div>
                            <a href="budget.php"></a>
                            <span class="material-icons-round active">add</span>
                            <h3>Add Budget</h3>
                        </div>
                    </div>
                </div>

            </div>

        </div> 
    </body>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="Scripts/colourToggle.js"></script>
    <script src="Scripts/account-filter.js"></script>
    <!-- <script src="Scripts/accountFunctions.js"></script> -->
</html>