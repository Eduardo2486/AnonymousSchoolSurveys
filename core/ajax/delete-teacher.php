<?php

include '../init.php';


if(isset($_POST['id']) ){
    $id = $getFromT->checkInput($_POST['id']);
    
    if(isset($_POST['id']) ){
        $result = $getFromT->deleteTeacher($id);
        echo $result;
    }
}

?>