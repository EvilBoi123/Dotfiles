<?php 

if($_SERVER["REQUEST_METHOD"] === "POST"){
    //run script
    require_once "connection.php"; 
    //echo "it runs\n";
    //echo "\n" . $_POST['type'];
    //echo "\n" . $_POST['date']; 
    //echo "\n" . $_POST['end_date']; 
    //echo "\n" . $_POST['notes']; 
    //echo "insert into Requested (ID_user, Username, Type, Date_begin, End_date, Notes, status) values(" . $_SESSION['id'] ", '" . $_SESSION['username'] ", '" . $_POST['type'] ", '" . $_POST['date'] ", '" . $_POST['end_date'] ", '" . $_POST['notes'] . ", 0);";
    //$sqlinsert = null;
    $type = null;  
    if($_POST['type'] == "other"){
     $type = $_POST['otherType'];
    }
    else{
      $type = $_POST['type']; 
    }
    //echo $_POST['type']; 
    //echo "<br>" . $type; 
    $sqlInsert =  "INSERT INTO Requested (Username, Type, Date_begin, End_date, Notes, status) VALUES ('" . $_POST['name'] . "', '" . $type . "', '" . $_POST['date'] . "', '" . $_POST['end_date'] . "', '" . $_POST['notes'] . "', 0);";
    echo $sqlInsert; 
    $execute = mysqli_query($con, $sqlInsert);
    sleep(0.5); 
    header("Location: index.php"); 


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pinjaman Barang</title>
<style>
  /* Center the form */
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  form {
    width: 300px;
  }
</style>
</head>
<body>
  <script>
function validateForm() {
    var type = document.getElementById("type").value;
    var date = document.getElementById("date").value;
    var endDate = document.getElementById("end_date").value;
    var notes = document.getElementById("notes").value;

    if (type == "") {
        alert("Please enter a type.");
        return false;
    }

    if (date == "") {
        alert("Please select a date.");
        return false;
    }

    if (endDate == "") {
        alert("Please select an end date.");
        return false;
    }

    return true;
}

function showTextBox() {
  var selectBox = document.getElementById("type");
  var hiddenTextBox = document.getElementById("otherType");
  if (selectBox.value == "other") { // Compare selectBox.value
    hiddenTextBox.style.display = "block";
  } else {
    hiddenTextBox.style.display = "none";
  }
}
</script>
<div class="container">
  <form id='submit_data' method="POST" onsubmit='return validateForm()'>
  <label for="name">Nama:</label>
  <input type ='text' id="name" name="name"><br> 
    <label for="type">Jenis:</label><br>
    <!-- <input type="text" id="type" name="type" value='type'><br> -->
    <select id='type' name ='type' onchange='showTextBox()'> 
      <option value='Laptop'>Laptop</option>
      <option value='PC'>PC Desktop</option>
      <option value='Projector'>Projector</option>
      <option value='Printer'>Printer</option>
      <option value='LCD'>LCD</option>
      <option value='other'>Lain-lain</option>
    </select>
    <br>
    <input type='text' id='otherType' name='otherType' style="display:none;" placeholder='Sila isi'>
    <label for="date">Tarikh Pinjaman:</label><br>
    <input type="date" id="date" name="date"><br>
    <label for="end_date">Tarikh Pemulangan:</label><br>
    <input type="date" id="end_date" name="end_date"><br>
    <label for="notes">Tujuan Pinjaman:</label><br>
    <textarea id="notes" name="notes" rows="4" cols="30" value='notes' placeholder="(200 patah perkataan)" ></textarea><br><br>
    <input type="submit" value="Submit">
  </form>
</div>

</body>
</html>