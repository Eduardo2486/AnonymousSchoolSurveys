<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $subjects = $getFromS->getAllSubjects();
}

if(isset($_POST['add-subject'])){
  $subject = $getFromS->checkInput($_POST['subject']);
  $career = $getFromS->checkInput($_POST['career']);
  $grade = $getFromS->checkInput($_POST['grade']);
  $group = $getFromS->checkInput($_POST['group']);
  
  if(isset($subject) AND isset($career) AND isset($grade) AND isset($group)){
      $inserted_user = $getFromS->insertNewSubject($subject,$career,$grade, $group);
      if($inserted_user){
        header("Location: subjects.php" );

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
    <title>Subjects</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."subjects.js" ?>"></script>
    <script src="<?php echo PATH_JS."izitoast.js" ?>"></script>
    <style>
    .delete-partial{
      cursor:pointer;
    }
    .erase-data{
      cursor:pointer;
    }
      form > *{
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
                <caption>Subjects</caption>
                <?php if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";?>
                
                <thead>
                  <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Career</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Group</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <?php
                      if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                        foreach($subjects as $subject){
                          echo "
                          <tr>
                            <td scope='row' data-label='Materia'><div class='materia' data-field='subject' data-id='".$subject->id."' contenteditable='true'>".$subject->subject."</div></td>
                            <td data-label='Carrera'>
                                <div class='carrera' data-field='career' data-id='".$subject->id."' contenteditable='true'>".$subject->career."</div></td>
                            
                            </td>
                            <td data-label='Grade'>
                              <select name='grade' class='grade' data-field='grade' data-id='".$subject->id."'>
                                <option value='1' ". ($subject->grade == 1 ? 'selected="selected"' : ' ') ." >1</option>
                                <option value='2' ". ($subject->grade == 2 ? 'selected="selected"' : ' ') ." >2</option>
                                <option value='3' ". ($subject->grade == 3 ? 'selected="selected"' : ' ') ." >3</option>
                                <option value='4' ". ($subject->grade == 4 ? 'selected="selected"' : ' ') ." >4</option>
                                <option value='5' ". ($subject->grade == 5 ? 'selected="selected"' : ' ') ." >5</option>
                                <option value='6' ". ($subject->grade == 6 ? 'selected="selected"' : ' ') ." >6</option>
                                <option value='7' ". ($subject->grade == 7 ? 'selected="selected"' : ' ') ." >7</option>
                                <option value='8' ". ($subject->grade == 8 ? 'selected="selected"' : ' ') ." >8</option>
                                <option value='9' ". ($subject->grade == 9 ? 'selected="selected"' : ' ') ." >9</option>
                                <option value='10' ". ($subject->grade == 10 ? 'selected="selected"' : ' ') ." >10</option>
                                <option value='11' ". ($subject->grade == 11 ? 'selected="selected"' : ' ') ." >11</option>
                                <option value='12' ". ($subject->grade == 12 ? 'selected="selected"' : ' ') ." >12</option>
                                <option value='13' ". ($subject->grade == 13 ? 'selected="selected"' : ' ') ." >13</option>
                                <option value='14' ". ($subject->grade == 14 ? 'selected="selected"' : ' ') ." >14</option>
                                <option value='15' ". ($subject->grade == 15 ? 'selected="selected"' : ' ') ." >15</option>
                                <option value='16' ". ($subject->grade == 16 ? 'selected="selected"' : ' ') ." >16</option>
                                <option value='17' ". ($subject->grade == 17 ? 'selected="selected"' : ' ') ." >17</option>
                                <option value='18' ". ($subject->grade == 18 ? 'selected="selected"' : ' ') ." >18</option>
                              </select>
                            </td>
                            <td data-label='Group'>
                            <select name='grade' class='group' data-field='group' data-id='".$subject->id."'>
                                <option value='1' ". ($subject->groupp == 1 ? 'selected="selected"' : ' ') ." >1</option>
                                <option value='2' ". ($subject->groupp == 2 ? 'selected="selected"' : ' ') ." >2</option>
                                <option value='3' ". ($subject->groupp == 3 ? 'selected="selected"' : ' ') ." >3</option>
                                <option value='4' ". ($subject->groupp == 4 ? 'selected="selected"' : ' ') ." >4</option>
                              </select>
                            </td>
                            <td data-label='Acciones'><img data-id='".$subject->id."' class='delete-record' style='width:30px;' src='./assets/images/delete-icon.png'/></td>
                          </tr>
                          ";
                        }
                       
                      }
                      
                    ?>
                  </tr>
                </tbody>

                </table>
                        <form action='subjects.php' method='POST'>
                          <input class='subject' type='text' name='subject' placeholder='Subject'>
                          <input class='career' type='text' name='career' placeholder='Career'>
                          <select name='grade' class='grade-insert'>
                              <option value='1'>1</option>
                              <option value='2'>2</option>
                              <option value='3'>3</option>
                              <option value='4'>4</option>
                              <option value='5'>5</option>
                              <option value='6'>6</option>
                              <option value='7'>7</option>
                              <option value='8'>8</option>
                              <option value='9'>9</option>
                              <option value='10'>10</option>
                              <option value='11'>11</option>
                              <option value='12'>12</option>
                              <option value='13'>13</option>
                              <option value='14'>14</option>
                              <option value='15'>15</option>
                              <option value='16'>16</option>
                              <option value='17'>17</option>
                              <option value='18'>18</option>
                          </select>
                            <select name='group' class='group-insert' >
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                            </select>
                            <button class='erase-fields button' type="button">Clear fields</button>
                          <input type='submit' class='button large expanded' value='Add subject' name='add-subject'>
                        </form>
                    
          </div>
        </div>
      </div>
    </article>
</body>
</html>