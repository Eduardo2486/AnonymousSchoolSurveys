<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $teachers = $getFromT->getAllTeachers();
}

if(isset($_POST['add-teacher'])){
  
    $name = $getFromT->checkInput($_POST['name']);
    $fathers_last_name = $getFromT->checkInput($_POST['fathers_last_name']);
    $mothers_last_name = $getFromT->checkInput($_POST['mothers_last_name']);
    $enrollment = $getFromT->checkInput($_POST['enrollment']);
    $email = $getFromT->checkInput($_POST['email']);
    if(isset($name) AND isset($fathers_last_name) AND isset($mothers_last_name) AND isset($enrollment) AND isset($email)){
      $teacher_status = $getFromT->checkDuplicatedData($enrollment, $email);
      if($teacher_status){
        $inserted_user = $getFromT->insertNewTeacher($name, $fathers_last_name, $mothers_last_name, $enrollment,$email, $_SESSION['user_id']);
        echo $inserted_user;
        if($inserted_user){
          header("Location: teachers.php" );
        }else{
          $error = "Try again.";
        }
      }else{
        $error = "Email or enrollment is already in use.";
      }
    }else{
      $error = "Fill all the fields.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."teachers.js" ?>"></script>
    <script src="<?php echo PATH_JS."izitoast.js" ?>"></script>
    <style>
    .delete-teacher{
      cursor:pointer;
    }
    .erase-teacher-data{
      cursor:pointer;
    }
    form > *{
      width: 16.5%!important;
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
            <table>
                <caption>Teachers</caption>
                <?php if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";?>
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Father's last name</th>
                        <th scope="col">Mother's last name</th>
                        <th scope="col">Enrollment</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                      if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
                        foreach($teachers as $teacher){
                          echo "
                          <tr>
                            <td scope='row' data-label='Nombre'><div class='teacher-nombre' data-field='name' data-id='".$teacher->id."' contenteditable='true'>".$teacher->name."</div></td>
                            <td data-label='Apellido Paterno'><div class='teacher-apellido-paterno' data-field='fathers_last_name' data-id='".$teacher->id."' contenteditable='true'>".$teacher->fathers_last_name."</div></td>
                            <td data-label='Apellido Materno'><div class='teacher-apellido-materno' data-field='mothers_last_name' data-id='".$teacher->id."' contenteditable='true'>".$teacher->mothers_last_name."</div></td>
                            <td data-label='Matricula'><div class='teacher-matricula' data-field='enrollment' data-id='".$teacher->id."' contenteditable='true'>".$teacher->enrollment."</div></td>
                            <td data-label='Email'><div class='teacher-email' data-field='email' data-id='".$teacher->id."' contenteditable='true'>".$teacher->email."</div></td>
                            <td data-label='Acciones'><img data-id='".$teacher->id."' class='delete-record' style='width:30px;' src='./assets/images/delete-icon.png'/></td>
                          </tr>
                          ";
                        }
                      }
                    ?>
                </tbody>
                </table>
                <form action='teachers.php' method='POST'>
                  <input type='text' name='name' placeholder='Name'>
                  <input type='text' name='fathers_last_name' placeholder="Father's last name">
                  <input type='text' name='mothers_last_name' placeholder="Mother's last name">
                  <input type='text' name='enrollment' placeholder='Enrollment'>
                  <input type='text' name='email' placeholder='Email'>
                  <button class='erase-fields button' type="button">Clear fields</button>
                  <input type='submit' class='button large expanded' value='Add teacher' name='add-teacher'>
                </form>
          </div>
        </div>
      </div>
    </article>
</body>
</html>