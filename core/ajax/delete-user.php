<?php

include '../init.php';


if(isset($_POST['id']) ){
    $id = $getFromU->checkInput($_POST['id']);
    if(isset($_POST['id']) ){
        $result = $getFromU->deleteUser($id);
        echo $result;
    }
}

?>