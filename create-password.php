<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(isset($_SESSION['user_id'])){
	header('Location: home.php');
}

if(isset($_POST['submit'])){
    $email = $getFromU->checkInput($_POST['email']);
    $enrollment = $getFromU->checkInput($_POST['enrollment']);
    $password = $getFromU->checkInput($_POST['password']);
    $passwordConfirm = $getFromU->checkInput($_POST['password-repeat']);
    
    if(empty($email) OR empty($enrollment) OR empty($password) OR empty($passwordConfirm)){
        $error = "Fill all fields.";
    }else{
        if($password == $passwordConfirm){
            $result = $getFromU->createPassword($email,$enrollment, $password);
            if($result){
                header('Location: login.php'); 
            }else{
                $error="Already set password.";
            }
        }else{
            $error = "Passwords are not equal.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">

</head>
<body>
    <div class="top-bar">
      <div class="top-bar-left">
        <ul class="menu">
          <li class="menu-text"><a href='<?php echo 'login.php'; ?>'>Log In</a></li>
        </ul>
      </div>
    </div>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-4">
          <div class="blog-post">
            <br>
            <div class="medium-5 large-3 cell">
              <div class="callout secondary">

            <form action="create-password.php" method="POST" class="form-login">
                <label><h5>Email</h5>
                <input class="user-login-input" type="text" name="email" placeholder="Email">
                </label>
                <label><h5>Enrollment</h5>
                <input class="user-login-input" type="text" name="enrollment" placeholder="Enrollment">
                </label>
                <label><h5>Password</h5>
                <input class="password-login-input" type="password" name="password" placeholder="Password">
                </label>
                <label><h5>Confirm Password</h5>
                <input class="password-login-input" type="password" name="password-repeat" placeholder="Password">
                </label>
                <input type="submit" value="Create Password" class="button" name="submit">
                <?php 
                    if(isset($error)){
                        echo "<span style='text-align: center;display: block;color: red;background: white;font-family: Arial;'>". $error ."</span>";
                    }
                ?>
            </form>
            </div>
            </div>
          </div>
        </div>
      </div>
    </article>
</body>
</html>