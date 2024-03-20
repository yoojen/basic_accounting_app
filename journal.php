<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header-style.css">
    <link rel="stylesheet" href="transaction-style.css">
    <link rel="stylesheet" href="footer-style.css">
    <link rel="stylesheet" href="sty.css">
    <title>Journals_entry</title>
    <style>
        * {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        h2 {
            text-align: center;
            padding: 40px 0;
        }

        input {
            width: 20%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-left: 10px;
        }

        select {
            /* padding: 20px; */
            border: none;
            border-radius: 5px;
            font-size: 20px;
        }

        button {
            width: 130px;
            height: 40px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
            background: orange;
            font-weight: 800;
            font-size: 20px;
        }

        .content {
            width: 80%;
            margin-left: 50%;
            transform: translateX(-50%);
            background-color: lightblue;
            margin-top: 20px;
            padding-bottom: 20px;
            border-radius: 5px;
            box-shadow: 2px 3px 7px #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
        }

        table {
            width: 80%;
            border-bottom: 3px solid #01fd00;
            width: 80%;
            margin-left: 50%;
            transform: translateX(-50%);
            margin-top: 40px;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        table th {
            background-color: lightseagreen;
            padding: 20px;
            color: white;
            text-transform: uppercase;
        }

        table td {
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: khaki;
        }

        table td:nth-child(odd) {
            /* text-align: center; */
        }

        .total {
            color: black;
            text-transform: uppercase;
            /* padding: 10px 0; */
            background-color: white;
            font-size: 30px;
            text-decoration: underline;
            font-family: Stencil;
        }

        h2 {
            text-align: center;
        }

        input[type=number] {
            width: 10%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form {
            width: 100%;
            margin-left: 50%;
            transform: translateX(-50%);
            display: flex;
        }

        form label {
            margin: 10px 20px;
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

    <h2>Journals Entries</h2>

    <form action="journal.php" method='post'>
        <label for="date">Date</label>
        <input type="Date" name="date" placeholder="Select Date">
        <label for="dbr">Debit Account</label>
        <select name="debita" id="dr" style="width:10%;height:30px;" required>
            <option value="">Select..</option>
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

            while ($row = mysqli_fetch_array($result)) {
                ?>
                <option value=<?php echo $row['aid'] ?>><?php echo $row['name'] ?></option>
                <?php
            }

            ?>
        </select>
        <!-- amount <input type='number' name='da'/> -->

        <label for="cr">Credit Account</label>
        <select name="credita" id="cr" style="width:10%;height:30px;" required>

            <option value="">Select..</option>
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

            while ($row = mysqli_fetch_array($result)) {
                ?>
                <option value=<?php echo $row['aid'] ?>><?php echo $row['name'] ?></option>
                <?php
            }
            ?>
        </select>
        <label for="amount">Amount</label>
        <input type='number' name='ca' required />
        <a href=""><button type="submit" name="submit" id="sub">Record</button></a>
    </form>
    <button onclick="callPhp()"
        style="background-color: white; z-index: 999; font-size:15px; width: 150px; margin-left: 45%; margin-top: 30px">NEW
        ACCOUNT</button>
    <table class="" width="70%" height="auto" border="1" align="center">
        <tr>
            <td>Date</td>
            <td>account</td>
            <td>Debit</td>
            <td>Credit</td>
        </tr>

        <?php
        $conn = mysqli_connect("localhost", "root", "");
        mysqli_select_db($conn, "quickBookClone");

        $deb = "SELECT sum(debit) as tatal  FROM `jurnal`";
        $resultd = mysqli_query($conn, $deb);
        while ($row = mysqli_fetch_assoc($resultd)) {
            $td = $row['tatal'];
        }
        // ---------------------------------
        
        $cq = "SELECT sum(credit) as tatal  FROM `jurnal`";
        $resultc = mysqli_query($conn, $cq);
        while ($row = mysqli_fetch_assoc($resultc)) {
            $tc = $row['tatal'];
        }


        $query = "SELECT date, name,debit,credit FROM `jurnal`,accounts WHERE accounts.aid=jurnal.aid";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $d = $row['debit'];
            $c = $row['credit'];
            $e = $row['date'];
            if ($d == 0) {
                $d = '';
            }
            if ($c == 0) {
                $c = '';
            }
            ?>
            <tr>
                <td style="width: 200px;">
                    <?php echo $e ?>
                </td>
                <!-- <td></td> -->
                <td>
                    <?php echo $row['name'] ?>
                </td>
                <td>
                    <?php echo $d; ?>
                </td>
                <td>
                    <?php echo $c; ?>
                </td>
            </tr>
            <?php
        }


        ?>

    </table>
    <form action="" method="post">
        <button name="clear" style="margin-left: 70%; margin-bottom: 20px;">CLEAR</button>
    </form>
    <script>
        // const ee = document.getElementById('sub')
        // ee.addEventListener('click', (e) => {
        //     e.preventDefault()
        //     const cr_side = document.getElementById('cr').value;
        //     if (cr_side == 7) {
        //         console.log(33)
        //     }
        // })
        function callPhp() {
            location.href = 'new_account.php'
        }
    </script>
</body>

</html>

<?php
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "quickBookClone");
if (isset($_POST['submit'])) {
    $debita = $_POST['debita'];
    $dat = $_POST['date'];
    $credita = $_POST['credita'];
    $ca = $_POST['ca'];

    $debit_balance = "select sum(debit) as DR_BAL,name from jurnal,accounts
        where jurnal.aid=accounts.aid and accounts.name='Bank';";
    $credit_balance = "select sum(credit) as CR_BAL,name from jurnal,accounts
        where jurnal.aid=accounts.aid and accounts.name='Bank';";


    $res = $conn->query($debit_balance);
    while ($rowd = mysqli_fetch_array($res)) {
        $total_debit = $rowd['DR_BAL'];

    }

    $res_cr = $conn->query($credit_balance);
    while ($rowd = mysqli_fetch_array($res_cr)) {
        $total_credit = $rowd['CR_BAL'];

    }
    if ($credita == 7 && $total_debit - $total_credit - $ca < 0) {
        ?>
        <script> alert("Your BANK BALANCE CAN'T PROCESS THAT REQUEST, DEBIT BANK ACCOUNT FIRST'")</script>"
        <?php
    } else {
        $a = mysqli_query($conn, "INSERT INTO `jurnal` (`id`,`date`, `aid`, `debit`, `credit`) 
        VALUES (NULL,'$dat','$debita', '$ca', '');");
        echo "<script>location.href='journal.php'</script>";

        $c = "SELECT sum(credit) as credits FROM `jurnal` WHERE  jurnal.aid=$debita";
        $resultc = $conn->query($c);
        while ($rowc = mysqli_fetch_array($resultc)) {
            $cr = $rowc['credits'];

        }

        $d = "SELECT sum(debit) as debits FROM `jurnal` WHERE  jurnal.aid=$debita";
        $resultd = $conn->query($d);
        while ($rowd = mysqli_fetch_array($resultd)) {
            $dr = $rowd['debits'];

        }
        $balance = $dr - $cr;
        if ($balance < 0) {
            $balance = $balance * -1;
        }

        $dx = "UPDATE `ledger` SET `balance` = '$balance' WHERE `ledger`.`aid` =$debita";
        $conn->query($dx);



        if ($a) {
            mysqli_query($conn, "INSERT INTO `jurnal` (`id`, `date`,`aid`, `debit`, `credit`) 
                VALUES (NULL,'$dat','$credita', '', '$ca');");

            $c = "SELECT sum(credit) as credits FROM `jurnal` WHERE  jurnal.aid=$credita";
            $resultc = $conn->query($c);
            while ($rowc = mysqli_fetch_array($resultc)) {
                $cr = $rowc['credits'];

            }

            $d = "SELECT sum(debit) as debits FROM `jurnal` WHERE  jurnal.aid=$credita";
            $resultd = $conn->query($d);
            while ($rowd = mysqli_fetch_array($resultd)) {
                $dr = $rowd['debits'];

            }
            $balance = $dr - $cr;
            if ($balance < 0) {
                $balance = $balance * -1;
            }

            $dx = "UPDATE `ledger` SET `balance` = '$balance' WHERE `ledger`.`aid` =$credita";
            $conn->query($dx);

        } else {

            echo "<script>alert('Try again')</script>";
        }


    }

}
if (isset($_POST['clear'])) {

    $q = "UPDATE ledger set balance=0";
    $q2 = "TRUNCATE jurnal";
    $result = mysqli_query($conn, $q);
    $result += mysqli_query($conn, $q2);
    $a = mysqli_query($conn, $result);

    echo "<script>location.href='journal.php'</script>";
    if ($a) {
        echo "<script>alert('user successfully inserted')</script>";
    }
}
?>