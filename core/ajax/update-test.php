<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){

    $text = $getFromTest->checkInput($_POST['text']);
    $id = $getFromTest->checkInput($_POST['id']);
    $field = $getFromTest->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromTest->updateTest($id, $field, $text);
        echo $result;
    }
}

?>