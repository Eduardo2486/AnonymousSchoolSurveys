<?php

include '../init.php';


if(isset($_POST['id']) ){
    $id = $getFromTest->checkInput($_POST['id']);
    
    if(isset($id) ){
        $result = $getFromTest->deleteTest($id);
        echo $result;
    }
}

?>