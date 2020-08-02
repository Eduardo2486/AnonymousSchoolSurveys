<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
    $text = $getFromSur->checkInput($_POST['text']);
    $id = $getFromSur->checkInput($_POST['id']);
    $field = $getFromSur->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromSur->updateSurvey($id, $field, $text);
        
        echo $result;
    }
}

?>