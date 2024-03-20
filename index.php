<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="login.css">
     <title>index</title>
</head>

<body>
     <div class="login-form">
          <div class="header">
               <h1>Sign in As Admin</h1>
          </div>

          <div class="error"></div>
          <div class="login-details">
               <form action="" method="POST">

                    <div class="Info">
                         <label for="username">Username</label>
                         <input type="text" name="name" placeholder="Username" required>
                    </div>

                    <div class="Info">
                         <label for="password">Password</label>
                         <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="submit">
                         <input type="submit" name="submit" value="Login">
                    </div>
               </form>

          </div>
     </div>

</body>

</html>
<?php

if (isset($_POST['submit'])) {
     $conn = mysqli_connect("localhost", "root", "");
     mysqli_select_db($conn, "quickBookClone");
     $username = $_POST['name'];
     $password = $_POST['password'];
     $query = mysqli_query($conn, "select * from users where username='$username' and password='$password'");
     $count = mysqli_num_rows($query);
     $row = mysqli_fetch_array($query);

     $capital_bal = "select sum(balance) as CAP_BAL,name from ledger,accounts
     where ledger.aid=accounts.aid and accounts.name='Capital';";
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
     $res_capital = $conn->query($capital_bal);
     while ($rowd = mysqli_fetch_array($res_capital)) {
          $total_capital = $rowd['CAP_BAL'];

     }

     if ($count > 0) {
          if ($total_capital <= 0) {
               echo "<script>
          alert('CREATE CAPITAL ACCOUNT FIRST')
          location.href='after_login.php'
          </script>";
          }
          if ($total_debit - $total_credit <= 0) {
               echo "<script>
             alert('DEBIT BANK ACCOUNT START YOUR TRANSCATION')
             location.href='after_login.php'
             </script>";
          }
          session_start();
          $_SESSION['username'] = $row['username'];

          ?>
          <script>
               const cont = document.querySelector('.login-form')
               let count = 0

               const load = () => {
                    cont.innerHTML = ` <h1>Loading.....</h1>`
                    count += 1
                    console.log(count)
                    if (count == 3) {
                         clearInterval(timer)
                         location.href = 'dashboard.html'
                    }
               }
               const timer = setInterval(load, 500)
          </script>

          <?php
     } else {
          ?>
          <script>
               const err = document.querySelector('.error')
               err.innerHTML = `<p style="color: red"> Incorrect username or password</p>`
          </script>
          <?php
     }
} ?>