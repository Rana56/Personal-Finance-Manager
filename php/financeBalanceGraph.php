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
        $qry = $db->prepare("SELECT date AS day, SUM(amount) as totalIncome FROM income WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY DAY(date)");
        $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
        $qry->execute();

        $qry_income = $db->prepare("SELECT SUM(amount) AS monthIncome FROM income WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())");
        $qry_income->bindParam(':userid', $user['id'], PDO::PARAM_STR);
        $qry_income->execute();
        $qry_income = $qry_income->fetch();

        //data structure
        $data = array();
        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
            $data[] = array(
                'incomeDate' => $row['day'],
                'incomeTotal' => $row['totalIncome']
            );
        }

        //add total income for month
        //$data[0]['monthIncome'] = $row['monthIncome'];
        //array_push($data, array('monthIncome' => $row['monthIncome']));
        //$data['monthIncome'] = $row['monthIncome'];
        //$data[] = array('monthIncome' => $qry_income['monthIncome']);

        //Response for javascript - data category
        echo json_encode($data);
        
        exit;
    }
    catch (PDOException $ex) {
        echo json_encode(array("message" => $ex->getMessage()));
        exit;

    }
?>