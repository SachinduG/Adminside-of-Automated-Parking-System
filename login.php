<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
	//check submit
	if(isset($_POST['submit']))
	{
		$errors = array();
		//check name & password
		if(!isset($_POST['email'])||strlen(trim($_POST['email']))<1){
			$errors[] = 'Admin Name Invalid';
		}
		if(!isset($_POST['password'])||strlen(trim($_POST['password']))<1){
			$errors[] = 'Admin password Invalid';
		}
		//check any errors
		if(empty($errors)){
			//save name,password to variables
			$email    =mysqli_real_escape_string($conn,$_POST['email']);
			$password =mysqli_real_escape_string($conn,$_POST['password']);
			//$hashed_password = sha1($password);
			

			//prepare database
			$query = "SELECT * FROM admin 
					WHERE email = '{$email}' 
					AND password = '{$password}' 
					LIMIT 1";

			$result_set = mysqli_query($conn,$query);

			verify_query($result_set);
				//query succesfull
				if(mysqli_num_rows($result_set) == 1){
					//valid user found and direct home
					$admin = mysqli_fetch_assoc($result_set);
					$_SESSION['id'] = $admin['id'];
					$_SESSION['name'] = $admin['name'];
					
					$result_set = mysqli_query($conn,$query);

					verify_query(result_set);

					header('Location: home.php');
				}else{
					//invalid password
					$errors[] = 'Inavalid Username / Password';
				}
		}
	
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>log in</title>
	<link rel="stylesheet" href="style/main.css">
	<style>

body{
	margin: 0;
	padding: 0;
	background-image: url(images/img.png);
	background-size: cover;

}
	</style>
</head>
<body>
	<div class="login">
		<h1>Log In</h1>
		<form action="login.php" method="POST">
			<?php
			if(isset($errors) && !empty($errors)){
				echo '<div class="error">Invalid Username or Password</div>';
			}

			?>

			<p>
				<label for="">Admin:</label>
				<input type="text" name="email" id="" placeholder="Email address">
			</p>
			<p>
				<label for="">Password:</label>
				<input type="password" name="password" id="" placeholder="Password">
			</p>
			<p>
				<button type="submit" name="submit">Log In</button>
			</p>


		</form>

	</div>
	</div>
</body>
</html>
<?php 
	$conn->close();
?>