<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

  if (!isset($_SESSION['id'])){
  header('Location: login.php');
 }
?>

<?php
	if (isset($_GET['parking_id'])) {

		$query="SELECT image FROM parking_lot WHERE parking_id='$_GET[parking_id]'";
		$result= mysqli_query($conn,$query);
		$row=mysqli_fetch_array($result);
		unlink("upload/".$row['image']);
		$delquery="DELETE FROM parking_lot WHERE parking_id='$_GET[parking_id]'";
		mysqli_query($conn,$delquery);

			header('Location:upload.php?msg=image_deleted');
		}
	else{
			header('Location:upload.php?err=delete_failed');
	    }
?>