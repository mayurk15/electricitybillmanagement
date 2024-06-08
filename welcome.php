<?php
// Establish database connection
$dbcon = mysqli_connect("localhost", "root", "", "web");

// Check if the connection was successful
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = '';
$bill_amount = 0; // Initialize bill amount to 0

if(isset($_POST['Submit'])) {
    // Get the meter number entered by the user and sanitize it
    $meter_no = $_POST['meter_no'];

    // Prepare and execute the query using a prepared statement
    $stmt = $dbcon->prepare("SELECT bill FROM users WHERE meter_no = ?");
    $stmt->bind_param("s", $meter_no);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result) {
        // Check if any rows were returned
        if($result->num_rows > 0) {
            // Fetch the bill data
            $bill_data = $result->fetch_assoc();
            // You can display the bill data as required, for example:
            $bill_amount = $bill_data['bill'];
            $message = "Your bill amount is ₹$bill_amount";

        } else {
            $message = "No bill found for the entered meter number.";
        }
    } else {
        // If there was an error in executing the query, log it and display a generic message
        error_log("MySQL Error: " . $dbcon->error);
        $message = "An error occurred while processing your request. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Electricity Bill Payment</title>
    <link rel="stylesheet" href="welcome.css"> <!-- Link to your CSS file -->
</head>
<style>
.logout-btn {
    position: fixed;
    top: 20px; /* Adjust top position as needed */
    right: 20px; /* Adjust right position as needed */
    z-index: 999; /* Ensure it's above other elements */
}

.logout-btn a {
    text-decoration: none;
    color: #fff;
    background-color: #FF0000; /* Red color */
    padding: 10px 20px;
    border-radius: 5px;
    border: 1px solid #FF0000; /* Red color */
    transition: background-color 0.3s, color 0.3s;
    font-weight: bold;
    text-transform: uppercase;
}

.logout-btn a:hover {
    background-color: #E60000; /* Darker red color on hover */
}


</style>
<body>
    <div class="container">
        <h1>ELECTRAPAY</h1>
        <div class="payment-form">
            <h4>Your Electricity Bill</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> <!-- Ensure the form action is set to the current PHP file -->
                <label for="meter_no">Meter No:</label>
                <input type="number" id="meter_no" name="meter_no" required>
                <button type="submit" name="Submit">Submit</button> <!-- Ensure the submit button has the name attribute set to "Submit" -->
            </form>
            <div class="message">
                <?php if ($message): ?>
                    <p><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>
            </div>
            <?php if ($bill_amount > 0): ?>
            <div class="payment-methods">
                <h3>Choose a payment method to complete your bill payment</h3>
                <ul>
                    <li><a href="credit.php?meter_no=<?php echo $meter_no; ?>&bill_amount=<?php echo $bill_amount; ?>">Credit card</a></li>
                    
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <div class="logout-btn">
        <p><a href="logout.php" >Log out</a></p>
        </div>
    </div>

    <script>
        function submitForm() {
            document.getElementById("meterForm").submit();
        }
    </script>
</body>
</html>
