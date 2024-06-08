<?php


include("database/db_conection.php");

if(isset($_POST['admin_login']))
{
    $admin_name = mysqli_real_escape_string($dbcon, $_POST['admin_name']); // Sanitize inputs
    $admin_pass = mysqli_real_escape_string($dbcon, $_POST['admin_pass']); // Sanitize inputs

    $admin_query = "SELECT * FROM admin WHERE admin_name='$admin_name' AND admin_pass='$admin_pass'";
    $run_query = mysqli_query($dbcon, $admin_query);

    if(mysqli_num_rows($run_query) > 0)
    {
        echo "<script>window.open('view_users.php','_self')</script>";
        exit(); // Add exit to stop further execution
    }
    else {
        echo "<script>alert('Admin Details are incorrect..!')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body>
    <div class="container vh-100">
        <div class="row justify-content-center h-100">
            <div class="card w-25 my-auto shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Admin Login</h2>
                </div>
                <div class="card-body">
                    <form action="" method="post"> <!-- Leave action blank to submit to the same page -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" class="form-control" name="admin_name" />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="admin_pass" />
                        </div>
                        <input type="submit" class="btn btn-primary w-100" value="Login" name="admin_login">
                    </form>
                
            </div>
        </div>
    </div>
</body>
</html>
