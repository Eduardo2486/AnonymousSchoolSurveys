<?php
class Survey{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }


    public function getAllSurveys(){
      $stmt= $this->pdo->prepare("SELECT * FROM surveys");
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

    public function insertNewSurvey($title, $comment){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
          $stmt= $this->pdo->prepare("INSERT INTO surveys (title, comment, last_change) VALUES (:title, :comment, :lmod)");
          $stmt->bindParam(":title",$title,PDO::PARAM_STR);
          $stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
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

    public function updateSurvey($id, $field, $text){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        if($field == "title"){
          $stmt= $this->pdo->prepare("UPDATE surveys SET title=:title, last_change =:user_id WHERE id=:id");
          $stmt->bindParam(":title",$text,PDO::PARAM_STR);

        }else if($field == "comment"){
          $stmt= $this->pdo->prepare("UPDATE surveys SET comment=:comment, last_change =:user_id WHERE id=:id");
          $stmt->bindParam(":comment",$text,PDO::PARAM_STR);
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

    public function deleteSurvey($id){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
        $stmt= $this->pdo->prepare("DELETE FROM surveys WHERE id=:id");
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

    public function getSurvey($id){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        $stmt= $this->pdo->prepare("SELECT * FROM surveys WHERE id=:id");
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_OBJ);

        if(isset($stmt)){
          return $stmt;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

  
}
?>