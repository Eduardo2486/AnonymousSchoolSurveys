<?php

include '../init.php';


if(isset($_POST['id'])){
    $id = $getFromC->checkInput($_POST['id']);
    if(isset($id)){
        $result = $getFromC->getTeacherAllResults($id);
        echo json_encode($result);
    }
}

?>