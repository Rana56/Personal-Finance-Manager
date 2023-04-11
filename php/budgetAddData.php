<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data

        if (isset($_POST['money-form'])) {
            $amount = $_POST['money-form'];
        
            if (!is_numeric($amount)) {
                echo "Invalid input - Please enter a number";
                exit();
            } else {
                $amount = number_format((float)$amount, 2, '.', '');
            }
        }

        if (isset($_POST["note-form"])){
            $note = $_POST['note-form'];
            
        } else {
            exit;
        }

        if (isset($_POST["category-form"])){
            $category = $_POST['category-form'];
            
        } else {
            exit;
        }

        session_start();

        try {
            include_once("../connectdb.php");

            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();
            
            //get category id from database
            $categoryQry = $db->prepare("SELECT categoryID FROM categories WHERE categoryName = :category_name");
            $categoryQry->execute([':category_name' => $category]);
            $category_id = $categoryQry->fetch(PDO::FETCH_ASSOC);

            $check = $db->prepare("SELECT * FROM budgets WHERE userID = :user AND categoryID = :category");
            $check->bindParam(':user', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
            $check->bindParam(':category', $category_id['categoryID'], PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() == 0){
                //insert income into database
                $qstr = $db->prepare("INSERT INTO budgets VALUES(null, :userID, :categoryID, :amount, :note, null, null)");				//adds values to database, sql query
                $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
                $qstr->bindParam(':categoryID', $category_id['categoryID'], PDO::PARAM_STR);
                $qstr->bindParam(':amount', $amount, PDO::PARAM_STR);
                $qstr->bindParam(':note', $note, PDO::PARAM_STR);

                $qstr->execute();

                echo "Budget Successfully Added";
                exit;
            }
            else {
                echo "Error: Budget Already Added";
                exit;
            }

            

        }
        catch (PDOException $ex) {
            echo("Error - Failed to connect to the database.");
            echo($ex->getMessage());
            exit;
    
        }
    }

    
?>
