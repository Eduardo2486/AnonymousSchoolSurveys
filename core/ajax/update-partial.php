<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
    $text = $getFromP->checkInput($_POST['text']);
    $id = $getFromP->checkInput($_POST['id']);
    $field = $getFromP->checkInput($_POST['field']);
    
    if(isset($_POST['id']) AND isset($_POST['text']) AND isset($_POST['field']) ){
        $result = $getFromP->updatePartial($id, $field, $text);
        echo $result;
    }
}

?>