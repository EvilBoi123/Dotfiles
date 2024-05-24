<?php
session_start();
// Initialize the session
// Check if the user is logged in, if not then redirect him to login page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: index.php");
}
else if ($_SESSION['status'] == 0){
    header("location: home.php");
}

else if ($_SESSION['status'] == 1) {
    include "connection.php";
    $rows = array(); 
    $rowsAccepted = array();

    function refreshRequested($con){
        unset($rows); 
        global $rows, $totalrow; 
    $sql = "SELECT * FROM Requested WHERE status = 0";
    $result = mysqli_query($con,$sql);
    $totalrow = mysqli_num_rows($result); 
    #echo "<br>Totalrow= ". $totalrow; 
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row; // Store each row in the array
        }
    }
    function refreshAccepted($con){ 
        unset($rowsAccepted);
        global $hi,$rowsAccepted, $totalrowAccepted; 
        $hi = "hi";
    $sqlAccepted = "SELECT * FROM Requested WHERE status = 1";
    $resultAccepted = mysqli_query($con,$sqlAccepted); 
    $totalrowAccepted = mysqli_num_rows($resultAccepted);
    while ($rowAccepted = mysqli_fetch_assoc($resultAccepted)) {
        $rowsAccepted[] = $rowAccepted; 
        }
    } 
    


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include "connection.php";


    if(isset($_POST['acceptButton']) && $_POST['acceptButton'] == 'Accept') {
    //$sqlUpdate =  "UPDATE Requested SET status = 1 WHERE (Username = '" . $_POST['username'] . "' AND ID = '" . $_POST['IDval'] . "') OR (ID_user = '" . $_POST['IDuser'] . "' AND status = 0)";
    $sqlUpdate =  "UPDATE Requested SET status = 1 WHERE (Username = '" . $_POST['username'] . "' AND ID = '" . $_POST['IDval'] . "' AND status = 0)";

    //echo "<br>" . $sqlUpdate; 
    //$sql = "SELECT * FROM Requested WHERE status = 0";
    $execute = mysqli_query($con, $sqlUpdate); 
    //$result = mysqli_query($con,$sql);
    $sqlCopy = "INSERT INTO Log (ID, ID_user, Username, Type, Date_begin, End_date, Notes) SELECT ID, ID_user, Username, Type, Date_begin, End_date, Notes FROM Requested WHERE ID = " . $_POST['IDval'] . ";";
   // echo "<br>" . $sqlCopy;
    //echo $sqlCopy;  
    $executeRecordLog = mysqli_query($con, $sqlCopy);
    }

    if(isset($_POST['rejectButton']) && $_POST['rejectButton'] == 'rejected'){
    $sqlReject =  "DELETE FROM Requested WHERE Username = '" . $_POST['username'] . "' AND ID = '" . $_POST['IDval'] . "' AND ID_user = '" . $_POST['IDuser'] . "' AND status = 0" ;
    $execute = mysqli_query($con, $sqlReject); 
    
    } 

    if(isset($_POST['delbuttonAccepted']) && $_POST['delbuttonAccepted'] == 'del') {
    $sqldel =  "DELETE FROM Requested WHERE Username = '" . $_POST['username'] . "' AND ID = '" . $_POST['IDval'] . "'  AND status = 1" ;
    
    $executeAccepted = mysqli_query($con,$sqldel); 
    
    }
    


    else if(isset($_POST['request']) && $_POST['request'] == 'requested'){
        echo "Requested"; 
        echo $_SESSION["loggedin"];
        header("location: request.php");
    }
   
}
refreshAccepted($con);
refreshRequested($con);
}
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pinjaman</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        
    </style>
</head>
<body>
    <div class="row1">
        <div class="center-table"> <!-- Wrap the table inside this div -->
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
                                <th>ID</th>
                                <th>Nama</th>
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
                                <td><?php echo $row['ID_user']; ?></td>
                                <td><?php echo $row['Username']; ?></td>
                                <td><?php echo $row['Type']; ?></td>
                                <td><?php echo $row['Date_begin']; ?></td>
                                <td><?php echo $row['End_date']; ?></td>
                                <td><?php echo $row['Notes']; ?></td>

                                <td>
                                    <form id='delete' method='post'>
                                        <input type='hidden' name='username' value='<?php echo $row['Username']; ?>'>
                                        <input type='hidden' name='IDval' value='<?php echo $row['ID']; ?>'>
                                        <input type='hidden' name='IDuser' value='<?php echo $row['ID_user']; ?>'>
                                        <button type='submit' name='acceptButton' value='Accept'>Terima</button>
                                    </form>
                                </td>
                                <td>
                                    <form id='reject' method='post'>
                                        <input type='hidden' name='username' value='<?php echo $row['Username']; ?>'>
                                        <input type='hidden' name='IDval' value='<?php echo $row['ID']; ?>'>
                                        <input type='hidden' name='IDuser' value='<?php echo $row['ID_user']; ?>'>
                                        <button type='submit' name='rejectButton' value='rejected'>Buang</button>
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
                                <th>ID</th>
                                <th>Nama</th>
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
                                <td><?php echo $rowAccepted['ID_user']; ?></td>
                                <td><?php echo $rowAccepted['Username']; ?></td>
                                <td><?php echo $rowAccepted['Type']; ?></td>
                                <td><?php echo $rowAccepted['Date_begin']; ?></td>
                                <td><?php echo $rowAccepted['End_date']; ?></td>
                                <td><?php echo $rowAccepted['Notes']; ?></td>

                                <td>
                                    <form id='deleteAccepted' method='post'>
                                        <input type='hidden' name='username' value='<?php echo $rowAccepted['Username']; ?>'>
                                        <input type='hidden' name='IDval' value='<?php echo $rowAccepted['ID']; ?>'>
                                        <input type='hidden' name='IDuser' value='<?php echo $rowAccepted['ID_user']; ?>'>
                                        <button type='submit' name='delbuttonAccepted' value='del'>Selesai</button>
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