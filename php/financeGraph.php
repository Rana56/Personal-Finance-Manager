<?php
    include_once("connectdb.php");

    try {
        //gets the user id from the user email stored in session data
        $userid = $db->prepare("SELECT id FROM user WHERE email = ?");
        $userid->execute(array($_SESSION['username']));
        //gets the first row of pdo object
        $user = $userid->fetch();
        
        //get category id from database
        $qry = $db->prepare("SELECT categories.categoryName, SUM(expense.amount) AS total FROM expenses INNER JOIN categories ON expense.categoryID = categories.categoryID WHERE userID = :userid");
        $qry->bindParam(':userid', $user['id'], PDO::PARAM_STR);
        
        //data structure
        $data = array();
        while ($row = $qry->fetch(PDO::FETCH_ASSOC)){
            $data[] = array(
                'category' => $row['categoryName'],
                'total' => $row['total']
            );
        }
        
        exit;
    }
    catch (PDOException $ex) {
        echo("<h4 class='warning'> Error - Failed to connect to the database.<br /> </h4>");
        echo($ex->getMessage());
        exit;

    }
?>

<canvas id="pieChart"></canvas>

<script>
    //changes data into json data e.e. {"Peter":35,"Ben":37,"Joe":43}
    var data = <?php echo json_encode($data); ?>;
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];
    
    //gets the drawing functions to draw on canvas 
    var context = document.getElementById("pieChart").getContext("2d");
    var myChart = new Chart(context, {
        type: 'pie',
        data: {
            labels: data.map(item => item.category),
            dataset:[{
                backgroundColor: barColors,
                data: data.map(item => item.total),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>