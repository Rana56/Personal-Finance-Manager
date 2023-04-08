<!DOCTYPE html>
<html lang="en">
    <style>
        /* Palette colours: 22223b, 4a4e69, f2e9e4, 9a8c98, c9ada7*/
        :root {
            --text-primary: #f2e9e4;
            --text-secondary: #3B3B22;
            --text-3: #dfd7e6;

            --account-bg: #f1f1f1;
            --bg: #22223b;
            --bg-secondary: #9a8c98;
            --bg-dark: #101042;
            --bg-light: #e1dde5;
            --bg-3: #5a5a9c;
            --sidebar: #e1dde5;
            --links: #5a5a9c;

            --colour-danger: #e75461;
            --colour-success: #31ad84;
            --colour-warning: #f0950e;
            --colour-info-dark: #39393d;

            --box-shadow: 3rem 3rem 2rem var(--text-3);
            --alternate-shadow: #1d1d5a;
        }

        * {
            box-sizing: border-box;
        }

        @font-face {
            font-family: mont;
            src: url(../Fonts/Montserrat-VariableFont_wght.ttf);
        }

        html {
            scroll-behavior: smooth;
        }

        body{
            margin: 0;
            padding: 0;
            background-color: var(--bg);
            color: var(--text-primary);
            font-family: mont;
        }
        /* Header */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0px 9%;
            background-color: var(--bg);
        }

        .logo {
            font-size: larger;
            font-weight: bold;
        }

        .navbar {
            padding: 15px;
        }

        .navbar ul {
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar li {
            list-style: none;
            border-radius: 100px;
            margin-inline: 5px;
            
        }

        /* Style of links in navigation bar */
        .navbar li a {
            color: var(--text-primary);
            text-decoration: none; /* Property removes the underline */
            font-size: 20px;
            padding: 14px 16px;
            transition: background-color 0.5s cubic-bezier(0.4, 0, 0.2, 1) 0s, color 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s;
            display: block;
            border-radius: 100px;
            text-align: center;
        }

        .navbar a:hover {
            background-color: var(--text-primary);
            color: #22223b;
            border-radius: 100px;
        }

        .navbar a.active {
            background-color: var(--text-primary);
            color: #22223b;
            border-radius: 100px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
        }

        .dropdown-content a {
            margin: 2px 0px 2px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        
    </style>
    <body>
        <?php
            session_start();
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
                    <li class="dropdown">
                        <a href="#">Account</a>
                        <div class="dropdown-content">
                            <a href="accounts.php">My Account</a>
                            <a logout href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <div class="popup" id="incomePopup">
            <span class="material-icons-round" id="popup-close-income">close</span>
            
            <form class="form" method="post" action="Test.php">
                <h2>Enter Income</h2>
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

                <input type="hidden" name="expense-submit" value="true" />
            </form>
        </div>

        <canvas id="pieChart"></canvas>

        <?php
            include_once("connectdb.php");

            try {
                //gets the user id from the user email stored in session data
                $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                $userid->execute(array($_SESSION['username']));
                //gets the first row of pdo object
                $user = $userid->fetch();
                
                //get category id from database
                $qry = $db->prepare("SELECT categories.categoryName, SUM(expense.amount) AS total FROM expenses INNER JOIN categories ON expense.categoryID = categories.categoryID WHERE userID = :userid");
                $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                
                //data structure
                $data = array();
                while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                    echo($row['categoryName']);
                    echo($row['total']);
                    $data[] = array(
                        'category' => $row['categoryName'],
                        'total' => $row['total']
                    );
                }
                
                exit;
            }
            catch (PDOException $ex) {
                echo("<h4 class='warning'> Error - Failed to connect to the database.<br /> </h4>");
                echo($ex->getMessage());
                exit;

            }
        ?>

        <script>
            //changes data into json data e.e. {"Peter":35,"Ben":37,"Joe":43}
            var data = <?php echo json_encode($data); ?>;
            var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9",
                "#1e7145"
            ];
            
            //gets the drawing functions to draw on canvas 
            var context = document.getElementById("pieChart").getContext("2d");
            var myChart = new Chart(context, {
                type: 'pie',
                data: {
                    labels: data.map(item => item.category),
                    dataset:[{
                        backgroundColor: barColors,
                        data: data.map(item => item.total),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    </body>

</html>

<?php
    if (isset($_POST["expense-submit"])){

        if (isset($_POST['money-income'])) {
            $money_income = $_POST['money-income'];
        
            if (!is_numeric($money_income)) {
                echo "<p class='text-danger text-center'>Invalid input - please enter a number</p>";
                exit();
            } else {
                $money_income = number_format((float)$money_income, 2, '.', '');
                echo $money_income . '    --   ' . gettype(floatval($money_income));
            }
        }

        if (isset($_POST["date-income"])){
            $date_income = $_POST['date-income'];
            echo $date_income . '    --   ';
        } else {
            echo "<p class='text-danger text-center'>Please enter a date </p>";
            exit;
        }

        if (isset($_POST["note-income"])){
            $note_income = $_POST['note-income'];
            echo $note_income . '    --   ';
        } else {
            echo "<p class='text-danger text-center'>Please enter a note or type N/A </p>";
            exit;
        }

        if (isset($_POST["category-income"])){
            $category_income = $_POST['category-income'];
            echo $category_income . '    --   ';
        } else {
            echo "<p class='text-danger text-center'>Please select a category </p>";
            exit;
        }

        include("connectdb.php");
        
        try {
            
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();
            echo gettype( $user['id']) . '    --   ';
            
            //get category id from database
            $categoryQry = $db->prepare("SELECT categoryID FROM categories WHERE categoryName = :category_name");
            $categoryQry->execute([':category_name' => $category_income]);
            $category_id = $categoryQry->fetch(PDO::FETCH_ASSOC);
            echo $category_id['categoryID'] . '    --   ';

            
            //insert income into database
            $qstr = $db->prepare("INSERT INTO expense VALUES(null, :userID, :categoryID, :amount, :dates, :note)");				//adds values to database, sql query
            $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
            $qstr->bindParam(':categoryID', $category_id['categoryID'], PDO::PARAM_STR);
            $qstr->bindParam(':amount', $money_income, PDO::PARAM_STR);
            $qstr->bindParam(':dates', $date_income, PDO::PARAM_STR);
            $qstr->bindParam(':note', $note_income, PDO::PARAM_STR);

            $qstr->execute();

            header('Location: Test.php');
            echo "success";
        }
        catch (PDOException $ex) {
            echo("<h4 class='notification'> Error - Failed to connect to the database.<br /> </h4>");
            echo($ex->getMessage());
            exit;
    
        }
        
        
    }
    //refresh page after inputing to database
?>

