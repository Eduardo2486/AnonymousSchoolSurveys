<?php
class Answer{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    
    public function insertAnswers($test_id, $idPreguntas, $valuePreguntas, $numeroprueba){
        $query= "INSERT INTO answers (test_id, question_id, answer,test_number) VALUES ";
        $elements = ""; 
        for($i = 0 ; $i < sizeof($idPreguntas) ; $i++){
          $elements .= '('.$test_id.','.$idPreguntas[$i].','.$valuePreguntas[$i].','.$numeroprueba.')';
          if($i < sizeof($idPreguntas)-1){
            $elements.=',';
          }
        }
        $query.=$elements;
        $stmt= $this->pdo->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0){
          return true;
        }else{
          return false;
        }
    }

   
}
?>
