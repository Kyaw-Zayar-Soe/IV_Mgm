<?php
 require('init.php');
 if(isset($_SESSION['user'])){
   go('index.php');
 }
 if($_SERVER['REQUEST_METHOD'] =='POST'){
   $email = $_REQUEST['email'];
   $password = $_REQUEST['password'];

   if(empty($email)){
     setError('Please Enter Email');
   }

   if(empty($password)){
     setError('Please Enter Password');
   }

   $user = getOne('Select * from users where email=?',[$email]);
   if(!$user){
     setError('Email not found');
   }
   if($user){
     $ver = password_verify($password,$user->password);
     if(!$ver){
       setError('Wrong Password');
     }
   }
   
   if(!hasError()){
     $_SESSION['user'] = $user;
     go('index.php');
   }
    
 }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/argon-design-system.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />

    <title>Kuro_K</title>
  </head>
  <body>
    <div class="container mt-5">
      <div class="row">
        <div class="col-4 offset-4">
          <div class="card">
            <div class="card-header bg-gradient-green text-dark text-center">
                <u><B>LogIn to your Account</B></u><br>
                Welcome Back!
            </div>
            <div class="card-body bg-gradient-gray">
              <?php showError(); ?>
              <form action="" method='POST'>
                <div class="form-group">
                  <label for=""><b>Email</b></label>
                  <input type="text" class="form-control" name='email' placeholder="name@example.com" />
                </div>
                <!-- password -->
                <div class="form-group">
                  <label for=""><b>Password</b></label>
                  <input type="text" class="form-control" name='password' placeholder="Password" />
                </div>
                <div class='form-group text-center'>
                <input type="submit" text-align='center' value="Continue" class="btn btn-outline-dark" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
