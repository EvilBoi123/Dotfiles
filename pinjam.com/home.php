<?php
session_start();
// Initialize the session
// Check if the user is logged in, if not then redirect him to login page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: index.php");
}
else if ($_SESSION['status'] == 0) {
    include "connection.php";
   $sql = "SELECT * FROM Requested WHERE ID_user = '" . $_SESSION["id"] . "' AND Username = '" . $_SESSION['username'] . "' and status = 0";
    $result = mysqli_query($con,$sql);
    $totalrow = mysqli_num_rows($result); 
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row; // Store each row in the array
    }

    $sqlAccepted = "SELECT * FROM Requested WHERE ID_user = '" . $_SESSION["id"] . "' AND Username = '" . $_SESSION['username'] . "' and status = 1";
    $resultAccepted = mysqli_query($con,$sqlAccepted); 
    $totalrowAccepted = mysqli_num_rows($resultAccepted);
    $rowsAccepted = array();
    while ($rowAccepted = mysqli_fetch_assoc($resultAccepted)) {
        $rowsAccepted[] = $rowAccepted; 
    }
    // For table Requested
    //$sqlRequested = "select * from Requested where Username = "

   // $row=mysqli_fetch_array($result);
    //$row=mysqli_fetch_assoc($result);
}
else if ($_SESSION['status'] == 1){
    header("location: admin.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include "connection.php";
    if(isset($_POST['delbutton']) && $_POST['delbutton'] == 'del') {
    $sqldel =  "DELETE FROM Requested WHERE Username = '" . $_POST['username'] . "' AND ID = '" . $_POST['IDval'] . "' AND ID_user = '" . $_POST['IDuser'] . "' AND status = 0" ;
    //echo  "delete from login where Username = '" . $_POST['username'] . "' and ID = '" . $_POST['ID'] . "';" ;
    //echo '<br>' . $sqldel; 
    $execute = mysqli_query($con, $sqldel); 
    mysqli_free_result($result);
    $result = mysqli_query($con,$sql);
    $sqldel = null; 
     $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_close($con); 
    }
    if(isset($_POST['delbuttonAccepted']) && $_POST['delbuttonAccepted'] == 'del') {
    $sqldel =  "DELETE FROM Requested WHERE Username = '" . $_POST['username'] . "' AND ID = '" . $_POST['IDval'] . "' AND ID_user = '" . $_POST['IDuser'] . "' AND status = 1" ;
    //echo '<br>' . $sqldel; 
    $executeAccepted = mysqli_query($con,$sqldel); 
    $sqldel= null; 
    $resultAccepted= mysqli_query($con,$sqlAccepted); 
    $rowsAccepted = [];
    while ($rowAccepted = mysqli_fetch_assoc($resultAccepted)) {
            $rowsAccepted[] = $rowAccepted;
        }
    $sqldel = null; 
    mysqli_close($con); 
    }
    else if(isset($_POST['request']) && $_POST['request'] == 'requested'){
        echo "Requested"; 
        echo $_SESSION["loggedin"];
        header("location: request.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pinjaman</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>
<body>
    <div class="row1">
        <div>
            <h1 class="my-5">
                <span>Selamat Datang, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></span>
              <a href="logout.php" class="logout-button">Log Keluar</a> 
            </h1>
             
                <div class="data">
                    <div class="container">
                        <h2>Senarai Permintaan</h2>
                        <table border="2" cellspacing="0" cellpadding="10">
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Tarikh Pinjaman</th>
                                <th>Tarikh Pulangan</th>
                                <th>Tujuan Pinjaman</th>
                            </tr>
                            <?php
                            if( $totalrow > 0){
                                $no=1;
                                foreach ($rows as $row){
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $row['Type']; ?></td>
                                <td><?php echo $row['Date_begin']; ?></td>
                                <td><?php echo $row['End_date']; ?></td>
                                <td><?php echo $row['Notes']; ?></td>

                                <td>
                                    <form id='delete' method='post'>
                                        <input type='hidden' name='username' value='<?php echo $row['Username']; ?>'>
                                        <input type='hidden' name='IDval' value='<?php echo $row['ID']; ?>'>
                                        <input type='hidden' name='IDuser' value='<?php echo $row['ID_user']; ?>'>
                                        <button type='submit' name='delbutton' value='del'>Batal</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                $no++;
                                }
                            }
                            ?>
                        </table>
                        <form id=request method='post'>
                            <button type='submit' id='requestbutton' name='request' value='requested'>Permintaan baru</button>
                        </form>
                    </div>
                    <br>
                    <div class="container2">
                        <h2>Senarai Diterima</h2>
                        <table border="2" cellspacing="0" cellpadding="10">
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Tarikh Pinjaman</th>
                                <th>Tarikh Pulangan</th>
                                <th>Tujuan Pinjaman</th>
                            </tr>
                            <?php
                            if( $totalrowAccepted > 0){
                                $no=1;
                                foreach ($rowsAccepted as $rowAccepted){
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $rowAccepted['Type']; ?></td>
                                <td><?php echo $rowAccepted['Date_begin']; ?></td>
                                <td><?php echo $rowAccepted['End_date']; ?></td>
                                <td><?php echo $rowAccepted['Notes']; ?></td>

                                <td>
                                    <form id='deleteAccepted' method='post'>
                                        <input type='hidden' name='username' value='<?php echo $rowAccepted['Username']; ?>'>
                                        <input type='hidden' name='IDval' value='<?php echo $rowAccepted['ID']; ?>'>
                                        <input type='hidden' name='IDuser' value='<?php echo $rowAccepted['ID_user']; ?>'>
                                        <button type='submit' name='delbuttonAccepted' value='del'>Siap</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                $no++;
                                }
                            }
                            ?>
                        </table>
                    </div>
        </div>
    </div>
</body>
</html>
