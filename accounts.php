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

            <!-- Main -->
            <main>
                <h1>Account Overview</h1>

                <div class="date">
                    <input type="date">
                </div>

                <div class="insights">

                    <!-- Budget -->
                    <div class="remaining-budget">
                        <span class="material-icons-round">payments</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Remaining Budget</h3>
                                <h1>£200.00</h1>   
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>20%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">This month</small>
                    </div>

                    <!-- Expenses -->
                    <div class="expense">
                        <span class="material-icons-round">trending_down</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Expense</h3>
                                <h1>£100.00</h1>   
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>20%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">This month</small>
                    </div>

                    <!-- Expenses -->
                    <div class="income">
                        <span class="material-icons-round">trending_up</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Income</h3>
                                <h1>£300.00</h1>   
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>20%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">This month</small>
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
                    <h2>Budget Goals</h2>
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
                        <div class="item add-product">
                            <div>
                                <a href="#"></a>
                                <span class="material-icons-round active">add</span>
                                <h3>Add Product</h3>
                            </div>
                        </div>
                    </div>

                    <a href="#">Show All</a>
                </div>

            </div>

        </div> 
    </body>

    <script src="Scripts/colourToggle.js"></script>
    <!-- <script src="Scripts/accountFunctions.js"></script> -->
</html>