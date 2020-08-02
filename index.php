<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(isset($_GET['saved'])){
  if($_GET['saved'] == 'succesfull'){
    $message = "Your evaluation have been saved successfully.";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">

</head>
<body>
    <div class="top-bar">
      <div class="top-bar-left">
        <ul class="menu">
        <?php 
          if(isset($_SESSION['name'])){
            echo '<li class="menu-text"><a href="home.php">'.$_SESSION['name'].'</a></li>';
          }else{
            echo '<li class="menu-text"><a href="login.php">Log in</a></li>';
          }
          
        ?>
        </ul>
      </div>
    </div>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-4">
          <div class="blog-post">
            <br>
            <br>
            <br>
            <?php 
                    if(isset($message)){
                      echo '<div class="callout small-12 primary">'.$message.'</div>';
                    }
                    ?>
            <div class="medium-5 large-3 cell">
              <div class="callout secondary">
              
                <form method='GET' action='test.php'>
                  <div class="grid-x">
                    <div class="small-12 cell">
                    
                      <label><h5>Add the code of the test</h5>
                        <input type="text" name='code' placeholder="add the code of the survey">
                      </label>
                      <button type="submit" class="button">Start questionnaire</button>
                    </div>
                    <?php
                    
                    ?>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </article>
</body>
</html>