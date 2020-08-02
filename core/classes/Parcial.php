<?php
class Parcial{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAllPartials(){
        $stmt= $this->pdo->prepare("SELECT * FROM partials");
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

    public function insertNewPartial($abbreviation,$start_date,$finish_date,$comment){
        if($_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
            $stmt= $this->pdo->prepare("INSERT INTO partials (date_start, date_end, abbreviation, comment, last_change) VALUES (:sdate, :fdate, :abbre, :comment,:user_id)");
            $stmt->bindParam(":sdate",$start_date,PDO::PARAM_STR);
            $stmt->bindParam(":fdate",$finish_date,PDO::PARAM_STR);
            $stmt->bindParam(":abbre",$abbreviation,PDO::PARAM_STR);
            $stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
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


    public function updatePartial($id, $field, $text){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
          if($field == "abbreviation"){
            $stmt= $this->pdo->prepare("UPDATE partials SET abbreviation=:abbreviation, last_change=:user_id WHERE id=:id ");
            $stmt->bindParam(":abbreviation",$text,PDO::PARAM_STR);
  
          }else if($field == "sdate"){
            $stmt= $this->pdo->prepare("UPDATE partials SET date_start=:date_start, last_change=:user_id WHERE id=:id ");
            $stmt->bindParam(":date_start",$text,PDO::PARAM_STR);
  
          }else if($field == "fdate"){
            $stmt= $this->pdo->prepare("UPDATE partials SET date_end=:date_end, last_change=:user_id WHERE id=:id ");
            $stmt->bindParam(":date_end",$text,PDO::PARAM_STR);
  
          }else if($field == "comment"){
            $stmt= $this->pdo->prepare("UPDATE partials SET comment=:comment, last_change=:user_id WHERE id=:id ");
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

    public function deletePartial($id){
        if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'editor'){
            $stmt= $this->pdo->prepare("DELETE FROM partials WHERE id=:id");
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