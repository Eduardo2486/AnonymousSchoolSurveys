<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
    $text = $getFromQ->checkInput($_POST['text']);
    $id = $getFromQ->checkInput($_POST['id']);
    $field = $getFromQ->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromQ->updateQuestion($id, $field, $text);
        echo $result;
    }
}

?>