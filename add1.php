
<html>
<head>
<title> Online Electricity Bill Payment | Add Data</title>
</head>
<div class="go-back">
    <a href="javascript:self.history.back();" class="back-link">Go Back</a>
</div>
<style>


body{
     height: float;
     width: float;
     background: url('http://localhost/projectfinal/bill payment/images/black-clouds-87utstxo0bgqdgh8.jpg');
     background-repeat:no-repeat;
     background-color:#3ea394;
	 background-size:cover;
  
	}	
    .back-link {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.back-link:hover {
    text-decoration: underline;
}
.success-message {
    color: #fff; /* White color */
    font-size: 24px; /* Larger font size */
    margin-bottom: 20px;
    font-weight: bold;
    text-transform: uppercase; /* Convert to uppercase */
    text-align: center; /* Center align */
}
.view {
    color: #fff; /* White color */
    font-size: 14px; /* Larger font size */
    margin: 0 auto; /* Center horizontally */
    display: block; /* Make it a block element */
    width: fit-content; /* Adjust width based on content */
    font-weight: bold;
    text-transform: uppercase; /* Convert to uppercase */
    text-align: center; /* Center align */
}

        

    </style>

<body class ="php">


<?php


include("database/db_conection.php");

if(isset($_POST['Submit'])) {
    
    $user_name=$_POST['name'];
	$user_email=$_POST['email'];
	$meter_no= $_POST['meter'];
    $bill=$_POST['bill'];
    $user_pass=$_POST['user_pass'];
	

    $check_name_query="select * from users WHERE user_name='$user_name'";
    $check_email_query="select * from users WHERE user_email='$user_email'";
	$check_meter_no_query="select * from users WHERE meter_no='$meter_no'";
	
	
	
	$run_query=mysqli_query($dbcon, $check_name_query);
	
    $run_query2=mysqli_query($dbcon, $check_email_query);
	$run_query3=mysqli_query($dbcon, $check_meter_no_query);
	
	
	 if(mysqli_num_rows($run_query)>0)
    {
echo "<script>alert('Name $user_name is already exist in  database, Please try another one!')</script>";
exit();
    }

    if(mysqli_num_rows($run_query2)>0)
    {
echo "<script>alert('Email $user_email is already exist in  database, Please try another one!')</script>";
exit();
    }
	
	 if(mysqli_num_rows($run_query3)>0)
    {
echo "<script>alert('Meter No $meter_no is already exist in our database, Please try another one!')</script>";
exit();
    }
	

	

$result = mysqli_query($dbcon, "INSERT INTO users(user_name, user_email, user_pass, meter_no, bill) VALUE ('$user_name','$user_email',  '$user_pass', '$meter_no','$bill')");
echo "<p class='success-message'>Data  added successfully !!!</p>";

echo "<br/><a href='view_users.php' class='view'>View Result</a>";

}

?>

</body>
</html>