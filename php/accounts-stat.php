<?php 
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

        //data
        $lastincomeMonth = floatval($lastIncome['lastmonthIncome']);
        $lastexpenseMonth = floatval($lastExpense['lastmonthExpense']);
        
        $incomeChange = (($incomeMonth - $lastincomeMonth) / $lastincomeMonth) * 100;
        $expenseChange = (($expenseMonth - $lastexpenseMonth) / $lastexpenseMonth) * 100;
        
        //$incomeInfo = "<h3>Income Change: <span class='danger'>'$incomeChange'%<h3>";

        if($incomeChange < 0){
            echo "<h3>Income Decreased By: <span class='danger'>$incomeChange% </span><h3>";
        } else {
            echo "<h3>Income Increased By: <span class='success'>$incomeChange% </span><h3>";
        }

        echo "<hr class='dashed'>";

        if($expenseChange < 0){
            echo "<h3>Expense Decreased By: <span class='success'>$expenseChange% </span><h3>";
        } else {
            echo "<h3>Expense Increased By: <span class='danger'>$expenseChange% </span><h3>";
        }

    } catch (PDOException $ex) {
        echo $ex;
    }
?>