<?php
require_once('db.php');
session_start();


//default is not logged in
$login = false;
$user = null;

function getRole($role){
	switch($role){
		case 0:
			return 'Customer';
		case 1:
			return 'Employee';
		case 2:
			return 'Manager';
		default:
			return "error";
	}	
}

if(isset($_SESSION['login']) &&  isset($_SESSION['user'])){
    $user_id= $_SESSION['user'];
    $login=$_SESSION['login'];
    
    //find user details as only id of logged in user is saved in cookies
    $query="select * from users where users.id='$user_id'";
    $result= $dbconnection->query($query);
    
    if($result){
        $user = $result->fetch_assoc();
        $login=true;
        $role = getRole($user['role_id']);
    }else{
        session_destroy();
        $user=null;
        $login = false;
    }
}

function redirectWithMessage($message){
		$_SESSION['message'] = "$message";
		header('location: index.php');
		exit;
}

function redirectBackWithMessage($message){
		$_SESSION['message'] = "$message";
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
}

function loginOnly(){
	global $login,$user;
	if(!$login){
		$_SESSION['message'] = "You don't have permission to view that page";
		header('location: index.php');
	}
}

function adminOnly(){
	global $login,$user;
	if(!$login || $user['role_id']==0){
		$_SESSION['message'] = "You don't have permission to view that page";
		header('location: index.php');
		exit;
	}
	
}

//if logged in, $login will be true and $user will contain details about logged in user fetched from database.

