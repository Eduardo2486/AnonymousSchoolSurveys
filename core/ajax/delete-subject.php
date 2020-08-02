<?php

include '../init.php';


if(isset($_POST['id']) ){
    $id = $getFromS->checkInput($_POST['id']);
    
    if(isset($_POST['id']) ){
        $result = $getFromS->deleteSubject($id);
        echo $result;
    }
}

?>