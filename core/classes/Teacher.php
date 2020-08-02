<?php
class Teacher{
    protected $pdo;

    function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function checkDuplicatedData($enrollment,$email){
      $stmt= $this->pdo->prepare("SELECT COUNT(*) AS `total` FROM teachers WHERE enrollment=:enrollment OR email=:email");
      $stmt->bindParam(":enrollment",$enrollment,PDO::PARAM_STR);
      $stmt->bindParam(":email",$email,PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchObject();
      if($result->total > 0){
        return false;
      }else{
        return true;
      }
    }

    public function getAllTeachers(){
      $stmt= $this->pdo->prepare("SELECT * FROM teachers");
      $stmt->execute();
      $teachers = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $teachers;
    }

    public function insertNewTeacher($name, $fathers_last_name, $mothers_last_name,$enrollment, $email, $user_id){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        $stmt= $this->pdo->prepare("INSERT INTO teachers (name, fathers_last_name, mothers_last_name, enrollment, email, last_change) VALUES (:name, :fathers_last_name, :mothers_last_name, :enrollment, :email, :user_id)");
        $stmt->bindParam(":enrollment",$enrollment,PDO::PARAM_STR);
        $stmt->bindParam(":name",$name,PDO::PARAM_STR);
        $stmt->bindParam(":fathers_last_name",$fathers_last_name,PDO::PARAM_STR);
        $stmt->bindParam(":mothers_last_name",$mothers_last_name,PDO::PARAM_STR);
        $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
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

    public function updateTeacher($id, $field, $text){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        if($field == "name"){
          $stmt= $this->pdo->prepare("UPDATE teachers SET name=:name, last_change =:user_id WHERE id=:id ");
          $stmt->bindParam(":name",$text,PDO::PARAM_STR);

        }else if($field == "fathers_last_name"){
          $stmt= $this->pdo->prepare("UPDATE teachers SET fathers_last_name=:fathers_last_name, last_change =:user_id WHERE id=:id ");
          $stmt->bindParam(":fathers_last_name",$text,PDO::PARAM_STR);

        }else if($field == "mothers_last_name"){
          $stmt= $this->pdo->prepare("UPDATE teachers SET mothers_last_name=:mothers_last_name, last_change =:user_id WHERE id=:id ");
          $stmt->bindParam(":mothers_last_name",$text,PDO::PARAM_STR);

        }else if($field == "enrollment"){
          $stmt= $this->pdo->prepare("UPDATE teachers SET enrollment=:enrollment, last_change =:user_id WHERE id=:id ");
          $stmt->bindParam(":enrollment",$text,PDO::PARAM_STR);

        }else if($field == "email"){
          $stmt= $this->pdo->prepare("UPDATE teachers SET email=:email, last_change =:user_id WHERE id=:id ");
          $stmt->bindParam(":email",$text,PDO::PARAM_STR);
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

    public function deleteTeacher($id){
      if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
        $stmt= $this->pdo->prepare("DELETE FROM teachers WHERE id=:id");
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



    public function checkInput($var){
      $var = htmlspecialchars($var);
      $var = trim($var);
      $var = stripcslashes($var);
      return $var;
    }

}
?>