<?php
require_once 'core/init.php';
include_once("./core/settings.php");

if(!isset($_SESSION['user_id'])){
	header('Location: home.php');
}else{
  $users = $getFromU->getAllUsers();
}

if(isset($_POST['add-user'])){
    $name = $getFromU->checkInput($_POST['name']);
    $fathers_last_name = $getFromU->checkInput($_POST['fathers-last-name']);
    $mothers_last_name = $getFromU->checkInput($_POST['mothers-last-name']);
    $enrollment = $getFromU->checkInput($_POST['enrollment']);
    $email = $getFromU->checkInput($_POST['email']);
    $rol = $getFromU->checkInput($_POST['rol']);

    if(isset($name) AND isset($fathers_last_name) AND isset($mothers_last_name) AND isset($enrollment) AND isset($email) AND isset($rol)){
      $teacher_status = $getFromU->checkDuplicatedData($enrollment, $email);
      if($teacher_status){
        
        $inserted_user = $getFromU->insertNewUser($name, $fathers_last_name, $mothers_last_name, $enrollment,$email, $rol);

        if($inserted_user){
          header("Location: users.php" );

        }else{
          $error = "Try again.";
        }
      }else{
        $error = "That email or enrollment is already in use.";
      }
    }else{
      $error = "Fill all fields.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="<?php echo PATH_CSS."reset.css"; ?>">
    
    <link rel="stylesheet" href="<?php echo PATH_CSS."app.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."izitoast.css"; ?>">
    <link rel="stylesheet" href="<?php echo PATH_CSS."table.css"; ?>">
    <script src="<?php echo PATH_JS."jquery.js" ?>"></script>
    <script src="<?php echo PATH_JS."users.js" ?>"></script>
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
        <div class="cell medium-8">
          <div class="blog-post">
            <table>
                <caption>Users</caption>
                <?php if(isset($error)) echo "<span style='text-align:center;display:block;color:red;'>".$error."</span>";?>
                
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Father's last name</th>
                        <th scope="col">Mother's last name</th>
                        <th scope="col">Enrollment</th>
                        <th scope="col">Email</th>
                        
                    <?php
                        if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
                          echo '
                          <th scope="col">Rol</th>
                          <th scope="col">Acciones</th>
                          ';
                        }
                        
                        ?>

                    </tr>
                </thead>
                <tbody>
                    <?php
                      if($_SESSION['rol'] == 'superadmin'){
                        foreach($users as $user){
                            if($_SESSION['user_id'] == $user->id){
                              echo "
                            <tr style='background-color: #9fe8ff;'>
                              <td data-label='Name'>".$user->name."</td>
                              <td data-label='Apellido Paterno'>".$user->fathers_last_name."</td>
                              <td data-label='Apellido Materno'>".$user->mothers_last_name."</td>
                              <td data-label='Matricula'>".$user->enrollment."</td>
                              <td data-label='Email'>".$user->email."</td>
                              <td data-label='Rol'>".$user->rol."</td>
                              <td data-label='Acciones'></td>
                            </tr>
                            ";
                            }else{
                              echo "    
                              <tr>
                              <td scope='row' data-label='Name'><div class='name' data-field='name' data-id='".$user->id."' contenteditable='true'>".$user->name."</div></td>
                              <td data-label='Apellido Paterno'><div class='father-last-name' data-field='fathers_last_name' data-id='".$user->id."' contenteditable='true'>".$user->fathers_last_name."</div></td>
                              <td data-label='Apellido Materno'><div class='mother-last-name' data-field='mothers_last_name' data-id='".$user->id."' contenteditable='true'>".$user->mothers_last_name."</div></td>
                              <td data-label='Matricula'><div class='enrollment' data-field='enrollment' data-id='".$user->id."' contenteditable='true'>".$user->enrollment."</div></td>
                              <td data-label='Email'><div class='email' data-field='email' data-id='".$user->id."' contenteditable='true'>".$user->email."</div></td>
                              <td data-label='Rol'>
                              <select class='user-rol' name='rol' data-id='".$user->id."' data-field='rol'>
                                ".($user->rol == 'admin' ? '<option value="admin" selected>admin</option><option value="editor">editor</option>' : '<option value="editor" selected>editor</option><option value="admin">admin</option>')."
                              </select>
                              </td>
                              <td data-label='Acciones'><img data-id='".$user->id."' class='delete-record' src='./assets/images/delete-icon.png'/></td>
                              </tr>";
                            }
                        }
                      }else if($_SESSION['rol'] == 'admin'){
                        foreach($users as $user){
                            if($_SESSION['user_id'] == $user->id) {
                              echo "
                            <tr style='background-color: #9fe8ff;'>
                              <td scope='row' data-label='Name'>".$user->name."</td>
                              <td data-label='Apellido Paterno'>".$user->fathers_last_name."</td>
                              <td data-label='Apellido Materno'>".$user->mothers_last_name."</td>
                              <td data-label='Matricula'>".$user->enrollment."</td>
                              <td data-label='Email'>".$user->email."</td>
                              <td data-label='Rol'>".$user->rol."</td>
                              <td data-label='Acciones'></td>
                            </tr>
                            ";
                            }else if( $user->rol == 'editor'){
                              echo "    
                              <tr>
                              <td scope='row' data-label='Name'><div class='name' data-field='name' data-id='".$user->id."' contenteditable='true'>".$user->name."</div></td>
                              <td data-label='Apellido Paterno'><div class='father-last-name' data-field='fathers_last_name' data-id='".$user->id."' contenteditable='true'>".$user->fathers_last_name."</div></td>
                              <td data-label='Apellido Materno'><div class='mother-last-name' data-field='mothers_last_name' data-id='".$user->id."' contenteditable='true'>".$user->mothers_last_name."</div></td>
                              <td data-label='Matricula'><div class='enrollment' data-field='enrollment' data-id='".$user->id."' contenteditable='true'>".$user->enrollment."</div></td>
                              <td data-label='Email'><div class='email' data-field='email' data-id='".$user->id."' contenteditable='true'>".$user->email."</div></td>
                              <td data-label='Rol'>
                              <select class='user-rol' name='rol' data-id='".$user->id."' data-field='rol'>
                                ".($user->rol == 'admin' ? '<option value="admin" selected>admin</option><option value="editor">editor</option>' : '<option value="editor" selected>editor</option><option value="admin">admin</option>')."
                              </select>
                              </td>
                              <td data-label='Acciones'><img data-id='".$user->id."' class='delete-record' src='./assets/images/delete-icon.png'/></td>
                              </tr>";
                            }
                        }
                      }else{
                        echo " <tr>
                        <td scope='row' data-label='Nombre'>You cannot see this page</td>
                        </tr>";
                      }
                      
                    ?>
                </tbody>
                </table>
                <?php 
                  if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
                  ?>
                    <form action='users.php' method='POST'>
                      <input class='name-input' type='text' name='name' placeholder='Name'>
                      <input class='flastname-input' type='text' name='fathers-last-name' placeholder="Father's last name">
                      <input class='slastname-input' type='text' name='mothers-last-name' placeholder="Mother's last name">
                      <input class='enrollment-input' type='text' name='enrollment' placeholder='Enrollment'>
                      <input class='email-input' type='text' name='email' placeholder='Email'>
                      <select name='rol'>
                        <option value='editor'>Editor</option>
                        <option value='admin'>Admin</option>
                      </select>
                        
                      <button class='erase-fields button' type="button">Clear fields</button>
                      <input type='submit' class='button large expanded' value='Add user' name='add-user'>
                    </form>
                  <?php } ?>
          </div>
        </div>
      </div>
    </article>
</body>
</html>