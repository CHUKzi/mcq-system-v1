<?php
session_start();
include('includes/config.php');
if(isset($_POST['login']))
{
$email=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM admin WHERE UserName=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$result=$query->fetch(PDO::FETCH_OBJ);
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];


$sql = "SELECT * from admin where UserName=:email";
$query = $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);


$_SESSION['admin_level']=$result->admin_level;

$sql="UPDATE admin SET last_login = NOW() WHERE username='{$_SESSION['alogin']}'";
$query = $dbh -> prepare($sql);
$query->execute();

echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
} else{
  
  echo "<script>alert('Invalid Details');</script>";

}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/stylelogin.css">
           
</head>
<body>
    <div class="center">
        <br>
        <h1>Admin Login</h1>
        <form method="post">
            <div class="txt_field">
                <input type="text" name="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <!--<div class="pass">Forgot Password?</div>-->
            <input name="login" type="submit">
            <div class="signup_link">
                Not a memeber? , <a href="https://www.facebook.com/royan.harsha.7">Server admin</a>
            </div>
        </form>
    </div>
    
</body>
</html>