<?php 
// Initialize the session
//session_start();
 
// Processing form data when form is submitted

use function PHPSTORM_META\sql_injection_subst;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once "connection.php";
	$id = $_POST['id'];
    $name = $_POST['name']; 
	$password = $_POST['pass'];

	$id = stripcslashes($id); 
	$password = stripcslashes($password); 
	$id = mysqli_real_escape_string($con,$id);
	$password = mysqli_real_escape_string($con,$password);
	
	$sql = "select * from login where ID = '$id'"; 
	$result = mysqli_query($con,$sql); 
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result); 
	
  if (mysqli_num_rows($result) > 0) {

		$extract = mysqli_fetch_assoc($result); 
		//echo "Login Successfull <br>";

		//echo "Username: " . $row['Username'] . "<br>";
		//echo "Password: " . $row['Password'];
        //echo "username already exist";
        $errorUsername = "Account already exist"; 

    }
    else if (mysqli_num_rows($result) == 0){
       $sqlInsert = "INSERT INTO login (ID, Username, status, Password) values('" . $id . "', '" . $name . "', 0, '" . $password . "');"; 
       echo $sqlInsert; 
       mysqli_query($con,$sqlInsert); 
       header("Location: index.php"); 
       session_destroy();
       exit(); 
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
        </div>
        <div id="frm">
            <h1>Register</h1>
            <form name="f1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validation()" method="POST">
                <p>
                    <label> IC: </label>
                    <input type="text" id="id" name="id" placeholder='xxxxxxxxxxxx' />
                </p>
                <p>
                    <label>Nama: </label>
                    <input type='text' id='name' name='name'/>
                </p>
                <p>
                    <label> Kata Laluan: </label>
                    <input type="text" id="pass" name="pass" />
                </p>
                <p>
                    <label>Pengesahan Kata Laluan</label>
                    <input type="text" id="passverify" name="passverify" >
                </p>
               
                    <?php 
                    if(isset($errorUsername)){
                    echo "<p style='color: red; margin-left: 100px'>" . $errorUsername . "</p>";
                    }
                    ?>
                <p>
                    <input type='submit' id='register' value='Register'>
                </p>

            </form>
        </div>
    </div>
    <script>
       function validation() {
    var id = document.f1.id.value;
    var name = document.f1.name.value; 
    var ps = document.f1.pass.value;
    var passverify = document.f1.passverify.value; 

    if (id.length == 0 && ps.length == 0) {
        alert("User Name and Password fields are empty");
        return false;
    } else if (id.length == 0) {
        alert("User Name is empty");
        return false;
    } else if (id.length > 12) {
        alert("ID length is more than 12"); 
        return false; 
    } else if (name.length == 0) {
        alert("Name is empty"); 
        return false; 
    } else if (name.length >= 200) {
        alert("Name should be less than 200 letters"); 
        return false; 
    } else if (ps.length == 0) {
        alert("Password field is empty");
        return false;
    } else if (ps.length >= 100) {
        alert("Password field should be less than 100 letters");
        return false;
    } else if (passverify.length == 0) {
        alert("Password verification field is empty");
        return false;
    } else if (passverify != ps) {
        alert("Password verification error");
        return false; 
    }
    
    return true; 
}
 
        </script>
</body>
</html>

  