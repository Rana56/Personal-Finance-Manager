<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data

        if (isset($_POST["goal-name"])){
            $name = $_POST['goal-name'];
        } else {
            exit;
            echo "Please enter a goal name";
        }

        if (isset($_POST["notes"])){
            $note = $_POST['notes'];
            
        } else {
            exit;
            echo "Please enter details of the goal";
        }

        session_start();
        
        try {
            include_once("../connectdb.php");

            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();

            //insert income into database
            $qstr = $db->prepare("INSERT INTO goals VALUES(null, :userID, :goal, :note)");				//adds values to database, sql query
            $qstr->bindParam(':userID', $user['id'], PDO::PARAM_STR);								//binds a parameter to a specific variable name
            $qstr->bindParam(':goal', $name, PDO::PARAM_STR);
            $qstr->bindParam(':note', $note, PDO::PARAM_STR);

            $qstr->execute();

            echo "Goal Successfully Added";
            exit;

        }
        catch (PDOException $ex) {
            echo("Error Inserting Data.");
            echo($ex->getMessage());
            exit;
    
        }
    }

    
?>
