<?php
    try {
        //gets the user id from the user email stored in session data
        $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
        $userid->execute(array($_SESSION['username']));
        //gets the first row of pdo object
        $user = $userid->fetch();
        
        //get budget amount
        $qstr = $db->prepare("SELECT budgets.amount, budgets.description, budgets.categoryID, categories.categoryName FROM budgets INNER JOIN categories ON budgets.categoryID = categories.categoryID WHERE budgets.userID = :userID");				//adds values to database, sql query
        $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
        $qstr->execute();
        
        //check if budgets empty
        if ($qstr->rowCount() > 0){
            #loop to get budgets
            foreach ( $qstr as $row){                                 
                $budgetMoney = $row['amount'];
                $category = $row['categoryName'];
                $categoryID = $row['categoryID'];
                $categoryMoney = 0;
                
                //get total from category from current month
                $qry = $db->prepare("SELECT categories.categoryName, SUM(expense.amount) AS total FROM expense INNER JOIN categories ON expense.categoryID=categories.categoryID WHERE expense.userID = :userid AND expense.categoryID = :category AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY categories.categoryName");
                $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                $qry->bindParam(':category', $categoryID, PDO::PARAM_STR);
                $qry->execute();
    
                //check if expense has category
                if ($qry->rowCount() > 0){
                    $categoryMoney = $qry->fetch()['total'];
                }
    
                //echo $categoryData['categoryName'] . '----' . $category['total'];
                $remainingPercent = (floatval($categoryMoney) / floatval($budgetMoney)) * 100; 
                
                if($remainingPercent >= 100){
                    echo "
                        <div class='goal'>
                            <h3>$category</h3>
                            <h4><span class='danger'>£ $categoryMoney</span> / <span class='success'>£ $budgetMoney</span></h4>
                        </div>
                        ";
                } 
                else{
                    echo "
                        <div class='goal'>
                            <h3>$category</h3>
                            <h4><span class='success'>£ $categoryMoney</span> / <span class='success'>£ $budgetMoney</span></h4>
                        </div>
                        ";
                }
                
            }

        } else{
            echo("<h3 class='warning'>Currently No Budgets</h3>");
        }
        
    }
    catch (PDOException $ex) {
        echo("<h4 class='warning'> Error - Failed to connect to the database.<br /> </h4>");
        echo($ex->getMessage());
        exit;

    }
?>