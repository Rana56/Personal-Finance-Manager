<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/savings.css">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    </head>

    <body>
        <!-- Header-->
        <?php
            include("php/header.php")
        ?>

        <div class="intro">
            <div class="container">
                <h1>Finance tips and tricks</h1>
                <h3>Improve your financial knowledge and management</h3>
                <p>Explore our resouces on how to cope during the current cost-of-living crisis and save money.</p>
            </div>
        </div>

        <section class="card-container">
            <!--
            <div class="card">
                <div class="card-img"></div>
                <h2>Title</h2>
                <p>Text</p>
                <a href="">Read More</a>
            </div>

            <img src='' class="card-img"></img>
            -->

            <!--This holds the card information-->
            <?php
            include_once("connectdb.php");
            try {
                $qry = $db->prepare("SELECT * FROM resources");
                $qry->execute();

                if ($qry->rowCount() > 0){                                     //checks if a rows are returned
                    foreach ($qry as $row){                                         //loops trough queried object
                        //adds path to image and creates id for buttons
                        $image = "images/resources/" . $row["image"];
                        $title =  $row["title"];
                        $text = $row["text"];
                        $link = $row["link"];
                        ?>
                        
                        <div class="card">
                            <div class="card-img" style="background-image: url(<?= $image ?>);"></div>
                            <div class="card-content">
                                <h3> <?= $title ?> </h3>
                                <p> <?= $text ?> </p>
                                
                            </div>
                            <div class="card-link">
                                    <a href="<?= $link ?>">Read More</a>
                            </div>
                            
                        </div>

                        <?php
                    }
                }
            } catch (PDOException $ex) {
                echo $ex;
            }
            ?>
            
        </section>
</html>