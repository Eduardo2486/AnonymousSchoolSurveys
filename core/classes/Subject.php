<?php
class Subject{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAllSubjects(){
        $stmt= $this->pdo->prepare("SELECT * FROM subjects");
        $stmt->execute();
        $stmt = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        if(isset($stmt)){
            return $stmt;
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

    public function insertNewSubject($subject,$career,$grade,$group ){
        if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
            $stmt= $this->pdo->prepare("INSERT INTO subjects (subject, career, grade, groupp, last_change) VALUES (:subject, :career, :grade, :group, :user_id)");
            $stmt->bindParam(":subject",$subject,PDO::PARAM_STR);
            $stmt->bindParam(":career",$career,PDO::PARAM_STR);
            $stmt->bindParam(":grade",$grade,PDO::PARAM_INT);
            $stmt->bindParam(":group",$group,PDO::PARAM_INT);
            $stmt->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
            $stmt->execute();
            var_dump($stmt);
            $count = $stmt->rowCount();
            echo $count;
            if($count == 1){
              return true;
            }else{
              return false;
            }
        }else{
            return false;
        }
    }


    public function updateSubject($id, $field, $text){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
          if($field == "subject"){
            $stmt= $this->pdo->prepare("UPDATE subjects SET subject=:subject, last_change =:user_id WHERE id=:id ");
            $stmt->bindParam(":subject",$text,PDO::PARAM_STR);
  
          }else if($field == "career"){
            $stmt= $this->pdo->prepare("UPDATE subjects SET career=:career, last_change =:user_id WHERE id=:id ");
            $stmt->bindParam(":career",$text,PDO::PARAM_STR);
  
          }else if($field == "grade"){
            $stmt= $this->pdo->prepare("UPDATE subjects SET grade=:grade, last_change =:user_id WHERE id=:id ");
            $stmt->bindParam(":grade",$text,PDO::PARAM_STR);

          }else if($field == "group"){
            $stmt= $this->pdo->prepare("UPDATE subjects SET groupp=:group, last_change =:user_id WHERE id=:id ");
            $stmt->bindParam(":group",$text,PDO::PARAM_STR);
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

    public function deleteSubject($id){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
           
            $stmt= $this->pdo->prepare("DELETE FROM subjects WHERE id=:id");
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            if($count == 1){
                return true;
            }else{
                return false;
            }

        }
    }
}
?>