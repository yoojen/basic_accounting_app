<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header-style.css">
    <link rel="stylesheet" href="transaction-style.css">
    <link rel="stylesheet" href="footer-style.css">
    <link rel="stylesheet" href="sty.css">
    <title>balance</title>
    <style>
        * {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        table {
            width: 80%;
            width: 80%;
            margin-left: 50%;
            transform: translateX(-50%);
            margin-top: 40px;
            border-collapse: collapse;
            color: white;
            font-size: 20px;
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
            background-color: darkolivegreen;
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
    <h1 align="center">Balance sheet</h1>
    <table width="80%" align="center" border="1">
        <!-- first row -->
        <tr>
            <th>Assets</th>
            <th align="center">Liability</th>
        </tr>

        <tr>
            <td>
                <table width="100%">

                    <?php
                    $conn = mysqli_connect("localhost", "root", "");
                    mysqli_select_db($conn, "quickBookClone");

                    $query = "SELECT name,balance,type FROM `accounts`,ledger WHERE accounts.aid=ledger.aid";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_array($result)) {
                        @$name = $row['name'];
                        @$balance = $row['balance'];
                        @$type = $row['type'];

                        ?>
                        <tr>
                            <?php
                            if ($type == 'Assets') {

                                ?>
                                <td>
                                    <?php echo $name; ?>
                                </td>
                                <td>
                                    <?php echo $balance; ?>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    <td colspan="2">Total</td>
                </table>
            </td>
            <td>
                <table>

                    <?php
                    $conn = mysqli_connect("localhost", "root", "");
                    mysqli_select_db($conn, "quickBookClone");

                    $query = "SELECT name,balance,type FROM `accounts`,ledger WHERE accounts.aid=ledger.aid";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_array($result)) {
                        @$name = $row['name'];
                        @$balance = $row['balance'];
                        @$type = $row['type'];

                        ?>
                        <tr>
                            <?php
                            if ($type == 'Liability' || $type == 'Equity') {

                                ?>
                                <td>
                                    <?php echo $name; ?>
                                </td>
                                <td>
                                    <?php echo $balance; ?>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }

                    ?>
                    <td>
                        <?php echo "Net Loss/Profit"; ?>
                    </td>
                    <td>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "");
                        mysqli_select_db($conn, "quickBookClone");
                        $cq = "SELECT SUM(balance) AS total from accounts, ledger where name='sales' and
                        accounts.aid=ledger.aid;";
                        $resultc = mysqli_query($conn, $cq);
                        while ($row = mysqli_fetch_assoc($resultc)) {
                            $tc = $row['total'];
                        }
                        $st = "SELECT SUM(balance) AS stock_total from accounts, ledger where name='Stock Item' and
                        accounts.aid=ledger.aid;";
                        $result_c = mysqli_query($conn, $st);
                        while ($row = mysqli_fetch_assoc($result_c)) {
                            $td = $row['stock_total'];
                        }
                        $st_expenses = "SELECT SUM(balance) AS exp_total from accounts, ledger where type='Expenses' and accounts.aid=ledger.aid;";
                        $result_exp = mysqli_query($conn, $st_expenses);

                        while ($row = mysqli_fetch_assoc($result_exp)) {
                            $td_exp = $row['exp_total'];
                        }
                        ?>
                        <?php echo $cost = $tc - $td - $td_exp?>
                    </td>
            </td>
    </table>

    <tr>
        <td align="center">
            <table width="100%">
                <tr>
                    <th>Total</th>
                    <td>
                        <?php
                        $deb = "SELECT sum(balance) as tatal  FROM `ledger`,`accounts` where accounts.aid=ledger.aid and accounts.type='Assets' ";
                        $resultd = mysqli_query($conn, $deb);
                        while ($row = mysqli_fetch_array($resultd)) {
                            echo $td = $row['tatal'];
                        }

                        ?>

                    </td>

                </tr>
            </table>

        </td>
        <td align="center">
            <table width="100%">
                <tr>
                    <th>Total</th>
                    <td>

                        <?php
                        $t_cap = "SELECT sum(balance) as cap_tot  FROM `ledger`,`accounts` where accounts.aid=ledger.aid and accounts.name='Capital' ";
                        $resul = mysqli_query($conn, $t_cap);

                        $st_expenses = "SELECT SUM(balance) AS exp_total from accounts, ledger where type='Expenses' and accounts.aid=ledger.aid;";
                        $result_exp = mysqli_query($conn, $st_expenses);

                        while ($row = mysqli_fetch_assoc($result_exp)) {
                            $td_exp = $row['exp_total'];
                        }
                        while ($row = mysqli_fetch_array($resul)) {
                            $td_n = $row['cap_tot'];
                        }
                        echo ($cost) + $td_n;
                        ?>
                    </td>

                </tr>
            </table>

        </td>
    </tr>

    </table>
</body>

</html>