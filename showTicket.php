<?php
if(isset($_GET['code'])){
	$holder = "";
	$code = "";
	$notFound = 1;
	$code = $_GET['code'];

	$db['db_host'] = "DATABASE_HOST";
	$db['db_user'] = "DATABASE_USER";
	$db['db_pass'] = "DATABASE_PASSWORD";
	$db['db_name'] = "DATABASE_NAME";

	foreach($db as $key => $value){
		define(strtoupper($key), $value);
	}

	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	$query = "SELECT * FROM tickets";
    	$select_posts = mysqli_query($connection,$query);

    	while($row = mysqli_fetch_assoc($select_posts)) {
		if(!strcmp($row['code'], $_GET['code'])) {
			$notFound = 0;
			$name = $row['name'];
			$address = $row['address'];
			$number = $row['number'];
		}
	}
	
	if($notFound) echo "<br><br><h3 style='text-align:left; margin-left:2.6cm; color:red'><b>Sorry! Your code is not valid.</b></h3><br>";
	else {
		header('Content-Type: image/png');
		$img = imagecreatefrompng('ticketsample.png');
		$black = imagecolorallocate($img, 0, 0, 0);
		$font = 'arial.ttf';
		
		imagettftext($img, 10, 0, 75, 50, $black, $font, $name);
		imagettftext($img, 10, 0, 75, 95, $black, $font, $address);
		imagettftext($img, 10, 0, 75, 180, $black, $font, $number);
		imagepng($img);
		imagedestroy($img);
	}
} else {
	header('Location:javascript:history.go(-1)');
}
?>