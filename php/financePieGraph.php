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
        
        //get category id from database
        $qry = $db->prepare("SELECT categories.categoryName, SUM(expense.amount) AS total FROM expense INNER JOIN categories ON expense.categoryID=categories.categoryID WHERE expense.userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY categories.categoryName");
        $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
        $qry->execute();
        
        //data structure
        $data = array();
        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
            $data[] = array(
                'category' => $row['categoryName'],
                'total' => $row['total']
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