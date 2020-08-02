<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
    $user_data = $getFromU->getUserData($_SESSION['user_id']);
    if($user_data == false){
        header('Location: login.php');
    }
}

if(isset($_POST['personal-data'])){
    $name = $getFromU->checkInput($_POST['name']);
    $fathers_last_name= $getFromU->checkInput($_POST['fathers-last-name']);
    $mothers_last_name=$getFromU->checkInput($_POST['mothers-last-name']);
    $email=$getFromU->checkInput($_POST['email']);
    $result = $getFromU->changePersonalData($_SESSION['user_id'],$name,$fathers_last_name,$mothers_last_name,$email);

    if($result){
        header("Location: user.php" );
    }else{
        $error = "Intenta otra vez.";
    }
}

if(isset($_POST['password-change'])){
    $password = $getFromU->checkInput($_POST['password']);
    $newPassword = $getFromU->checkInput($_POST['new-password']);
    $newAgainPassword = $getFromU->checkInput($_POST['new-again-password']);
    if($newPassword ===  $newAgainPassword){
        $result = $getFromU->changePassword($_SESSION['user_id'],$password,$newPassword,$newAgainPassword);
 
        if($result){
            header("Location: user.php" );
        }else{
            $error = "Try again.";
        }
    }else{
        $error = "New password and confirm new password does not match.";
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <style>
    /* Gradient color1 - color2 - color1 */

hr.style-one {
    border: 0;
    height: 1px;
    background: #333;
    background-image: linear-gradient(to right, #ccc, #333, #ccc);
    display: block;
margin: auto;
width: 100%;

}
hr.style-two {
    border: 0;
    height: 1px;
    background: #fff;
    background-image: linear-gradient(to right, #fff, #fff, #fff);
    display: block;
margin: auto;
width: 100%;

}
    </style>
</head>
<body>
    <?php require_once './includes/header.php'; ?>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-8">
            <h3>User settings</h3>   
            <?php
                if(isset($error)){
                    echo $error;
                }
                
             ?>
            <form method="POST" action="user.php">
            <div class="grid-x">
              <div class="small-3 cell">
                <label for="name-label" class="middle">Name</label>
              </div>
              <div class="small-9 cell">
                <input type="text" id="name-label" placeholder="Name" value="<?php echo $user_data->name; ?>" name="name">
              </div>
              <div class="small-3 cell">
                <label for="last-surname-label" class="middle">Father's last name</label>
              </div>
              <div class="small-9 cell">
                <input type="text" id="last-surname-label" placeholder="Fathers last name" value="<?php echo $user_data->fathers_last_name; ?>" name="fathers-last-name">
              </div>
              <div class="small-3 cell">
                <label for="last-name-label" class="middle">Mother's last name</label>
              </div>
              <div class="small-9 cell">
                <input type="text" id="last-name-label" placeholder="Mothers last name" value="<?php echo $user_data->mothers_last_name; ?>" name="mothers-last-name">
              </div>
              <div class="small-3 cell">
                <label for="email-label" class="middle">Email</label>
              </div>
              <div class="small-9 cell">
                <input type="text" id="email-label" placeholder="Email" value="<?php echo $user_data->email; ?>" name="email">
              </div>
              <input type="submit" class="button large expanded" value="Save" name="personal-data">

              <hr class="style-two">
              <h6 style="text-align:center;">Change password:</h6>  
              <hr class="style-one" style="margin-bottom:15px;">

              <div class="small-3 cell">
                <label for="password-label" class="middle">Actual password</label>
              </div>
              <div class="small-9 cell">
                <input type="password" id="password-label" placeholder="Actual password" name="password">
              </div>
              <div class="small-3 cell">
                <label for="new-password-label" class="middle">New password</label>
              </div>
              <div class="small-9 cell">
                <input type="password" id="new-password-label" placeholder="New Password"  name="new-password">
              </div>
              <div class="small-3 cell">
                <label for="again-new-password-label" class="middle">Confirm new password</label>
              </div>
              <div class="small-9 cell">
                <input type="password" id="again-new-password-label" placeholder="Confirm new password" name="new-again-password">
              </div>
              <input type="submit" class="button large expanded" value="Change password" name="password-change">
            </div>
            </form>
        </div>
      </div>
    </article>
</body>
</html>