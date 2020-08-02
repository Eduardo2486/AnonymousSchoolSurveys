<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $partials = $getFromP->getAllPartials();
}

if(isset($_POST['add-partial'])){
  $abbreviation = $getFromP->checkInput($_POST['shorthand']);
  $start_date = $getFromP->checkInput($_POST['start-date']);
  $finish_date = $getFromP->checkInput($_POST['finish-date']);
  $comment = $getFromP->checkInput($_POST['comment']);
  
  if(isset($abbreviation) AND isset($start_date) AND isset($finish_date)){
  
      $inserted_user = $getFromP->insertNewPartial($abbreviation,$start_date,$finish_date,$comment);
      if($inserted_user){
        header("Location: partials.php" );

      }else{
        $error = "Try again.";
      }
    
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partials</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."partials.js" ?>"></script>
    <script src="<?php echo PATH_JS."izitoast.js" ?>"></script>
    <style>
    .delete-partial{
      cursor:pointer;
    }
    form > input, form > button{
      width: 20%!important;
      float: left;
    }
    .button.large.expanded{
      width: 100%!important;
    }
    </style>
</head>
<body>
    <?php require_once './includes/header.php'; ?>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-8">
          <div class="blog-post">
            <table>
                <caption>Parciales</caption>
                <?php if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";?>
                
                <thead>
                  <tr>
                    <th scope="col">Abbreviation</th>
                    <th scope="col">Start date</th>
                    <th scope="col">End date</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Actions</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <?php
                      if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                        foreach($partials as $partial){
                          echo "
                          <tr>
                            <td scope='row' data-label='Abbreviation'><div class='abbreviation' data-field='abbreviation' data-id='".$partial->id."' contenteditable='true'>".$partial->abbreviation."</div></td>
                            <td data-label='Start date'>
                              <input class='sdate' style='position: absolute;top: 0;left: 0;' type='date' data-field='sdate' data-id='".$partial->id."' value=".$partial->date_start.">
                            </td>
                            <td data-label='End date'>
                              <input class='fdate' style='position: absolute;top: 0;left: 0;' type='date' data-field='fdate' data-id='".$partial->id."' value=".$partial->date_end.">
                            </td>
                            <td data-label='Comment'><div class='comments' data-field='comment' data-id='".$partial->id."' contenteditable='true'>".$partial->comment."</div></td>
                            <td data-label='Actions'><img data-id='".$partial->id."' class='delete-record' src='./assets/images/delete-icon.png'/></td>
                          </tr>
                          ";
                        }
                      }
                      
                    ?>
                  </tr>
                </tbody>
              </table>
              <?php 
                if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                  ?>
                    
                      <form action='<?php echo "partials.php"; ?>' method='POST' style='position:relative;'>
                            <input class='shorthand-input' type='text' name='shorthand' placeholder='Abbreviation'>
                            <input class='start-date-input' type='date' name='start-date' placeholder='Start date'>
                            <input class='finish-date-input' type='date' name='finish-date' placeholder='End date'>
                            <input class='comment-input' type='text' name='comment' placeholder='Comment'>
                            <button class='erase-fields button' type="button">Clear fields</button>
                            <input type='submit' class='button large expanded' value='Add partial' name='add-partial'>
                      </form>

                  <?php
                }?>
            
          </div>
        </div>
      </div>
    </article>
</body>
</html>