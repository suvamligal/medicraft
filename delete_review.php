<?php

require('includes/auth.php');

if(!$login){
	redirectWithMessage('Not loggedin');
}

$super = false;

//check if user is other than customers
if($user['role_id']>0){
	$super = true;
}


if(isset($_GET['id'])){
	$id = $_GET['id'];
	
	$uid= $user['id'];
	$query = "Select id from reviews where id='$id' and user_id='$uid'";
	
	if($super)
	$query ="select id from reviews where id='$id'";
	
	
	$re = $dbconnection->query($query);
	
	if($re->num_rows==0)
	redirectWithMessage("Not allowed");
	
	$query = "DELETE from reviews where id='$id'";
	$dbconnection->query($query);
	
	redirectBackWithMessage("Successfully deleted");
}

redirectWithMessage("Invalid");