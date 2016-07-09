<?php
	$db['db_host'] = "DATABASE_HOST";
	$db['db_user'] = "DATABASE_USER";
	$db['db_pass'] = "DATABASE_PASSWORD";
	$db['db_name'] = "DATABASE_NAME";

	foreach($db as $key => $value){	
		define(strtoupper($key), $value);
	}

	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$name = $_POST['name'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$number = $_POST['number'];
	$code = strtoupper(genCode(6));
	
    	$query = "INSERT INTO tickets(name, address, email, number, code) ";        
    	$query .= "VALUES('{$name}', '{$address}', '{$email}', '{$number}' ,'{$code}')";   

    	$post_query = mysqli_query($connection, $query);
	
	if($post_query){
		$msg = "Dear " . $name . ", here is your ticket! http://". $_SERVER['HTTP_HOST'] ."/showTicket.php?ticketCode=". $code;
		$header = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n";
		mail($email,"Ticket Info",$msg, $header);
		
		$msgToAdmin = " Ticket Holder: " . $name . "\n Address: " . $address . "\n Email: " . $email . "\n Number: " . $number . "\n Ticket Code: " . $code;
		mail("admin@" . $_SERVER['HTTP_HOST'],"Ticket Info",$msgToAdmin,$header);
		
		
		echo "<br><h2 style='text-align:left; margin-left:2.6cm'><b>Dear " . $name . ",</b></h2>";
		echo "<h3 style='text-align:left; margin-left:2.6cm'><b>Thank you! Here is your ticket: </b></h3><br>";
		echo "<center><a href=http://". $_SERVER['HTTP_HOST'] ."/showTicket.php?ticketCode=". $code .">Click HERE to proceed to your ticket.</a></center><br>";		
		
	} else {
		echo "<br><br>" . $post_query . "<br>";
		echo mysqli_error($connection);
	}

	function genCode($length) {
    		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$randomString = '';

    		for ($i = 0; $i < $length; $i++)
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		
		return $randomString;
	}
?>