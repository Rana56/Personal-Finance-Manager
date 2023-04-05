<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/login.css">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
    </head>

    <body>
        <!-- Header-->
        <?php
            include("php/header.php")
        ?>

        <!-- Login -->
        <div class="login-page">
            <h2>Login</h2>
            <div class="form">
                <form class="login-form" method="post" action="login.php">
                    <input type="email" placeholder="Email" name="email"/>
                    <input type="password" placeholder="Password" name="pwd"/>
                    
                    <button tpye="submit" name="submit">login</button>
                    
                    <p class="message">Not registered? <a href="signup.php">Create an account</a></p>

                    <input type="hidden" name="submitted" value="true" />
              </form>
            </div>
        </div>
    </body>

</html>

<?php
    //redirects user if logged in
    if (isset($_SESSION['username'])){
        header("Location: accounts.php");
        exit();
    }

    if (isset($_POST["submitted"])){
        if ( !isset($_POST['email'], $_POST['pwd']) ) {
            // Could not get the data that should have been sent.
            exit('Please fill both the username and password fields!');
	    }
        try {
            include("connectdb.php");                  

            $qry = $db->prepare("SELECT password FROM user WHERE email= ? ");
            $qry->execute(array($_POST['email']));

            if($qry->rowCount() > 0){
                $row = $qry->fetch();

                if (password_verify($_POST["pwd"], $row["password"])){              //fetch returns the next row from the result set, this also check the password against the saved password
                    session_start();                                                //starting session allows to store user login
                    $_SESSION = array();
                    
                    $_SESSION['username'] = $_POST['email'];                        //adds user to the session
                    
                    header("Location:accounts.php");                                  //redirect user to a new page
                    exit();                                                         //<meta http-equiv="Refresh" content="0; url='https://localhost/htdocs/lab8/course.php'" />

                } else {
                    echo "<h4 style='color:var(--colour-danger)' class='notification'>Login Error - Password or Email incorrect</h4>";
                }
            } else {
                echo "<h4 style='color:var(--colour-danger)' class='notification'>Error logging in, account not found </h4>";
            }
        } catch (PDOException $ex) {
			echo("Failed to connect to the database. <br />");
			echo($ex->getMessage());
			exit;
        }
    }
?>