<?php 
// Initialize the session
//session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['status'] == 0){
    header("location: home.php");
}
else if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['status'] == 1){
    header("location: admin.php");
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include "connection.php";
	$id = $_POST['id'];
	$password = $_POST['pass'];

	$id = stripcslashes($id); 
	$password = stripcslashes($password); 
	$id = mysqli_real_escape_string($con,$id);
	$password = mysqli_real_escape_string($con,$password);
	
	$sql = "select * from login where ID = '$id' and Password = '$password'"; 
	$result = mysqli_query($con,$sql); 
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result); 
	
  if (mysqli_num_rows($result) > 0) {

    session_start(); 
		$extract = mysqli_fetch_assoc($result); 
		echo "Login Successfull <br>";

		echo "Username: " . $row['Username'] . "<br>";
		echo "Password: " . $row['Password'];
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION['status'] = $row['status'];
                            $_SESSION['username'] = $row['Username']; 

                            //$_SESSION["row"] = $row;  
                            // Redirect user to welcome page
                            if ($_SESSION['status'] == 0){
		                        header("location: home.php");
                            }
                            else if ($_SESSION['status'] == 1){
                                header("LOcation: admin.php"); 
                            }

    }
    else 
    {
       $errorMessage = "Username or Password is wrong"; 
    }
	
}	
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pinjaman barang ICT KMK</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="container">
        <!-- Your form goes here -->
        <div id='logo'>
            <img src='images/logo.png'>
            <a href='request2.php' class='request-noaccount-button'>Tanpa Akaun</a>
        </div>
        <div id="frm">
            <h1>Log masuk</h1>
            <form name="f1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validation()" method="POST">
                <p>
                    <label> IC: </label>
                    <input type="text" id="id" name="id" />
                </p>
                <p>
                    <label> Password: </label>
                    <input type="password" id="pass" name="pass" />
                </p>
                <p>
                <?php
                    if(isset($errorMessage)) {
                        echo "<p style='color: red;'>$errorMessage</p>";
                    }
                ?>
                </p>

                    <input type="submit" id="btn" value="Log masuk" style='margin-right: 150px' />
                <a href='register.php'>
                         <input type='button' id='register' value="Tiada Akaun" />
                    </a>

            </form>
        </div>
    </div>
    <script>
        function validation() {
            var id = document.f1.user.value;
            var ps = document.f1.pass.value;
            if (id.length == "" && ps.length == "") {
                alert("User Name and Password fields are empty");
                return false;
            } else {
                if (id.length == "") {
                    alert("User Name is empty");
                    return false;
                }
                if (ps.length == "") {
                    alert("Password field is empty");
                    return false;
                }
            }
        }
    </script>
</body>
</html>

  