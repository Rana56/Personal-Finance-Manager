<?php
    session_start();

    if(isset($_POST['expense_id'])) {
        //row to be deleted
        $expenseID = $_POST['expense_id'];

        include_once("../connectdb.php");
        try {
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();

            //delete row
            $deleteqry = $db->prepare("DELETE FROM expense WHERE expenseID = :expense_id AND userID = :userid");
            $deleteqry->bindParam(':expense_id', $expenseID, PDO::PARAM_STR);
            $deleteqry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $deleteqry->execute();
            
            //gets data in descening - i.e. most recent
            $qry = $db->prepare("SELECT * FROM expense where userID = :userid ORDER BY date DESC");
            $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $qry->execute();

            if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                $i = 0;

                //loop 5 times or less
                while (($row = $qry->fetch(PDO::FETCH_ASSOC)) && ($i < 4)){
                    $money = '£' . $row['amount'];
                    $expense = $row['date'];
                    $note = $row['note'];
                    $expenseID = $row['expenseID'];
                    ?>

                    <tr>
                    <td  class="danger"><?= $money ?></td>
                    <td><?= $expense ?></td>
                    <td><?= $note ?></td>
                    <td>
                        <button class="remove-expense" type="button" data-expense-id="<?=$expenseID?>">
                            Remove
                        </button>
                    </td>
                    </tr>

                    <?php
                    $i++;
                }
                
            }                                     
            else {
                echo("<h4 class='warning'>Currently no expenses</h4>");
            }
        } catch (PDOException $ex) {
            echo $ex;
        }

        exit;
    }

    if(isset($_POST['income_id'])) {
        $incomeID = $_POST['income_id'];

        include_once("../connectdb.php");
        try {
            //gets the user id from the user email stored in session data
            $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
            $userid->execute(array($_SESSION['username']));
            //gets the first row of pdo object
            $user = $userid->fetch();

            //delete row
            $deleteqry = $db->prepare("DELETE FROM income WHERE incomeID = :income_id AND userID = :userid");
            $deleteqry->bindParam(':income_id', $incomeID, PDO::PARAM_INT);
            $deleteqry->bindParam(':userid', $user['id'], PDO::PARAM_INT);
            $deleteqry->execute();
            
            //gets data in descening - i.e. most recent
            $qry = $db->prepare("SELECT * FROM income where userID = :userid ORDER BY date DESC");
            $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
            $qry->execute();

            if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                $i = 0;

                //loop 5 times or less
                while (($row = $qry->fetch(PDO::FETCH_ASSOC)) && ($i < 4)){
                    $money = '£' . $row['amount'];
                    $income = $row['date'];
                    $note = $row['note'];
                    $incomeID = $row['incomeID'];
                    ?>

                    <tr>
                    <td  class="success"><?= $money ?></td>
                    <td><?= $income ?></td>
                    <td><?= $note ?></td>
                    <td>
                        <button class="remove-income" type="button" data-income-id="<?=$incomeID?>">
                            Remove
                        </button>
                    </td>
                    </tr>

                    <?php
                    $i++;
                }
                
            }                                     
            else {
                echo("<h4 class='warning'>Currently no Income</h4>");
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
        exit;
    }
    
?>