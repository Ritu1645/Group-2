<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/apply_account.css">
    <title>Apply</title>
    <style>
        /* Keep the Account Type label fixed above the box */
        .input-field.fixed-label {
            position: relative;
            margin-bottom: 20px;
        }

        .input-field.fixed-label input {
            width: 100%;
            padding: 12px 10px;
            font-size: 16px;
            background-color: #fff;
            border: 1px solid #ccc;
            outline: none;
        }

        .input-field.fixed-label label {
            position: static; /* Label stays above the input */
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
    </style>
</head>

<?php
include("database.php");
session_start();

$error_account = "";
$error = false;

if (isset($_POST['next'])) {
    $pin = $_POST['pin'];
    $nid = $_SESSION['nid'];

    // Check if customer already has an account
    if ($_SESSION['has'] == true) {
        $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM account 
                                                      INNER JOIN customer USING(customer_id) 
                                                      WHERE nid = '$nid'"));
        if ($row) {
            $error_account = "You already have an account.";
            $error = true;
        }
    }

    // Insert customer if not exists
    if (!$error && $_SESSION['has'] == false) {
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];
        $gender = $_SESSION['gender'];
        $dob = $_SESSION['dob'];
        $division = $_SESSION['division'];
        $district = $_SESSION['district'];
        $address = $_SESSION['address'];
        $filename = $_SESSION['filename'];

        mysqli_query($con, "INSERT INTO customer(nid, first_name, last_name, picture, email, phone, gender, address, division, district, dob)
                            VALUES('$nid', '$first_name', '$last_name', '$filename', '$email', '$phone', '$gender', '$address', '$division', '$district', '$dob')");
    }

    // Insert account
    if (!$error) {
        $cust_info = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM customer WHERE nid = '$nid'"));
        $customer_id = $cust_info['customer_id'];

        mysqli_query($con, "INSERT INTO account(customer_id, balance, pin_code, status)
                    VALUES('$customer_id', '0', '$pin', 'pending')");


        $rrr = mysqli_fetch_assoc(mysqli_query($con, "SELECT account_no FROM account WHERE customer_id = '$customer_id'"));
        $_SESSION['account_no'] = $rrr['account_no'];

        echo "<script> window.location.href='account_pdf.php'; </script>";
    }
}
?>

<body>
    <div>
        <?php include("header.php") ?>
    </div>
    <div class="main">
        <div class="crd">
            <h3 class="navbar d-flex justify-content-center mb-3 mt-2">Account Registration</h3>
            <form action="" method="post">

                <!-- Fixed Student Account Box -->
                <div class="input-field fixed-label">
                    <label>Account Type</label>
                    <input type="text" value="Student Account" readonly>
                </div>

                <!-- Pin Code Box -->
                <div class="input-field">
                    <input type="number" required spellcheck="false" name="pin">
                    <label>Pin Code</label>
                </div>

                <div class="d-flex">
                    <input type="submit" value="Apply" name="next" class="next">
                    <a style="text-decoration: none;" href="apply_customer.php">
                        <div class="back">Back</div>
                    </a>
                </div>

                <div style="color:red; margin-top:10px;">
                    <?php echo $error_account ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
