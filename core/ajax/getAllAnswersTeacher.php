<?php

include '../init.php';


if(isset($_POST['id']) AND isset($_POST['surveyid']) ){
    $id = $getFromC->checkInput($_POST['id']);
    $idSurvey = $getFromC->checkInput($_POST['surveyid']);
    if(isset($id) AND isset($idSurvey)){
        $result = $getFromC->getTeacherResults($id, $idSurvey);
        echo  json_encode($result);
    }
}

?>