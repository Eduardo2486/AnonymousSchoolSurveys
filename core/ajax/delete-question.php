<?php

include '../init.php';


if(isset($_POST['id']) ){
    $id = $getFromQ->checkInput($_POST['id']);
    
    if(isset($_POST['id']) ){
        $result = $getFromQ->deleteQuestion($id);
        echo $result;
    }
}

?>