<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
    $text = $getFromT->checkInput($_POST['text']);
    $id = $getFromT->checkInput($_POST['id']);
    $field = $getFromT->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromT->updateTeacher($id, $field, $text);
        echo $result;
    }
}

?>