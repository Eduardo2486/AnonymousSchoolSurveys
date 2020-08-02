<?php
class Test{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getQuestion($id){
        $stmt= $this->pdo->prepare("SELECT * FROM questions WHERE survey_id=:id");
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $questions;
    }

    public function insertTest($questionnaire, $teacher, $subject, $partial, $questionnaires_number, $code){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        $stmt= $this->pdo->prepare("SELECT codigo FROM tests WHERE code=:code");
        $stmt->bindParam(":code",$code,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        if($count < 1){
          $stmt= $this->pdo->prepare("INSERT INTO tests (survey_id, teacher_id, subject_id, partial_id, questionnaires_total, code, last_change) VALUES (:questionnaire, :teacher, :subject, :partial, :questionnaires_number, :code, :last_change)");
          $stmt->bindParam(":questionnaire",$questionnaire,PDO::PARAM_INT);
          $stmt->bindParam(":teacher",$teacher,PDO::PARAM_INT);
          $stmt->bindParam(":subject",$subject,PDO::PARAM_INT);
          $stmt->bindParam(":partial",$partial,PDO::PARAM_INT);
          $stmt->bindParam(":questionnaires_number",$questionnaires_number,PDO::PARAM_INT);
          $stmt->bindParam(":code",$code,PDO::PARAM_STR);
          $stmt->bindParam(":last_change",$_SESSION['user_id'],PDO::PARAM_INT);
          $stmt->execute();
          $count = $stmt->rowCount();
            
          if($count == 1){
            return true;
          }else{
            return false;
          }
        }else{
          return "exists";
        }
      }else{
        return false;
      }
    }

    public function updateTest($id, $field, $text){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){

        if($field == "code"){
          $stmt= $this->pdo->prepare("SELECT code FROM tests WHERE code=:code");
          $stmt->bindParam(":code",$text,PDO::PARAM_STR);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count < 1){
            $stmt= $this->pdo->prepare("UPDATE tests SET code=:code, last_change =:user_id WHERE id=:id ");
            $stmt->bindParam(":code",$text,PDO::PARAM_STR);
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            if($count == 1){
              return true;
            }else{
              return false;
            }
          }else{
            return "exists";
          }
        }else if($field == "questionnaires_total"){
          $stmt= $this->pdo->prepare("UPDATE tests SET questionnaires_total=:questionnaires_total, last_change =:user_id WHERE id=:id ");
          $stmt->bindParam(":questionnaires_total",$text,PDO::PARAM_INT);
          $stmt->bindParam(":id",$id,PDO::PARAM_INT);
          $stmt->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count == 1){
            return true;
          }else{
            return false;
          }
        }else{
          return false;
        }

      }else{
        return false;
      }
    }

    public function deleteTest($id){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
        $stmt= $this->pdo->prepare("DELETE FROM tests WHERE id=:id");
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0){
          $stmt= $this->pdo->prepare("DELETE FROM answers WHERE test_id=:id");
          $stmt->bindParam(":id",$id,PDO::PARAM_INT);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count > 0){
            return true;
          }else{
            return false;
          }
        }else{
          return false;
        }
      }else{
        return false;
      }

    }
    public function getAllSurveys(){
      $stmt= $this->pdo->prepare("SELECT * FROM tests; SELECT * FROM surveys; SELECT * FROM teachers; SELECT * FROM subjects; SELECT * FROM partials;");
      $all = array();   
      $stmt->execute();
      do {
        
        array_push($all,$stmt->fetchAll(PDO::FETCH_ASSOC));
      } while ($stmt->nextRowset());
      
      
      if(isset($all)){
        return $all;
      }else{
        return false;
      }
    }

    public function getTest($code){
      $stmt= $this->pdo->prepare("SELECT * FROM tests WHERE code=:code");
      $stmt->bindParam(":code",$code,PDO::PARAM_INT);
      $stmt->execute();
      $stmt = $stmt->fetch(PDO::FETCH_OBJ);
        
      if(isset($stmt)){
          return $stmt;
      }else{
          return false;
      }
    }

    public function getQuestions($id){
      $stmt= $this->pdo->prepare("SELECT * FROM questions WHERE survey_id=:id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();
      $stmt = $stmt->fetchAll(PDO::FETCH_OBJ);
        
      if(isset($stmt)){
          return $stmt;
      }else{
          return false;
      }
    }

    public function getNameSurvey($id){
      $stmt= $this->pdo->prepare("SELECT * FROM surveys WHERE id=:id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();
      $stmt = $stmt->fetch(PDO::FETCH_OBJ);
        
      if(isset($stmt)){
          return $stmt;
      }else{
          return false;
      }
    }

    public function getNameTeacher($id){
      $stmt= $this->pdo->prepare("SELECT * FROM teachers WHERE id=:id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();
      $stmt = $stmt->fetch(PDO::FETCH_OBJ);
        
      if(isset($stmt)){
          return $stmt;
      }else{
          return false;
      }
    }

    public function getNameSubjects($id){
      $stmt= $this->pdo->prepare("SELECT * FROM subjects WHERE id=:id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();
      $stmt = $stmt->fetch(PDO::FETCH_OBJ);
        
      if(isset($stmt)){
          return $stmt;
      }else{
          return false;
      }
    }

    public function getNamePartial($id){
      $stmt= $this->pdo->prepare("SELECT * FROM partials WHERE id=:id");
      $stmt->bindParam(":id",$id,PDO::PARAM_INT);
      $stmt->execute();
      $stmt = $stmt->fetch(PDO::FETCH_OBJ);
        
      if(isset($stmt)){
          return $stmt;
      }else{
          return false;
      }
    }

    public function getNumberSurvey($test_id){
      $stmt= $this->pdo->prepare("SELECT COUNT(*) AS `tests` FROM answers WHERE test_id=:id");
      $stmt->bindParam(":id",$test_id,PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchObject();
      return $result->tests;
    }

    public function availableTests($test_id){
      $stmt= $this->pdo->prepare("SELECT questionnaires_total FROM tests WHERE id=:id");
      $stmt->bindParam(":id",$test_id,PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchObject();
      return $result->questionnaires_total ;
    }

    public function getNumberQuestions($survey_id){
      $stmt= $this->pdo->prepare("SELECT COUNT(*) AS `questions` FROM questions WHERE survey_id=:id");
      $stmt->bindParam(":id",$survey_id,PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchObject();
      return $result->questions;
    }

    public function checkInput($var){
      $var = htmlspecialchars($var);
      $var = trim($var);
      $var = stripcslashes($var);
      return $var;
    }
}
?>