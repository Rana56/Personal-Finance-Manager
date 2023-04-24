<?php
    session_start();

    if(isset($_POST['goal_id'])) {
        //row to be deleted
        
        $goalID = $_POST['goal_id'];

        include_once("../connectdb.php");
        try {
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();

            //delete row
            $deleteqry = $db->prepare("DELETE FROM goals WHERE goal_ID = :goal_id AND userID = :userid");
            $deleteqry->bindParam(':goal_id', $goalID, PDO::PARAM_STR);
            $deleteqry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $deleteqry->execute();

        } catch (PDOException $ex) {
            echo $ex;
        }

        exit;
    }
?>