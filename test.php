<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(isset($_GET['code'])){
    $code = $getFromTest->checkInput($_GET['code']);
    if(isset($code)){
        $test = $getFromTest->getTest($code);
        $surveyName = $getFromTest->getNameSurvey($test->survey_id);
        $teacher = $getFromTest->getNameTeacher($test->teacher_id);
        $subject = $getFromTest->getNameSubjects($test->subject_id);
        $partial = $getFromTest->getNamePartial($test->partial_id);
        $questions = $getFromTest->getQuestions($test->survey_id);
    }
}

if(isset($_POST['sendtest'])){
  $idQuestions=array();
  $valueQuestions=array();
  foreach ($_POST as $key => $value) {
    if(is_numeric($key)){
      $idQuestions[] = $key;
      $valueQuestions[] = $value;
    }
  }
  
  if(sizeof($valueQuestions) == sizeof($idQuestions)){
    if( sizeof($questions) == sizeof($valueQuestions) ){
      $test_id=$getFromTest->checkInput($_POST['test']);
      $numberofsurvey = $getFromTest->getNumberSurvey($test_id);
      if($numberofsurvey == 0){
        $numbertest=1;
      }else{
        $numbertest =( $numberofsurvey / sizeof($idQuestions) ) +1  ;
      }
      $tests_availables = $getFromTest->availableTests($test_id);
      if($numbertest<=$tests_availables ){
        $status = $getFromA->insertAnswers($test_id, $idQuestions, $valueQuestions, $numbertest);
        if($status == true){
          header('Location: index.php?saved=succesfull');
        }else{
          $error = "It's not possible to save your test due to an internal problem.".$status;
        }
      }else{
        $error = "This teacher in this subject and course cannot have more tests.";
      }
    }else{
      $error = "Make sure to answer all the questions.";
    }
  }else{
    $error = "Make sure to answer all the questions.";
  }

  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <style>
    legend{
      font-weight:bold;
    }
    </style>
</head>
<body>
    <article class="grid-container">
      <div class="grid-x align-center">
        <div class="cell medium-8">
          <div class="blog-post">
          <h1><?php echo $surveyName->title; ?></h1>
          <h2><?php echo $teacher->name." ".$teacher->fathers_last_name." ".$teacher->mothers_last_name; ?></h2>
          <h3><?php echo $subject->career.", ".$subject->subject.", semester: ".$subject->grade.", group: ".$subject->groupp; ?></h3>
          <h4><?php echo "Partial ".$partial->abbreviation; ?></h4>
          <br>
          
          <?php if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";?>

          <form action='test.php?code=<?php echo $code; ?>' method='POST'> 
            <?php

              for($i = 0 ; $i < sizeof($questions) ; $i++ ){
                  if(isset($idQuestions) AND sizeof($idQuestions) > 0){
                   $jcounter = 0;
                    for($j = 0; $j < sizeof($idQuestions) ; $j++){
                      if($questions[$i]->id == $idQuestions[$j]){
                        
                        echo '
                        <fieldset class="large-12 cell">
                          <legend>'.$questions[$i]->question.'</legend>
                          <input type="radio" name="'.$questions[$i]->id.'" value="1" id="question-'.$questions[$i]->id.'-1" '. ($valueQuestions[$j] == 1 ? 'checked="checked"' : ' ') .'><label for="question-'.$questions[$i]->id.'-1">Very bad</label>
                          <input type="radio" name="'.$questions[$i]->id.'" value="2" id="question-'.$questions[$i]->id.'-2" '. ($valueQuestions[$j] == 2 ? 'checked="checked"' : ' ') .'><label for="question-'.$questions[$i]->id.'-2">Bad</label>
                          <input type="radio" name="'.$questions[$i]->id.'" value="3" id="question-'.$questions[$i]->id.'-3" '. ($valueQuestions[$j] == 3 ? 'checked="checked"' : ' ') .'><label for="question-'.$questions[$i]->id.'-3">Regular</label>
                          <input type="radio" name="'.$questions[$i]->id.'" value="4" id="question-'.$questions[$i]->id.'-4" '. ($valueQuestions[$j] == 4 ? 'checked="checked"' : ' ') .'><label for="question-'.$questions[$i]->id.'-4">Good</label>
                          <input type="radio" name="'.$questions[$i]->id.'" value="5" id="question-'.$questions[$i]->id.'-5" '. ($valueQuestions[$j] == 5 ? 'checked="checked"' : ' ') .'><label for="question-'.$questions[$i]->id.'-5">Very good</label>
                        </fieldset> 
                        <hr> 
                        ';
                        $jcounter++;
                      }
                    }
                    if($jcounter == 0){
                      
                      echo '<fieldset class="large-12 cell">
                        <legend>'.$questions[$i]->question.'</legend>
                        <input type="radio" name="'.$questions[$i]->id.'" value="1" id="question-'.$questions[$i]->id.'-1"><label for="question-'.$questions[$i]->id.'-1">Very bad</label>
                        <input type="radio" name="'.$questions[$i]->id.'" value="2" id="question-'.$questions[$i]->id.'-2"><label for="question-'.$questions[$i]->id.'-2">Bad</label>
                        <input type="radio" name="'.$questions[$i]->id.'" value="3" id="question-'.$questions[$i]->id.'-3"><label for="question-'.$questions[$i]->id.'-3">Regular</label>
                        <input type="radio" name="'.$questions[$i]->id.'" value="4" id="question-'.$questions[$i]->id.'-4"><label for="question-'.$questions[$i]->id.'-4">Good</label>
                        <input type="radio" name="'.$questions[$i]->id.'" value="5" id="question-'.$questions[$i]->id.'-5"><label for="question-'.$questions[$i]->id.'-5">Very good</label>
                      </fieldset> 
                      <hr> ';
                    }else{
                      $jcounter--;
                    }
                  }else{
                    echo '
                    <fieldset class="large-12 cell">
                      <legend>'.$questions[$i]->question.'</legend>
                      <input type="radio" name="'.$questions[$i]->id.'" value="1" id="question-'.$questions[$i]->id.'-1"><label for="question-'.$questions[$i]->id.'-1">Very bad</label>
                      <input type="radio" name="'.$questions[$i]->id.'" value="2" id="question-'.$questions[$i]->id.'-2"><label for="question-'.$questions[$i]->id.'-2">Bad</label>
                      <input type="radio" name="'.$questions[$i]->id.'" value="3" id="question-'.$questions[$i]->id.'-3"><label for="question-'.$questions[$i]->id.'-3">Regular</label>
                      <input type="radio" name="'.$questions[$i]->id.'" value="4" id="question-'.$questions[$i]->id.'-4"><label for="question-'.$questions[$i]->id.'-4">Good</label>
                      <input type="radio" name="'.$questions[$i]->id.'" value="5" id="question-'.$questions[$i]->id.'-5"><label for="question-'.$questions[$i]->id.'-5">Very good</label>
                    </fieldset> 
                    <hr> ';
                    
                  }
              }       
              echo '<input type="hidden" name="test" value="'.$test->id.'" >';
            ?>
            <input type="submit" name='sendtest' class="success button" value='Send'>
          </form>
          </div> 
        </div>
      </div>
    </article>
</body>
</html>