<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

  if (!isset($_SESSION['id'])){
  header('Location: login.php');
 }
?>
<?php
	$errors = array();
	$id = '';
	$name = '';
	$email = '';
	$contact = '';
	$password = '';

	if(isset($_GET['id'])){
		//get admin information
		$id = mysqli_real_escape_string($conn,$_GET['id']);
		$query = "SELECT * FROM admin WHERE id = {$id}";

		$result_set = mysqli_query($conn,$query);

		if($result_set){
			if(mysqli_num_rows($result_set) == 1){
				//user found
				$result = mysqli_fetch_assoc($result_set);
				$name = $result['name'];
				$email = $result['email'];
				$contact = $result['contact'];
			}else{
				//user unfound
				header('Location:admin.php?err=admin_not_found');
			}
		}else{
			//query unsuccessful
			header('Location:admin.php?err=query_failed');
		}
	}


	if(isset($_POST['submit'])){
		$id = $_POST['id'];
		$password = $_POST['password'];
		

		//check required feilds
		 $req_field = array('id','password');

		 foreach ($req_field as $field) {
		 	if(empty(trim($_POST[$field]))){
		 		$errors[] = $field . ' is required';
		 	}
		 }
		 //cheking length
		 $max_len_fields = array('password'=>25);

		 foreach ($max_len_fields as $field => $max_len) {
		 	if(strlen(trim($_POST[$field])) > $max_len){
		 		$errors[] = $field . ' must be less than ' . $max_len . ' characters';
		 	}
		 }

		 if(empty($errors)){
		 	//no error found..add new record
		 	 $password = mysqli_real_escape_string($conn, $_POST['password']);

		 	 $query = "UPDATE admin SET ";
		 	 $query .= "password = '{$password}'";
		 	 $query .= "WHERE id = {$id}";

		 	 $result = mysqli_query($conn, $query);

		 	 if($result){
		 	 	//query successful... redirect
		 	 	header('Location:admin.php?admin_Modified=true');		 	 	
		 	 }else{
		 	 	$errors[] = 'Failed to update the password.';
		 	 }

		 }
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Change Password</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style/main.css">
	
	 <style>
	  body{
      margin: 0;
      padding: 0;
    }
	.mainbody {
    background: url(images/parking.jpg);
    background-size: cover;
    background-attachment: fixed;
    display: flex;
    background-repeat: no-repeat;
    width:100%;
    height:100vh;           
}
header .name {
        float: left;
       font-family: cursive;
       text-transform: uppercase;
       color:white;
       text-align: center;
       font-size: 2em;
       background-repeat: repeat-x;
     }
    </style>
</head>
<body>
	<div class="mainbody">
	<header>	
	<div class="back"><a href="modify-admin.php"><< </a></div>	
    <div class="name">&nbsp;Park Me</div>
    <div class="loggedin"> <?php echo $_SESSION['name']; ?> 
    <a href="logout.php">Log out</a>
    </div>

  </header>
	<div class="add">
				
	<h2>Change Password</h2>

	<?php
		if (!empty($errors)){
			echo '<div class="errmsg">';
			echo '<b>There were error(s) on your form.</br>';
			foreach ($errors as $error) {
				echo $error . '<br>';
			}
			echo '</div>';
		}
	?>

	<form action="change-password.php" method="post" class="adminform">
	<input type="hidden" name="id" value="<?php echo $id;?>">
		<p>
			<label for="">Name:</label>
			<span><input type="text" name="name"<?php echo 'value="' . $name . '"';?> disabled></span>
		</p>
		<p>
			<label for="">Email Address:</label>
			<span><input type="text" name="email"<?php echo 'value="' . $email . '"';?> disabled></span>
		</p>
		<p>
			<label for="">Contact:</label>
			<span><input type="text" name="contact"<?php echo 'value="' . $contact . '"';?> disabled></span>
		</p>
		<p>
			<label for="">New Password:</label>
			<input type="password" name="password" id="password">
		</p>
		<p>
			<label for="">Show Password:</label>
			<input type="checkbox" name="showpassword" id="showpassword" style ="width:20px;height:20px" >
		</p>
		<p>
			<label for="">&nbsp;</label>
			<span><button type="submit" name="submit">Update Passsword</button></span>
		</p>
	</form>		
	</div>	
		<script src="js/jquery.js"></script>
		<script>
			$(document).ready(function(){
				$('#showpassword').click(function(){
					if($('#showpassword').is(':checked')){
						$('#password').attr('type','text');
					}else{
						$('#password').attr('type','password');
					}
				});
			});
		</script>
	</div>
</body>
</html>
<?php mysqli_close($conn); ?>