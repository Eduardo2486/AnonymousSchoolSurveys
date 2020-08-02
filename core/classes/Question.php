<?php
class Question{
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

    public function insertQuestion($id, $question, $subject){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
            $stmt= $this->pdo->prepare("INSERT INTO questions (survey_id, subject, question, last_change) VALUES (:survey,:subject, :question, :lmod)");
            $stmt->bindParam(":survey",$id,PDO::PARAM_INT);
            $stmt->bindParam(":subject",$subject,PDO::PARAM_STR);
            $stmt->bindParam(":question",$question,PDO::PARAM_STR);
            $stmt->bindParam(":lmod",$_SESSION['user_id'],PDO::PARAM_INT);
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
    }

    public function checkInput($var){
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripcslashes($var);
        return $var;
      }

    public function updateQuestion($id, $field, $text){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        if($field == "question"){
          $stmt= $this->pdo->prepare("UPDATE questions SET question=:text, last_change =:user_id WHERE id=:id");
          $stmt->bindParam(":text",$text,PDO::PARAM_STR);

        }else if($field == "subject"){
          $stmt= $this->pdo->prepare("UPDATE questions SET subject=:subject, last_change =:user_id WHERE id=:id");
          $stmt->bindParam(":subject",$text,PDO::PARAM_STR);
        }
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
    }

    public function deleteQuestion($id){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        $stmt= $this->pdo->prepare("DELETE FROM questions WHERE id=:id");
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
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
    }
}
?>