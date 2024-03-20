<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="stylesheet" href="header-style.css">
  <link rel="stylesheet" href="transaction-style.css">
  <link rel="stylesheet" href="footer-style.css">
  <link rel="stylesheet" href="sty.css">

  <title>Dashboard </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <style>
    * {
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    h2 {
      text-align: center;
      text-transform: uppercase;
      margin-top: 20px;
    }

    table {
      border-collapse: collapse;
      color: white;
      font-size: 20px;
    }

    table th {
      background-color: lightseagreen;
      padding: 10px;
      color: white;
      text-transform: uppercase;
    }

    table td {
      color: black;
      padding-left: 10px;
    }



    .row {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .single-table {
      width: 300px;
    }

    .single-table table {
      width: 100%;
      margin-top: 10px;
    }
  </style>

</head>

<body>

  <nav>
    <ul class="menu-bar">
      <li class="active">
        <a href="dashboard.html"><i class="fas fa-home"></i>Home</a>
      </li>
      <li>
        <i class="fas fa-calculator"></i>My Accounting <i class="fas fa-chevron-down"></i>
        <div class="sub-menu">
          <ul>
            <li><a href="journal.php">Make Journal Entries</a></li>
            <li><a href="">Reports</a>
              <i class="fas fa-chevron-right"></i>
              <div class="sub-menu-2">
                <ul>
                  <li><a href="balancesheet.php">Balance Sheet</a></li>
                  <li><a href="trial_balance.php">Trial Balance</a></li>
                  <li><a href="ledger.php">Ledger</a></li>
                  <li><a href="profit_account.php">Profit & Loss</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>

      </li>
    </ul>
  </nav>

    <h1 style="text-align: center; margin: 20px 0">My Ledgers</h1>
  <div class="row">
    <?php
    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "quickBookClone");
    $sqlx = "SELECT accounts.aid,balance, name FROM accounts,ledger where accounts.aid=ledger.aid and balance > 0";
    $resultx = $conn->query($sqlx);
    while ($rowx = mysqli_fetch_array($resultx)) {
      @$aid = $rowx["0"];
      @$balance = $rowx["1"];
      @$name = $rowx["2"];
      ?>
      <div class="single-table">
        <table border="1">
          <thead>
            <tr>
              <td  colspan='2' style="text-align: center"><?php echo $name; ?></td>
            </tr>
            <tr>
              <th scope="col">DR</th>
              <th scope="col">CR</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $sql = "SELECT debit,credit FROM `jurnal`,`accounts` WHERE accounts.aid=jurnal.aid and accounts.aid=$aid ";

            $result = $conn->query($sql);
            while ($row = mysqli_fetch_array($result)) {

              $d = $row["0"];
              $c = $row["1"];
              if ($d == '0') {
                $d = '';
              }
              if ($c == '0') {
                $c = '';
              }
              ?>
              <tr>
                <td style="border-right:4px solid black;text-align:left">
                  <?php echo $d; ?>
                </td>
                <td style="text-align:right">
                  <?php echo $c; ?>
                </td>
              </tr>
              <?php
            }
            ?>
            <tr>
              <th colspan='2'>
                <b>BALANCE :
                  <?php echo $balance ?>
                </b>
              </th>
            </tr>
          </tbody>
        </table>
      </div>
      <?php
    }
    ?>
  </div>

</body>

</html>