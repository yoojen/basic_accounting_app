<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header-style.css">
    <link rel="stylesheet" href="transaction-style.css">
    <link rel="stylesheet" href="footer-style.css">
    <link rel="stylesheet" href="sty.css">
    <title>A/C</title>
    <style>
        * {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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
            width: 80%;
        }

        table td {
            padding: 10px;
            width: 40%;
        }

        tr:nth-child(even) {
            background-color: #aaa;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .balance {
            text-align: right;
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

    <table width="100%">
        <h1>Profit & Loss A/c</h1>

        <tr>
            <th>Income &revenue</th>
            <th class="balance">Rwf</th>
        </tr>
        <!-- profit and los -->
        <?php
        $conn = mysqli_connect("localhost", "root", "");
        mysqli_select_db($conn, "quickBookClone");

        $query = "SELECT name,balance,type FROM `accounts`, ledger WHERE accounts.aid=ledger.aid and balance > 0";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            @$name = $row['name'];
            @$balance = $row['balance'];
            @$type = $row['type'];

            ?>
            <tr>
                <?php
                if ($type == 'Income' || $type == 'Revenue') {

                    ?>
                    <td>
                        <?php echo $name; ?>
                    </td>
                    <td class="balance">
                        <?php echo $balance; ?>
                    </td>

                    <?php
                } else if ($type == 'stock') {

                    ?>
                        <td>
                        <?php echo $name; ?>
                        </td>
                        <td class="balance">
                        <?php echo "($balance)"; ?>
                        </td>

                        <?php
                }
                ?>
            </tr>
            <?php

        }
        ?>

        <tr>
            <td>
                <?php echo "COST OF GOOD SOLD"; ?>
            </td>
            <?php
            $conn = mysqli_connect("localhost", "root", "");
            mysqli_select_db($conn, "quickBookClone");
            $cq = "SELECT SUM(balance) AS total from accounts, ledger where name='sales' and accounts.aid=ledger.aid;";
            $resultc = mysqli_query($conn, $cq);
            while ($row = mysqli_fetch_assoc($resultc)) {
                $tc = $row['total'];
            }
            $st = "SELECT SUM(balance) AS stock_total from accounts, ledger where name='Stock Item' and accounts.aid=ledger.aid;";
            $result_c = mysqli_query($conn, $st);
            while ($row = mysqli_fetch_assoc($result_c)) {
                $td = $row['stock_total'];
            }
            ?>

            <td class="balance" style="font-weight: 800; font-size: 20px; color: blue; text-decoration: underline">
                <?php echo $cost = $tc - $td ?>
            </td>
            <?php
            ?>
        </tr>
    </table>


    <table width="100%">
        <tr>
            <th>Expenses</th>
            <th class="balance">Rwf</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "");
        mysqli_select_db($conn, "quickBookClone");

        $query = "SELECT name,balance,type FROM `accounts`,ledger WHERE accounts.aid=ledger.aid and balance > 0";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            @$name = $row['name'];
            @$balance = $row['balance'];
            @$type = $row['type'];

            ?>

            <tr>
                <?php
                if ($type == 'Expenses' || $type == 'Loss') {

                    ?>
                    <td>
                        <?php echo $name; ?>
                    </td>
                    <td class="balance">
                        <?php echo $balance; ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>
                <?php echo "TOTAL EXPENSES"; ?>
            </td>
            <?php
            $conn = mysqli_connect("localhost", "root", "");
            mysqli_select_db($conn, "quickBookClone");

            $st_expenses = "SELECT SUM(balance) AS exp_total from accounts, ledger where type='Expenses' and accounts.aid=ledger.aid;";
            $result_exp = mysqli_query($conn, $st_expenses);
            while ($row = mysqli_fetch_assoc($result_exp)) {
                $td_exp = $row['exp_total'];
            }
            ?>

            <td class="balance" style="font-weight: 800; font-size: 20px; color: red; text-decoration: underline">
                <?php echo $td_exp ?>
            </td>
            <?php
            ?>
        </tr>
        <?php
        ?>



    </table>
    <table>
        <tr>
            <td colspan="2">Net Loss/Profit</td>
            <td class="balance">
                <?php
                if ($cost - $td_exp < 0) {
                    ?>
                    <p style="font-weight: 800; font-size: 20px; color: red;">(
                        <?php
                        echo -1 * ($cost - $td_exp);
                        ?>
                        )
                    </p>
                    <?php
                } else {
                    ?>
                    <p style="text-align:right; font-weight: 800; font-size: 20px; color: blue;">
                        <?php
                        echo ($cost - $td_exp);
                        ?>

                    </p>

                    <?php
                }
                ?>
            </td>
        </tr>
    </table>

</body>

</html>