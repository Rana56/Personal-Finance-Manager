<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/signup.css">
        <link rel="icon" href="Images/money.png">
        <title>Final Year Project</title>
    </head>

    <body>
        <!-- Header-->
        <?php
            include("php/header.php")
        ?>

        <!-- Signup -->
        <div class="signup-page">
            <h2>Sign Up</h2>
            <div class="form">
                <form class="signup-form" method="post" action="signup.php">

                    <input type="text" placeholder="First Name" name="fname" required/>
                    <input type="text" placeholder="Last Name" name="lname" required/>
                    <input type="email" placeholder="Email" name="email" required/>
                    <input type="password" placeholder="Password" name="pwd" required autocomplete="off"/>
                    <input type="password" placeholder="Confirm Password" name="pwd2" required autocomplete="off"/>
                    
                    <button type="submit">Sign Up</button>
                    
                    <p class="message">Already registered? <a href="login.php">Login</a></p>

                    <input type="hidden" name="submitted" value="true" />
              </form>
            </div>
        </div>
    </body>

</html>

<?php
if (isset($_POST["submitted"])){
    //checks if the fields are filled in
    if (isset($_POST["email"])){
        $email = $_POST["email"];
    } else {
        echo "<p class='text-danger text-center'> The username is empty. </p>";
        exit;
    }

    //checks if passwords are equal
    if (trim($_POST["pwd"]) !== trim($_POST["pwd2"])){
        echo "<p class='text-danger text-center'> Two passwords don't match. </p>";
        exit;
    }

    if (!empty(trim($_POST["pwd"]))){
        //checks if password meets strength requirements
        pwdcheck($_POST["pwd"]);

        $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);			//hashes the password so it is secure and can be saved to the database
    } else {
        echo "<p class='text-danger text-center'> The password is empty. </p>";
        exit;
    }

    if (isset($_POST["fname"])){
        $fname = $_POST["fname"];
    } else {
        echo "<p class='text-danger text-center'> The first name is empty. </p>";
        exit;
    }

    if (isset($_POST["lname"])){
        $lname = $_POST["lname"];
    } else {
        echo "<p class='text-danger text-center'> The last name is empty. </p>";
        exit;
    }

    include("connectdb.php");			//links to other file and connects to data base

    try {
        //checks if account already registered
        $qcheck = $db->prepare("SELECT id FROM user WHERE email = ?");
        $qcheck->execute(array($_POST['email']));

        if ($qcheck->rowCount() == 0) {

            $qstr = $db->prepare("INSERT INTO user VALUES(null, :email, :password, :fname, :lname)");				//adds values to database, sql query
            $qstr->bindParam(':email', $email, PDO::PARAM_STR, 64);								//binds a parameter to a specific variable name
            $qstr->bindParam(':password', $pwd, PDO::PARAM_STR, 64);
            $qstr->bindParam(':fname', $fname, PDO::PARAM_STR, 64);
            $qstr->bindParam(':lname', $lname, PDO::PARAM_STR, 64);

            $qstr->execute();							//executes the prepared statement

            $id = $db->lastInsertID();					//gets id of last entry

            session_start();                                                //starting session allows to store user login
            $_SESSION['username'] = $_POST['email'];

            echo "<h4 class='notification'> Congratulations! You are now registered. Your ID is: $id </h4>";
            header("Location: accounts.php");
        }   else {
            echo "<h4 class='notification'> The email has already been registered. Please try agian with a different email. </h4>";
            exit;
        }
    }
    catch (PDOException $ex) {
	    echo("<h4 class='notification'> Failed to connect to the database.<br /> </h4>");
	    echo($ex->getMessage());
	    exit;

    }
}	else {
    //echo "<h4 class='text-success text-center'> Please enter your credentials. </h4>";
    exit;
}

//password check, checks if password meets requirements
function pwdcheck($pass){
    $upper = preg_match('@[A-Z]@', $pass);
    $lower = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);

    if(!$upper || !$lower || !$number || strlen($pass) < 6) {
        
        echo "<p class='text-danger text-center'> Password requirements: Minimum character length is 6 - One Upper case letter - One Number. </p>";
        exit;
    }
}
?>