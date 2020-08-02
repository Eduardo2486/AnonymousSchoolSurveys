<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $all = $getFromTest->getAllSurveys();
}

if(isset($_POST['apply-questionnaire'])){
  $questionnaires = $getFromTest->checkInput($_POST['questionnaire']);
  $teacher = $getFromTest->checkInput($_POST['teacher']);
  $subject = $getFromTest->checkInput($_POST['subject']);
  $partial = $getFromTest->checkInput($_POST['partial']);
  $number_questionnaires = $getFromTest->checkInput($_POST['number_questionnaires']);
  $code = $getFromTest->checkInput($_POST['code']);

  if(isset($questionnaires) AND isset($teacher) AND isset($subject) AND isset($partial) AND isset($number_questionnaires) AND isset($code)){
    $status = $getFromTest->insertTest($questionnaires, $teacher, $subject, $partial, $number_questionnaires, $code);
    if($status == 1){
      header("Location: tests.php");
    }else{
      $error = "That code is already in use, use another one.";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."test.js" ?>"></script>
    
    <script src="<?php echo PATH_JS."izitoast.js" ?>"></script>
    <style>
    form > *{
      width: 14.2%!important;
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
              <?php
              
                $tests = $all[0];
                $surveys = $all[1];
                $teachers = $all[2];
                $subjects = $all[3];
                $partials = $all[4];

                if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";

              ?>
              
              <thead>
                <tr>
                <?php 
                    if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
                      echo '
                      <th scope="col">Questionnaire</th>
                      <th scope="col">Teacher</th>
                      <th scope="col">Subject</th>
                      <th scope="col">Partial</th>
                      <th scope="col">Total questionnaires</th>
                      <th scope="col">Code</th>
                      <th scope="col">Actions</th>';
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                  <?php
                    if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
                      for($i = 0 ; $i < sizeof($tests) ; $i++){ 
                        echo "<tr>";
                        $jCounter = 0;
                        for($j = 0 ; $j < sizeof($surveys) ; $j++){ 
                          if($tests[$i]["survey_id"] == $surveys[$j]["id"]){
                            echo "<td scope='row' data-label='Questionnaire' data-field='' data-id='".$surveys[$j]["id"]."'>".$surveys[$j]["title"]."</td>";
                            $jCounter = $j;
                          }
                        }
                        for($j = 0 ; $j < sizeof($teachers) ; $j++){ 
                          if($tests[$i]["teacher_id"] == $teachers[$j]["id"]){
                            echo "<td scope='row' data-label='Teacher' data-field='' data-id='".$teachers[$j]["id"]."'>".$teachers[$j]["name"]." ".$teachers[$j]["fathers_last_name"]." ".$teachers[$j]["mothers_last_name"]." - ".$teachers[$j]["enrollment"]."</td>";
                          }
                        }
                        for($j = 0 ; $j < sizeof($subjects) ; $j++){ 
                            
                          if($tests[$i]["subject_id"] == $subjects[$j]["id"]){
                            echo "<td data-label='Subject' data-field='' data-id='".$subjects[$j]["id"]."''>".$subjects[$j]["subject"]." - ".$subjects[$j]["career"]. " - ".$subjects[$j]["grade"]."° ".$subjects[$j]["groupp"]. "</td>";
                          }
                        }

                        for($j = 0 ; $j < sizeof($partials) ; $j++){ 
                          if($tests[$i]["partial_id"] == $partials[$j]["id"]){
                            echo "<td data-label='Total questionnaires' data-field='' data-id='".$partials[$j]["id"]."'>".$partials[$j]["abbreviation"]." (" .$partials[$j]["date_start"]. "/" . $partials[$j]["date_end"] . ") <i>".  $partials[$j]["comment"]."</i></td>";
                          }
                        }
                        echo "<td> <input class='questionnaires_total' data-field='questionnaires_total' type='text' data-id='".$tests[$i]["id"]."' value=".$tests[$i]["questionnaires_total"]." /> (". (intval($tests[$i]["questionnaires_total"]) - ($getFromTest->getNumberSurvey($tests[$i]['id']) / ($getFromTest->getNumberQuestions($surveys[$jCounter]['id']) > 0 ? $getFromTest->getNumberQuestions($surveys[$jCounter]['id']) : 1 ))) ." available) </td>";
                        
                        echo "<td> <input class='code' type='text' data-field='code' data-id='".$tests[$i]["id"]."' value=".$tests[$i]["code"]." /></td>";

                        echo "<td><img class='delete-record' data-id='".$tests[$i]["id"]."' src='./assets/images/delete-icon.png'/></td>";
                        echo "</tr>";
                      }
                    }
                    ?>
              </tbody>
            </table>
                        
            <form method='POST' action='tests.php'>
              <select name='questionnaire'>";
                <?php for($j = 0 ; $j < sizeof($surveys) ; $j++){ 
                  echo "
                    <option value='".$surveys[$j]["id"]."'>".$surveys[$j]["title"]."</option>
                  ";
                } ?>
              </select>
              <select name='teacher'>
                <?php for($j = 0 ; $j < sizeof($teachers) ; $j++){ 
                  echo "<option value=".$teachers[$j]["id"].">".$teachers[$j]["name"]." ".$teachers[$j]["fathers_last_name"]." ".$teachers[$j]["mothers_last_name"]." - ".$teachers[$j]["enrollment"]."</option>";
                  }?>
              </select>
              <select name='subject'>
                <?php for($j = 0 ; $j < sizeof($subjects) ; $j++){ 
                  echo "<option value='".$subjects[$j]["id"]."'>".$subjects[$j]["subject"]." - ".$subjects[$j]["career"]. " - ".$subjects[$j]["grade"]."° ".$subjects[$j]["group"]. "</option>";
                }?>
              </select>
              <select name='partial'>";
                <?php for($j = 0 ; $j < sizeof($partials) ; $j++){ 
                  echo "<option value='".$partials[$j]["id"]."'>".$partials[$j]["abbreviation"]." (" .$partials[$j]["date_start"]. "/" . $partials[$j]["date_end"] . ") <i>".  $partials[$j]["comment"]."</i></option>";
                  }
                ?>
              </select>
              <input class="questionnaire-input" type='text' name='number_questionnaires' placeholder='Number of questionnaires'/>
              <input class="code-input" type='text' name='code' placeholder='Code'/>
              <button class='erase-fields button' type="button">Clear fields</button>
              <input type='submit' class='button large expanded' value='Apply questionnaire' name='apply-questionnaire'>
            </form>
          </div>
        </div>
      </div>
    </article>
</body>
</html>