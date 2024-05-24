<?php 

	$host = "localhost"; 
	$user="root"; 
	$password="surainihusaini"; 
	$db_name="pinjam"; 
 	
	$con = mysqli_connect($host,$user,$password,$db_name); 
	if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
	echo "have died"; 
	}
?>
