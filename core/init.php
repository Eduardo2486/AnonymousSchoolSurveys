<?php 
	
	include 'database/connection.php';
	include 'classes/User.php';
	include 'classes/Teacher.php';
	include 'classes/Parcial.php';
	include 'classes/Subject.php';
	include 'classes/Survey.php';
	include 'classes/Question.php';
	include 'classes/Test.php';
	include 'classes/Answer.php';
	include 'classes/Chart.php';

	global $pdo;

    session_start();
    session_regenerate_id();

	$getFromU = new User($pdo);
	$getFromT = new Teacher($pdo);
	$getFromP = new Parcial($pdo);
	$getFromS = new Subject($pdo);
	$getFromSur = new Survey($pdo);
	$getFromQ = new Question($pdo);
	$getFromTest = new Test($pdo);
	$getFromA = new Answer($pdo);
	$getFromC = new Chart($pdo);
	$path = "/cuestionario";
	$servername =  $_SERVER['SERVER_NAME'].$path;
	define("BASE_URL",$servername);
	define("DEFAULT_PATH", $path);
	
?>
