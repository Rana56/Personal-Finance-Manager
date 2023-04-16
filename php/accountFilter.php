<?php
    session_start();

    if(isset($_GET['filter_data'])) {        
        $filterChoice = $_GET['filter_data'];

        include("../connectdb.php");
        
        try {
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();


            if ($filterChoice === "week"){
                $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid AND WEEK(date) = WEEK(CURRENT_DATE()) AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                $qry_expense = $db->prepare("SELECT SUM(amount) AS monthExpense FROM expense WHERE userID = :userid AND WEEK(date) = WEEK(CURRENT_DATE()) AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                //echo $filterChoice;
            } 
            else if ($filterChoice === "month"){
                $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                $qry_expense = $db->prepare("SELECT SUM(amount) AS monthExpense FROM expense WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                //echo $filterChoice;
            } 
            else if ($filterChoice === "year"){
                $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid AND YEAR(date) = YEAR(CURRENT_DATE())");
                $qry_expense = $db->prepare("SELECT SUM(amount) AS monthExpense FROM expense WHERE userID = :userid AND YEAR(date) = YEAR(CURRENT_DATE())");
                //echo $filterChoice;
            } 
            else if ($filterChoice === "all"){
                $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid");
                $qry_expense = $db->prepare("SELECT SUM(amount) AS monthExpense FROM expense WHERE userID = :userid");
                //echo $filterChoice;
            } 
            else {
                //echo "Request Error";
                $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                $qry_expense = $db->prepare("SELECT SUM(amount) AS monthExpense FROM expense WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
                echo "else statement";
            }

            //total income for current month
            $qry_income->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $qry_income->execute();
            $qry_income = $qry_income->fetch();
            
            //total expense for current month
            $qry_expense->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $qry_expense->execute();
            $qry_expense = $qry_expense->fetch();
    
            //data
            $incomeMonth = $qry_income['monthIncome'];
            $expenseMonth = $qry_expense['monthExpense'];

            if ($incomeMonth == null){
                $incomeMonth = 0;
            }
            if ($expenseMonth == null){
                $expenseMonth = 0;
            }
            
            $data[] = array(
                'income' => floatval($incomeMonth),
                'expense' => floatval($expenseMonth)
            );

            echo json_encode($data);

        } catch (PDOException $ex) {
            echo $ex;
        }
        
        exit;
    }
?>