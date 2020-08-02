<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
    $text = $getFromS->checkInput($_POST['text']);
    $id = $getFromS->checkInput($_POST['id']);
    $field = $getFromS->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromS->updateSubject($id, $field, $text);
        echo $result;
    }
}

?>