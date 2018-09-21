<?php
session_start();
include_once('dbcon.php');

$error = false;

if(isset($_POST['btn-login'])){
    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $password = trim($_POST['password']);
    $password = htmlspecialchars(strip_tags($password));

    if(empty($email)){
        $error = true;
        $errorEmail = 'Please input email';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorEmail = 'Please enter a valid email';
    }

    if(empty($password)){
        $error = true;
        $errorPassword = 'Please enter password';
    } elseif (strlen($password) < 6) {
        $error = true;
        $errorPassword = 'Password has to be at least 6 characters';
    }

    if(!$error) {
        $password = md5($password);
        $sql = "select * from tbl_user where email='$email'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if($count==1 && $row['password'] == $password) {
            $_SESSION['username'] = $row['username'];
            header('location: home.php');
        } else {
            $errorMsg = 'Invalid Username or Password';
        }
    }
}
?>

<!<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP Login & Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
        <div style="width: 500px; margin: 50px auto;">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <center><h2>Login</h2></center>
                <hr/>
                <?php
                    if(isset($errorMsg)) {
                ?>
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $errorMsg; ?>
                        </div>
                <?php
                    }
                ?>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" name="email" class="form-control" autocomplete="0ff">
                    <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>                    
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" autocomplete="off">
                    <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
                </div>
                <div class="form-group">
                    <center><input type="submit" name="btn-login" value="Login" class="btn btn-primary"></center>
                </div>
                <hr/>
                <a href="register.php"
                </form>
            </div>
    </div>  
</body>
</html>