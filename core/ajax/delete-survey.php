<?php

include '../init.php';


if(isset($_POST['id']) ){
    $id = $getFromSur->checkInput($_POST['id']);
    
    if(isset($_POST['id']) ){
        $result = $getFromSur->deleteSurvey($id);
        echo $result;
    }
}

?>