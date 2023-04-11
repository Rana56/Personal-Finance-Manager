<?php
    header('Content-Type: application/json');
    session_start();

    try {
        include_once("../connectdb.php");

        //gets the user id from the user email stored in session data
        $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
        $userid->execute(array($_SESSION['username']));
        //gets the first row of pdo object
        $user = $userid->fetch();
        
        //get budget amount
        $qstr = $db->prepare("SELECT budgets.amount, budgets.categoryID, categories.categoryName FROM budgets INNER JOIN categories ON budgets.categoryID = categories.categoryID WHERE budgets.userID = :userID");				//adds values to database, sql query
        $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
        $qstr->execute();

        //data structure
        $data = array();
        while ($row = $qstr->fetch(PDO::FETCH_ASSOC)){
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

            $data[] = array(
                'category' => $row['categoryName'],
                'budget' => $row['amount'],
                'categoryTotal' => $categoryMoney
            );
        }

        //Response for javascript - data category
        echo json_encode($data);
        
        exit;
    }
    catch (PDOException $ex) {
        echo json_encode(array("message" => $ex->getMessage()));
        exit;

    }
?>