<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){

    $text = $getFromU->checkInput($_POST['text']);
    $id = $getFromU->checkInput($_POST['id']);
    $field = $getFromU->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromU->updateUser($id, $field, $text);
        echo $result;
    }
}

?>