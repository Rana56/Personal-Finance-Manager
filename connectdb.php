<?php
    $servername = "financemanager";
    $username = "root";
    $password = "";

	try{
		$db = new PDO("mysql:dbname=$servername; host=localhost", $username, $password);		//connects to database on localhost
	} catch (PDOException $ex){									//exception handling, incase database doesn't load
		?>
		<p> Sorry, a Database error occured. Please try again. </p>
		<p>(Error details: <?= $ex->getMessage() ?>)</p>

		<?php
	}
?>