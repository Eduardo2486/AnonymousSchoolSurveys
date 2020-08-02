<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $id = $getFromSur->checkInput($_GET['id']);
  $survey = $getFromSur->getSurvey($id);
  $questions = $getFromQ->getQuestion($id);
}

if(isset($_POST['add-question'])){
  $id = $getFromSur->checkInput($_GET['id']);
  $questions = $getFromQ->checkInput($_POST['title']);
  $subject = $getFromQ->checkInput($_POST['comment']);
  if(isset($questions) AND isset($subject)){
    $status = $getFromQ->insertQuestion($id,$questions, $subject);
    if($status){
      header("Location: questionnaire.php?id=".$id );

    }else{
      $error = "Intenta otra vez.";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."question.js" ?>"></script>
    
    <script src="<?php echo PATH_JS."izitoast.js" ?>"></script>
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
        <div class="cell medium-8">
          <div class="blog-post">
            <?php
              echo "<h1 style='text-align:center;'>".$survey->title."</h1>";
              echo "<h6 style='text-align:center;'>".$survey->comment."</h6>";

              if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                echo ' <table>
                <thead>
                <tr><th scope="col">Question</th>
                <th scope="col">Subject</th>
                <th scope="col">Actions</th></tr></thead><tbody>';
              }
              foreach($questions as $question){
                echo "<tr>
                <td><div class='question' contenteditable='true' data-field='question' data-id='".$question->id."'>".$question->question."</div></td>
                <td><div class='subject' contenteditable='true' data-field='subject' data-id='".$question->id."'>".$question->subject."</div></td>
                <td><div data-field='Actions'><img class='delete-record' style='top: 5px;' data-id='".$question->id."' src='./assets/images/delete-icon.png'/></div></td>
                </tr>
                ";
              }
              echo "</tbody></table>";
              ?>
                  <form action='questionnaire.php?id=<?php echo $id; ?>' method='POST'>
                    <input class='title-input' type='text' name='title' placeholder='Question'>
                    <input class='comment-input' type='text' name='comment' placeholder='Subject'>
                    <button class='erase-fields button' type="button">Clear fields</button>
                    <input type='submit' class='button large expanded' value='Add question' name='add-question'>
                  </form>
          </div>
        </div>
      </div>
    </article>
</body>
</html>