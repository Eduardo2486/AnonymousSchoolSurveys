<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(isset($_SESSION['user_id'])){
	header('Location: home.php');
}

if(isset($_POST['submit'])){
    $user = $getFromU->checkInput($_POST['user']);
    $password = $getFromU->checkInput($_POST['password']);

    if(empty($user) or empty($password)){
        $error = "Fill all the input fields.";
    }else{
        $result = $getFromU->loginUser($user,$password);
        if($result){
            header('Location: home.php'); 
        }else{
            $error="Error try again later.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">

</head>
<body>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-4">
          <div class="blog-post">
            <br>
            <div class="medium-5 large-3 cell">
              <div class="callout secondary">

            <form action="login.php" method="POST" class="form-login">
                <label><h5>User</h5>
                <input class="user-login-input" type="text" name="user" placeholder="User">
                </label>
                
                <label><h5>Password</h5>
                <input class="password-login-input" type="password" name="password" placeholder="Password">
                </label>
                <input type="submit" value="Log in" class="button" name="submit">
                <a href="<?php echo 'create-password.php'; ?>">Create password</a>
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