<?php
   include_once('dbcon.php');
   
   $error = false;
   if (isset($_POST['btn-register'])){
       // clean user input to prevent sql injection
       $username = $_POST['username'];
       $username = strip_tags($username);
       $username = htmlspecialchars($username);
   
       $email = $_POST['email'];
       $email = strip_tags($email);
       $email = htmlspecialchars($email);
   
       $password = $_POST['password'];
       $password = strip_tags($password);
       $password = htmlspecialchars($password);
   
       //validate
       if (empty($username)){
           $error = true;
           $errorUsername = 'Please input username';
       }
   
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
           $error = true;
           $errorEmail = 'Please a valid email';
       }
   
       if (empty($password)) {
           $error = true;
           $errorPassword = 'Please input password';
       } elseif (strlen($password) < 6){
           $error = true;
           $errorPassword = 'Password must be at least 6 characters';
       }
   
       //encrypt password with md5
       $password = md5($password);
   
       //insert data if no error
       if(!$error) {
           $sql = "INSERT INTO tbl_user(username, email, password)
                   VALUES('$username', '$email', '$password')";
           if(mysqli_query($conn, $sql)){
               $successMsg = 'Register Successful! <a href="index.php">Click here to login</a>';
           }else {
               echo 'Error '.mysqli_error($conn);
           }
       }
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>PHP Login & Register</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
   </head>
   <body>
      <div class="container">
         <div style="width: 500px; margin: 50px auto;">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
               <center>
                  <h2>Register</h2>
               </center>
               <hr/>
               <?php
                  if (isset($successMsg)){
                ?>
               <div class="alert alert-success">
                  <span class="glyphicon glyphicon-info-sign">
                  <?php echo $successMsg ?>
               </div>
               <?php 
                  }
                ?>
               <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" name="username" class="form-control" autocomplete="off">
                  <span class="text-danger"><?php if(isset($errorUsername)) echo $errorUsername; ?></span>
               </div>
               <div class="form-group">
                  <label for="email" class="control-label">Email</label>
                  <input type="email" name="email" class="form-control" autocomplete="off">
                  <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail; ?></span>
               </div>
               <div class="form-group">
                  <label for="password" class="control-label">Password</label>
                  <input type="password" name="password" class="form-control" autocomplete="off">
                  <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword; ?></span>
               </div>
               <div class="form-group">
               <center><input type="submit" name="btn-register" value="Login" class="btn btn-primary"></center>
         </div>
         <hr/>
         <a href="index.php">Login</a>
         </form>
      </div>
      </div>  
   </body>
</html>