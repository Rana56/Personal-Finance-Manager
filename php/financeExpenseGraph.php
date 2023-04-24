<?php
    header('Content-Type: application/json');
    session_start();

    if(isset($_GET['filter_data'])) {        
        $filterChoice = $_GET['filter_data'];

            try {
                include_once("../connectdb.php");

                //gets the user id from the user email stored in session data
                $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
                $userid->execute(array($_SESSION['username']));
                //gets the first row of pdo object
                $user = $userid->fetch();

                if ($filterChoice === "week"){
                    $qry = $db->prepare("SELECT date AS day, SUM(amount) as totalExpense FROM expense WHERE userID = :userid AND WEEK(date) = WEEK(CURRENT_DATE()) AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY DAY(date)");
                } 
                else if ($filterChoice === "month"){
                    $qry = $db->prepare("SELECT date AS day, SUM(amount) as totalExpense FROM expense WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY WEEK(date)");
                } 
                else if ($filterChoice === "year"){
                    $qry = $db->prepare("SELECT date AS day, SUM(amount) as totalExpense FROM expense WHERE userID = :userid AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY MONTH(date)");
                } 
                else if ($filterChoice === "all"){
                    $qry = $db->prepare("SELECT date AS day, SUM(amount) as totalExpense FROM expense WHERE userID = :userid GROUP BY YEAR(date)");
                } 
                else {
                    //echo "Request Error";
                    $qry = $db->prepare("SELECT date AS day, SUM(amount) as totalExpense FROM expense WHERE userID = :userid AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY WEEK(date)");
                }
                
                $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
                $qry->execute();

                //data structure
                $data = array();
                
                if($qry->rowCount() > 0){
                    while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
                        $data[] = array(
                            'date' => $row['day'],
                            'total' => $row['totalExpense']
                        );
                    }
                }
                else {
                    $data[] = array(
                        'category' => "No data",
                        'total' => 0
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
    }
?>