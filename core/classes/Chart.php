<?php
class Chart{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function checkInput($var){
		$var = htmlspecialchars($var);
		$var = trim($var);
		$var = stripcslashes($var);
		return $var;
    }

    public function getTeacherResults($idTest, $idSurvey){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){

            $stmt= $this->pdo->prepare("SELECT * FROM tests WHERE id = :idTest; SELECT * FROM answers WHERE test_id = :idTest; SELECT * FROM questions WHERE survey_id = :survey_id");
            // // 
            // $stmt->execute();
            // $all[] = $stmt->fetchAll(PDO::FETCH_OBJ);
            $all = array();   
            $stmt->bindParam(":idTest",$idTest,PDO::PARAM_INT);
            $stmt->bindParam(":survey_id",$idSurvey,PDO::PARAM_INT);
            $stmt->execute();
            do {
            
                array_push($all,$stmt->fetchAll(PDO::FETCH_ASSOC));
            // var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
            } while ($stmt->nextRowset());

            if(isset($all)){
                return $all;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getTeacherAllResults($id){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
         
            $stmt= $this->pdo->prepare("SELECT * FROM tests WHERE teacher_id = :idTest");
            $stmt->bindParam(":idTest",$id,PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $surveysIds = array();
            $question = array();
            $answer = array();
            for($i = 0; $i < sizeof($stmt) ; $i++){
                if(!in_array($stmt[$i]["survey_id"], $surveysIds)){
                    array_push($surveysIds, $stmt[$i]["survey_id"]);
                }
            }
            $questions= $this->pdo->prepare("SELECT * FROM questions WHERE survey_id = :idsurvey");
            for($i = 0; $i < sizeof($surveysIds) ; $i++){
                $questions->bindParam(":idsurvey",$surveysIds[$i],PDO::PARAM_INT);
                $questions->execute();
                array_push($question , $questions->fetchAll(PDO::FETCH_ASSOC));
            }
            $answers = $this->pdo->prepare("SELECT * FROM answers WHERE test_id = :idQuestion");
            for($i = 0; $i < sizeof($stmt) ; $i++){
                $answers->bindParam(":idQuestion",$stmt[$i]["id"],PDO::PARAM_INT);
                $answers->execute();
                array_push($answer , $answers->fetchAll(PDO::FETCH_ASSOC));
            }
            $result = array();
            $result[0] = $surveysIds;
            $result[1] = $question;
            $result[2] = $answer;
            return $result;
        }else{
            return false;
        }
    }
}
?>
