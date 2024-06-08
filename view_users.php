<?php
include("database/db_conection.php");

function sanitize($input) {
    global $dbcon;
    return mysqli_real_escape_string($dbcon, htmlspecialchars($input));
}

function displayMessage($message) {
    echo "<div class='message'>$message</div>";
}

if(isset($_GET['delete_id'])) {
    $delete_id = sanitize($_GET['delete_id']);

    // Prepare and execute the delete query using a prepared statement
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $dbcon->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    $delete_result = $stmt->execute();

    if($delete_result) {
        // Update the IDs of the rows to match the number of rows
        $update_query = "SET @count = 0";
        mysqli_query($dbcon, $update_query);
        $update_query = "UPDATE users SET id = @count := @count + 1";
        $update_result = mysqli_query($dbcon, $update_query);

        if($update_result) {
            // Get the number of rows after deletion
            $count_query = "SELECT COUNT(*) as count FROM users";
            $count_result = mysqli_query($dbcon, $count_query);
            $count_row = mysqli_fetch_assoc($count_result);
            $count = $count_row['count'];

            // Set the auto-increment value to the number of rows
            $auto_increment_query = "ALTER TABLE users AUTO_INCREMENT = $count";
            mysqli_query($dbcon, $auto_increment_query);

            $message = "User deleted successfully!";
        } else {
            $message = "Error occurred while updating IDs!";
        }
    } else {
        $message = "Error occurred while deleting user!";
    }
}

$result = mysqli_query($dbcon, "SELECT * FROM users");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Online Electricity Bill Payment</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f4fff4 url('path/to/your/image.jpg') no-repeat center center/cover;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .admin-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .admin-link:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .update-delete-links a {
            color: #333;
            text-decoration: none;
            margin-right: 10px;
        }

        .update-delete-links a:hover {
            color: #45a049;
        }

        #logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Panel</h1>
    <div>
        <a href="add.html" class="admin-link">Insert New Data</a>
    </div>
    <table>
        <tr>
            <th>User Id</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Meter No</th>
            <th>Bill</th>
            <th>User Pass</th>
            <th>Update / Delete</th>
        </tr>
        <?php
        while($res = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>".$res['id']."</td>";
            echo "<td>".$res['user_name']."</td>";
            echo "<td>".$res['user_email']."</td>";
            echo "<td>".$res['meter_no']."</td>";
            echo "<td>₹".$res['bill']."</td>"; // Added rupee symbol before bill amount
            echo "<td>".$res['user_pass']."</td>";
            echo "<td class='update-delete-links'>
                      <a href=\"update.php?id=$res[id]\">Update</a>
                      <a href=\"view_users.php?delete_id=$res[id]\">Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<a href="logout.php" id="logout-btn" class="admin-link">Log out</a>

</body>
</html>
