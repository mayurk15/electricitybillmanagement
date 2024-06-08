<?php
// Establish database connection
$dbcon = mysqli_connect("localhost", "root", "", "web");

// Check if the connection was successful
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve meter number and bill amount from URL parameters
if (isset($_GET['meter_no']) && isset($_GET['bill_amount'])) {
    $meter_no = $_GET['meter_no'];
    $bill_amount = $_GET['bill_amount'];
}

// Reset the bill amount to 0 for the chosen meter number when the form is submitted
if(isset($_POST['Submit'])) {
    // Reset the bill amount to 0 for the chosen meter number
    $reset_query = $dbcon->prepare("UPDATE users SET bill = 0 WHERE meter_no = ?");
    $reset_query->bind_param("s", $meter_no);
    $reset_query->execute();
    
    // Check if the query was successful
    if($reset_query) {
        // Redirect to end.html or any other page
        header("Location: end.html");
        exit();
    } else {
        echo "Error resetting bill amount.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/topuhit/Font-Bangla@1.0.3/1.0.0/font-bangla.css"> 
    <title>Credit Card Payment</title>
    <link rel="stylesheet" type="text/css" href="credit.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="container">
        <h1><center>Electrapay</center></h1>   
        <form class="payment-form" id="paymentForm" action="" method="post"> 
            <div class="payment-details">
                <h2>Payment</h2>
                <label for="fname">Accepted Cards</label>
                <div class="icon-container">
                    <i class="fa fa-cc-visa" style="color:navy;"></i>
                    <i class="fa fa-cc-amex" style="color:blue;"></i>
                    <i class="fa fa-cc-mastercard" style="color:red;"></i>
                    <i class="fa fa-cc-discover" style="color:orange;"></i>
                </div>
                <label for="cname">Name on Card</label>
                <input type="text" id="cname" name="cardname" placeholder="Enter name" pattern="[A-Za-z ]+" title="Please enter letters only" required>
                <label for="ccnum">Credit card number</label>
                <input type="text" id="ccnum" name="cardnumber" placeholder="Enter a 10-digit number" pattern="[0-9]{10}" title="Please enter a 10-digit number" required>
                <div class="expiry-cvv">
                    <div class="col-50">
                        <label for="expmonth">Exp Month</label>
                        <input type="text" id="expmonth" name="expmonth" placeholder="MM" pattern="(0[1-9]|1[0-2])" title="Please enter a valid month (MM)" required>
                    </div>
                    <div class="col-50">
                        <label for="expyear">Exp Year</label>
                        <input type="text" id="expyear" name="expyear" placeholder="YYYY" pattern="[0-9]{4}" title="Please enter a valid year (YYYY)" required>
                    </div>
                    <div class="col-50">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="CVV" pattern="[0-9]{3,4}" title="Please enter a valid CVV (3 or 4 digits)" required>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <input type="submit" value="Submit" class="btn btn-submit" name="Submit">
                <input type="reset" value="Reset" class="btn btn-reset">
            </div>
        </form>
    </div>

</body>
</html>
