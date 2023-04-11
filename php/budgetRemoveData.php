<?php
    session_start();

    if(isset($_POST['budget_id'])) {
        //row to be deleted
        
        $budgetID = $_POST['budget_id'];

        include_once("../connectdb.php");
        try {
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();

            //delete row
            $deleteqry = $db->prepare("DELETE FROM budgets WHERE budgetID = :budget_id AND userID = :userid");
            $deleteqry->bindParam(':budget_id', $budgetID, PDO::PARAM_STR);
            $deleteqry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $deleteqry->execute();
            
            //Reload budgets
            include('budgetLoad.php');

        } catch (PDOException $ex) {
            echo $ex;
        }

        exit;
    }
?>