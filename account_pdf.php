<?php
include "database.php";
session_start();
$account_no = $_SESSION['account_no'];

// Fetch account with customer info only
$row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM account
                                               INNER JOIN customer
                                               USING(customer_id)
                                               WHERE account_no = '$account_no'"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account PDF</title>
    <style>
        .tbl {
            background-color: white;
            border: 2px solid black;
        }

        .tbl td,
        .tbl th {
            border: 1px solid black;
            color: green;
            height: 35px;
            padding-left: 10px;
        }

        .tbl th {
            width: 200px;
        }

        .tbl td {
            width: 300px;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn1 {
            margin-top: 10px;
            margin-left: 240px;
            height: 30px;
            width: 50px;
            border: none;
            background-color: #22a6b3;
            border-radius: 3px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div>
        <?php include "header.php" ?>
    </div>

    <div class="main">
        <div>
            <table class="tbl">
                <tr>
                    <th>Name</th>
                    <td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
                </tr>
                <tr>
                    <th>Account No</th>
                    <td><?php echo $account_no ?></td>
                </tr>
                <tr>
                    <th>Account Type</th>
                    <td>Student Account</td> <!-- Fixed text -->
                </tr>
                <tr>
                    <th>Pin Code</th>
                    <td><?php echo $row['pin_code'] ?></td>
                </tr>
            </table>

            <div>
                <label style="font-weight: bold;" for="">Remember this account no</label>
                <a href="index.php"> 
                    <button class="btn1">Ok</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
