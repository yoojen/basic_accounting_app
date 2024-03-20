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

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-top: 20px;
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
            padding: 10px;
            color: white;
            text-transform: uppercase;
        }

        table td {
            /* padding: 10px; */
            color: black;
            padding-left: 10px;
        }

        tr:nth-child(even) {
            background-color: ;
        }

        .total {
            text-transform: uppercase;
            background-color: lightseagreen;
            color: white;
            padding: 15px;
            font-size: 25px;
            font-family: stencil;
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
    <h2>Trial balance</h2>
    <table width="70%" border="1" align="center">
        <tr>
            <th>Account</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>

        <?php

        $my_balance = 0;
        $my_cred = 0;
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
                if ($type == 'Assets' || $type == 'Stock Item') {
                    ?>
                    <td>
                        <?php echo $name; ?>
                    </td>
                    <td>
                        <?php $my_balance = $my_balance + $balance;
                        echo $balance; ?>
                    </td>
                    <td></td>
                    <?php

                } else if ($type == 'Expenses') {
                    ?>
                        <td>
                        <?php echo $name; ?>
                        </td>

                        <td>
                        <?php $my_balance = $my_balance + $balance;
                        echo $balance; ?>
                        </td>
                        <td></td>
                        <?php
                } else {
                    ?>
                        <td>
                        <?php echo $name; ?>
                        </td>
                        <td></td>

                        <td>
                        <?php $my_cred = $my_cred + $balance;
                        echo $balance; ?>
                        </td>
                        <?php
                }


                ?>

            </tr>
            <?php
        }

        ?>

        <tr>
            <td class="total">Totals</td>
            <td class="total">
                <?php echo $my_balance; ?>
            </td>
            <td class="total">
                <?php echo $my_cred; ?>
            </td>
        </tr>
    </table>

</body>

</html>