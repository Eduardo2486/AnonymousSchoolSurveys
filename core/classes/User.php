<?php
class User{
	protected $pdo;

	function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function loginUser($user, $password){
		$stmt= $this->pdo->prepare("SELECT id,enrollment,password,name,fathers_last_name,mothers_last_name,rol FROM users WHERE enrollment=:enrollment");
		$stmt->bindParam(":enrollment",$user,PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		
		if(password_verify($password, $user->password)){
			$_SESSION['user_id'] = $user->id;
			$_SESSION['name'] = $user->name;
			$_SESSION['rol'] = $user->rol;
			return true;
		}else{
			return false;
		}
	}

	public function logout(){
		$_SESSION = array();
		session_destroy();
		header('Location: '.BASE_URL.'./index.php');
	}
	
	public function loggedin(){
		return (isset($_SESSION['user_id'])) ? true : false;
	}
	
	public function getUserData($id){
		$stmt= $this->pdo->prepare("SELECT id,enrollment,password,name,fathers_last_name,mothers_last_name,email FROM users WHERE id=:id");
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		$stmt = $stmt->fetch(PDO::FETCH_OBJ);
		
		if(isset($stmt)){
				return $stmt;
		}else{
			return false;
		}
	}

	public function changePersonalData($user_id, $name, $mothers_last_name, $fathers_last_name, $email){
		$stmt= $this->pdo->prepare("UPDATE users SET name =:name, mothers_last_name=:mothers_last_name, fathers_last_name=:fathers_last_name, email=:email WHERE id=:id ");
		$stmt->bindParam(":id",$user_id,PDO::PARAM_INT);
		$stmt->bindParam(":name",$name,PDO::PARAM_STR);
		$stmt->bindParam(":mothers_last_name",$mothers_last_name,PDO::PARAM_STR);
		$stmt->bindParam(":fathers_last_name",$fathers_last_name,PDO::PARAM_STR);
		$stmt->bindParam(":email",$email,PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		
		if($count == 1){
			$_SESSION['name'] = $name;
			return true;
		}else{
			return false;
		}
	}

	public function changePassword($user_id, $password, $newPassword ){
		$stmt= $this->pdo->prepare("SELECT id,password FROM users WHERE id=:id");
		$stmt->bindParam(":id",$user_id,PDO::PARAM_INT);
		$stmt->execute();
		$stmt = $stmt->fetch(PDO::FETCH_OBJ);

		if(password_verify($password, $stmt->password)){
			$change = $this->pdo->prepare("UPDATE users SET password=:password WHERE id=:id");
			$change->bindParam(":id",$user_id,PDO::PARAM_STR);
			$change->bindParam(":password",password_hash($newPassword, PASSWORD_ARGON2I),PDO::PARAM_STR);
			$change->execute();
			$count = $change->rowCount();
			
			if($count == 1){
				return true;
			}else{
				return false;
			}
		}
		
	}

	public function getAllUsers(){ 
		if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
			$stmt= $this->pdo->prepare("SELECT id,enrollment,password,name,fathers_last_name,mothers_last_name,email, rol FROM users");
			$stmt->execute();
			$stmt = $stmt->fetchAll(PDO::FETCH_OBJ); 
			return $stmt;   
		}
	}

	public function checkInput($var){
		$var = htmlspecialchars($var);
		$var = trim($var);
		$var = stripcslashes($var);
		return $var;
	}

	public function createPassword($email,$enrollment, $password){
		$stmt= $this->pdo->prepare("SELECT password FROM users WHERE enrollment=:enrollment AND email=:email");
		$stmt->bindParam(":enrollment",$enrollment,PDO::PARAM_STR);
		$stmt->bindParam(":email",$email,PDO::PARAM_STR);
		$stmt->execute();
		$stmt = $stmt->fetch(PDO::FETCH_OBJ);
		
		if($stmt->password == ''){
			$password = password_hash($password, PASSWORD_ARGON2I);
			$stmt= $this->pdo->prepare("UPDATE users SET password=:password WHERE enrollment=:enrollment AND email=:email");
			$stmt->bindParam(":enrollment",$enrollment,PDO::PARAM_STR);
			$stmt->bindParam(":email",$email,PDO::PARAM_STR);
			$stmt->bindParam(":password",$password,PDO::PARAM_STR);
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

	public function checkDuplicatedData($enrollment, $email){
		$stmt= $this->pdo->prepare("SELECT COUNT(*) AS `total` FROM users WHERE enrollment=:enrollment OR email=:email");
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
	public function insertNewUser($name, $fathers_last_name, $mothers_last_name, $enrollment,$email, $rol){
		if($_SESSION['rol'] == 'superadmin' AND ($rol == 'admin' OR $rol == 'editor')){
			$stmt= $this->pdo->prepare("INSERT INTO users (enrollment, name, fathers_last_name, mothers_last_name, email, rol, last_change) VALUES (:enrollment, :name, :fathers_last_name, :mothers_last_name,  :email, :rol, :user_id)");
			$stmt->bindParam(":enrollment",$enrollment,PDO::PARAM_STR);
			$stmt->bindParam(":name",$name,PDO::PARAM_STR);
			$stmt->bindParam(":fathers_last_name",$fathers_last_name,PDO::PARAM_STR);
			$stmt->bindParam(":mothers_last_name",$mothers_last_name,PDO::PARAM_STR);
			$stmt->bindParam(":email",$email,PDO::PARAM_STR);
			$stmt->bindParam(":rol",$rol,PDO::PARAM_STR);
			$stmt->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			if($count == 1){
				return true;
			}else{
				return false;
			}
		}else if($_SESSION['rol'] == 'admin' AND $rol == 'editor'){
			$stmt= $this->pdo->prepare("INSERT INTO users (enrollment, name, fathers_last_name, mothers_last_name, email, rol, last_change) VALUES (:enrollment, :name, :fathers_last_name, :mothers_last_name,  :email, :rol, :user_id)");
			$stmt->bindParam(":enrollment",$enrollment,PDO::PARAM_STR);
			$stmt->bindParam(":name",$name,PDO::PARAM_STR);
			$stmt->bindParam(":fathers_last_name",$fathers_last_name,PDO::PARAM_STR);
			$stmt->bindParam(":mothers_last_name",$mothers_last_name,PDO::PARAM_STR);
			$stmt->bindParam(":email",$email,PDO::PARAM_STR);
			$stmt->bindParam(":rol",$rol,PDO::PARAM_STR);
			$stmt->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_STR);
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


	public function deleteUser($id){
		if( $_SESSION['rol'] == 'superadmin'){
			$stmt= $this->pdo->prepare("SELECT rol FROM users WHERE id=:id");
			$stmt->bindParam(":id",$id,PDO::PARAM_INT);
			$stmt->execute();
			$stmt = $stmt->fetch(PDO::FETCH_OBJ);
			if($stmt->rol != 'superadmin'){
				$stmt= $this->pdo->prepare("DELETE FROM users WHERE id=:id");
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

		}else if($_SESSION['rol'] == 'admin'){
			$stmt= $this->pdo->prepare("SELECT rol FROM users WHERE id=:id");
			$stmt->bindParam(":id",$id,PDO::PARAM_INT);
			$stmt->execute();
			$stmt = $stmt->fetch(PDO::FETCH_OBJ);
			if($stmt->rol == 'editor'){
				$stmt= $this->pdo->prepare("DELETE FROM users WHERE id=:id");
				$stmt->bindParam(":id",$id,PDO::PARAM_INT);
				$stmt->execute();
				$count = $stmt->rowCount();
				if($count == 1){
					return true;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}

	

	
	public function updateUser($id, $field, $text){
		if( $_SESSION['rol'] == 'superadmin' OR $_SESSION['rol'] == 'admin'){
			if($field == "name"){
				$stmt= $this->pdo->prepare("UPDATE users SET name=:name, last_change =:user_id WHERE id=:id ");
				$stmt->bindParam(":name",$text,PDO::PARAM_STR);
			}else if($field == "fathers_last_name"){
				$stmt= $this->pdo->prepare("UPDATE users SET fathers_last_name=:fathers_last_name, last_change =:user_id WHERE id=:id ");
				$stmt->bindParam(":fathers_last_name",$text,PDO::PARAM_STR);
			}else if($field == "mothers_last_name"){
				$stmt= $this->pdo->prepare("UPDATE users SET mothers_last_name=:mothers_last_name, last_change =:user_id WHERE id=:id ");
				$stmt->bindParam(":mothers_last_name",$text,PDO::PARAM_STR);
			}else if($field == "enrollment"){
				$stmt= $this->pdo->prepare("UPDATE users SET enrollment=:enrollment, last_change =:user_id WHERE id=:id ");
				$stmt->bindParam(":enrollment",$text,PDO::PARAM_STR);
			}else if($field == "email"){
				$stmt= $this->pdo->prepare("UPDATE users SET email=:email, last_change =:user_id WHERE id=:id ");
				$stmt->bindParam(":email",$text,PDO::PARAM_STR);
			}else if($field == "rol"){
				if($text == 'admin' OR $text == 'editor'){
					$stmt= $this->pdo->prepare("UPDATE users SET rol=:rol, last_change =:user_id WHERE id=:id ");
					$stmt->bindParam(":rol",$text,PDO::PARAM_STR);
				}
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

}
?>