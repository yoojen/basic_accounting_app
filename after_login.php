<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>

    <style>
        body {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            height: 100vh;
            background: linear-gradient(to right, darkgreen, darkblue);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0;
            margin: 0;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
        }

        form {
            border-radius: 10px;
            padding: 50px 20px;
            background-color: white;
            min-width: 800px;
            /* margin-left: 50%; */
            /* transform: translateX(-50%); */
        }

        #make_trans {
            cursor: pointer;
            padding: 10px 20px;
            font-weight: 800;
            border: none;
            background-color: lightgreen;
            /* height: 30px; */
            width: 100px;
            margin-top: 20px;
            margin-left: 80%;
            transition: .3s ease-in;
        }

        #make_trans:hover {
            margin-top: 25px;
            margin-left: 82%;
            padding: 7px;
            width: 80px;
            background-color: orangered;
        }

        input {
            width: 100px;
            padding: 10px 0;
        }

        .box{
            margin-left: 50px;
        }
        .first,.second{
            color: red;
        }
        .second{
            margin-top: -30px;
        }
        h3{
            text-align: center;
        }
    </style>
    </style>
</head>

<body>
    <form onsubmit="validateForm()" action="" method='post'>
        <h1 class="first">You can't start business without</h1>
        <h1 class="second">capital account and balance at bank</h1>
        <h3>CREATE CAPITAL ACCOUNT</h3>
        <div class="box">

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
                    <option value=<?php echo $row['aid'] ?>>
                        <?php echo $row['name'] ?>
                    </option>
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
                    <option value=<?php echo $row['aid'] ?>>
                        <?php echo $row['name'] ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <label for="amount">Amount</label>
            <input type='number' name='ca' required />
        </div>
        <a href=""><button type="submit" name="submit" id="make_trans">Record</button></a>
    </form>

    <script>
        const form = document.getElementById('make_trans');
        function validateForm() {
            // Get the select option value
            const dr_val = document.getElementById('dr').value;
            const cr_val = document.getElementById('cr').value;
            console.log(dr_val, cr_val)
            // Check if the select option is not empty
            if (dr_val != 7) {
                alert("PLEASE DEBIT BANK");
                event.preventDefault()
            } else if (cr_val != 17) {
                alert("PLEASE CREDIT CAPITAL.");
                event.preventDefault()
            }
            <?php

            ?>
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
    ?>
    <script>
        alert(<?php echo "YOU STARTED BUSINESS WITH CAPITAL OF $debita"; ?>)
    </script>
    <?php
    $a = mysqli_query($conn, "INSERT INTO `jurnal` (`id`,`date`, `aid`, `debit`, `credit`) 
        VALUES (NULL,'$dat','$debita', '$ca', '');");
    echo "<script>location.href='dashboard.html'</script>";

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