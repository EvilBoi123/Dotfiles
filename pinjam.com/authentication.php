<?php 
	include ('connection.php'); 
	$username = $_POST['user'];
	$password = $_POST['pass'];

	$username = stripcslashes($username); 
	$password = stripcslashes($password); 
	$username = mysqli_real_escape_string($con,$username);
	$password = mysqli_real_escape_string($con,$password);
	
	$sql = "select * from login where Username = '$username' and Password = '$password'"; 
	$result = mysqli_query($con,$sql); 
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result); 
	
  if (mysqli_num_rows($result) > 0) {

		$extract = mysqli_fetch_assoc($result); 
		echo "Login Successfull <br>";

		echo "Username: " . $row['Username'] . "<br>";
		echo "Password: " . $row['Password'];
		session_start(); 
		header("location: home.html");

    }	
	else {
		echo "<h1> Login failed. Invalid username or password.</h1>";
	}	
?>
