<?php
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "quickBookClone");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT  * FROM accounts";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
  @$account = $row['accounts'];
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: gray;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 5%;
      padding: 5px;
      background-color: #ffffff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
    }

    form {

      padding: 80px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: rgb(128, 131, 132);
      color: #ffffff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    #btn:hover,
    .form-group button:hover {
      background-color: #45a049;
      width: 70%;
      margin-left: 50%;
      transform: translateX(-50%);
    }

    button {
      transition: .4s ease-in-out;
      background-color: orange;
      color: black;
    }
  </style>
  </style>
</head>

<body>
  <div class="container">
    <h2>Add Account</h2>
    <form action="new_account.php" method="POST">
      <div class="form-group">
        <label for="date">Name</label>
        <input type="text" id="birthday" name="name" required>
      </div>
      <div class="form-group">
        <label for="username">Type<br>
          <select id="" name="type" style="width:100%;height:35px">
            <option value=""> Select..</option>
            <option value="Liability">Liability</option>
            <option value="Assets">Assets</option>
            <option value="Income">Income</option>
            <option value="Expenses">Expenses</option>
            <option value="Equity">Equity</option>
          </select>
        </label>
      </div>

      <div class="form-group">
        <button type="submit" name="submit">Record</button>
      </div>
    </form>
    <div class="form-group">
      <a href="journal.php" style="text-decoration: none;"><button type="submit" name="submit" id="btn">Make
          Transcation</button></a>
    </div>
  </div>
</body>

</html>
<!-- create account and ledger -->
<?php
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "quickBookClone");

if (isset($_POST['submit'])) {
  $nam = $_POST['name'];
  $type = $_POST['type'];
  $a = mysqli_query($conn, "INSERT INTO accounts VALUES ('','$nam','$type')");

  if ($a) {

    $d = "SELECT aid FROM `accounts` where name='$nam'";
    $resultd = $conn->query($d);
    while ($rowd = mysqli_fetch_array($resultd)) {
      $id = $rowd['aid'];


    }

    $a = mysqli_query($conn, "INSERT INTO ledger VALUES ('$id','0')");


    echo "<script>alert('Account Created!')</script>";
    //   $b=mysqli_query($conn,"update ledger")		

  } else {

    echo "<script>alert('Try again')</script>";

  }

}
?>