<?php
$dbcon = mysqli_connect("localhost", "root", "");

// Check if the connection was successful
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
$db_selected = mysqli_select_db($dbcon, 'web');


if(isset($_POST['update'])) {
    $user_id = $_POST['id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $meter_no = $_POST['meter_no'];
    $bill = $_POST["bill"];
    $user_pass = $_POST['user_pass'];

    // Ensure to use prepared statements to prevent SQL injection
    $stmt = $dbcon->prepare("UPDATE users SET user_name=?, user_email=?, bill=?, meter_no=?, user_pass=? WHERE id=?");
    $stmt->bind_param("ssiiis", $user_name, $user_email, $bill, $meter_no, $user_pass, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: view_users.php");
    exit(); // Add an exit to prevent further execution
}

$user_id = $_GET['id'];
$result = mysqli_query($dbcon, "SELECT * FROM users WHERE id=$user_id");
while($res = mysqli_fetch_array($result)) {
    $user_name = $res['user_name'];
    $user_email = $res['user_email'];
    $meter_no = $res['meter_no'];
    $bill = $res['bill'];
    $user_pass = $res['user_pass'];
}
?>

<html>
<head>
    <title>Online Electricity Bill Payment | Update Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input[type="submit"] {
            width: auto;
            padding: 10px 20px;
            background-color: #4caf50;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update User</h2>
    <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?php echo $user_id; ?>">
        <div class="form-group">
            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>">
        </div>
        <div class="form-group">
            <label for="user_email">User Email:</label>
            <input type="email" id="user_email" name="user_email" value="<?php echo $user_email; ?>">
        </div>
        <div class="form-group">
            <label for="meter_no">Meter No:</label>
            <input type="number" id="meter_no" name="meter_no" value="<?php echo $meter_no; ?>">
        </div>
        <div class="form-group">
            <label for="bill">Bill:</label>
            <input type="number" id="bill" name="bill" value="<?php echo $bill; ?>">
        </div>
        <div class="form-group">
            <label for="user_pass">Password:</label>
            <input type="password" id="user_pass" name="user_pass" value="<?php echo $user_pass; ?>">
        </div>
        <div class="form-group">
            <input type="submit" name="update" value="Update Data">
        </div>
    </form>
</div>
</body>
</html>
