<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

  if (!isset($_SESSION['id'])){
  header('Location: login.php');
 }
?>
<?php

	if(isset($_GET['id'])){
		//get admin information
		$id = mysqli_real_escape_string($conn,$_GET['id']);
		
		if($id == $_SESSION['id']){
			//not delete current user
			header('Location:admin.php?err=cannot_delete_current_admin');
		}else{
			//delete admin
			$query = "DELETE FROM admin WHERE id = $id";

			$result = mysqli_query($conn,$query);

			if($result){
				//admin deleted
				header('Location:admin.php?msg=admin_deleted');
			}else{
				header('Location:admin.php?err=delete_failed');
			}
		}
		
	}else{
		header('Location:admin.php');
	}
?>