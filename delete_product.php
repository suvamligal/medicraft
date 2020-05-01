<?php 
include("includes/auth.php");

adminOnly();

if(isset($_GET['id'])){
	$id= $_GET['id'];
	if(is_numeric($id)){
		$query= "delete from products where id='$id'";
		$r = $dbconnection->query($query);
		
		if($r){
			redirectWithMessage("Successfully deleted product");
		}else{
			redirectWithMessage("Failed to delete product");

		}
	}else{
			redirectWithMessage("No numeric id");

	}
}

	redirectWithMessage("Malformed Request");


?>
