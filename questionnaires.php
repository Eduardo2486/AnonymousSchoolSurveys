<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $surveys = $getFromSur->getAllSurveys();
}

if(isset($_POST['title'])){
  $title = $getFromSur->checkinput($_POST['title']);
  $comment = $getFromSur->checkinput($_POST['comment']);
  if(isset($title)){
    $questionnaire_status = $getFromSur->insertNewSurvey($title, $comment);
    if($questionnaire_status){
      header("Location: questionnaires.php" );

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
    <title>Questionnaires</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."izitoast.js" ?>"></script>
    <script src="<?php echo PATH_JS."surveys.js" ?>"></script>
    <style>
        form > input, form > button{
          width: 33%!important;
          float: left;
        }
        .button.large.expanded{
          width: 100%!important;
        }
    </style>
</head>
<body>
  
    <?php require_once "./includes/header.php"; ?>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-12">
          <div class="blog-post">
            <table>
              <caption>Questionnaires</caption>
              <?php if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";?>
              <thead>
                <tr>
                <?php 
                    if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                      echo '<th scope="col">Title</th>
                      <th scope="col">Comment</th>
                      <th scope="col">Actions</th>';
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                  
              <?php
                    if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                      foreach($surveys as $survey){
                        echo "<tr><td data-label='Title'><div class='title' contenteditable='true' data-field='title' data-id='".$survey->id."'>".$survey->title."</div></td>
                      <td data-label='Comment'><div class='comment' contenteditable='true' data-field='comment' data-id='".$survey->id."' style='min-height:10px;'>".$survey->comment."</div></td>
                      <td data-label='Actions'><a href='questionnaire.php?id=".$survey->id."'><img class='edit-record-icon' src='./assets/images/edit-icon.png'/></a><img class='delete-record-icon' data-id='".$survey->id."' src='./assets/images/delete-icon.png'/></td></tr>";
                      }
                    }
                  ?>
              </tbody>
              </table>
              <?php 
                  if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                    ?>
                        <form action='questionnaires.php' method='POST'>
                            <input class='titulo-input' type='text' name='title' placeholder='Title'>
                            <input class='comment-input' type='text' name='comment' placeholder='Comment (Optional)'>
                            <button class='erase-fields button' type="button">Clear fields</button>
                            <input type='submit' class='button large expanded' value='Add questionnaire' name='add-questionnaire'>
                        </form>
                        
                    
                  <?php } ?>
          </div>
        </div>
      </div>
    </article>
</body>
</html>