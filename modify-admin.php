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
		$name = $_POST['name'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];

		//check required feilds
		 $req_field = array('id','name','email','contact');

		 foreach ($req_field as $field) {
		 	if(empty(trim($_POST[$field]))){
		 		$errors[] = $field . ' is required';
		 	}
		 }
		 //cheking length
		 $max_len_fields = array('name'=>40,'email'=>40,'contact'=>12);

		 foreach ($max_len_fields as $field => $max_len) {
		 	if(strlen(trim($_POST[$field])) > $max_len){
		 		$errors[] = $field . ' must be less than ' . $max_len . ' characters';
		 	}
		 }
		 //check email already
		 $email = mysqli_real_escape_string($conn, $_POST['email']);
		 $query = "SELECT * FROM admin WHERE email ='{$email}' AND id = $id";

		 $result_set = mysqli_query($conn,$query);

		 if($result_set){
		 	if (mysqli_num_rows($result_set)==1){
		 		$errors[] = 'Email address is already exists';
		 	}
		 }
		 if(empty($errors)){
		 	//no error found..add new record
		 	 $name = mysqli_real_escape_string($conn, $_POST['name']);
		 	 $contact = mysqli_real_escape_string($conn, $_POST['contact']);

		 	 $query = "UPDATE admin
			  		   SET name = '{$name}', email = '{$email}', contact = {$contact}
		 	 		   WHERE id = $id";

		 	 $result = mysqli_query($conn, $query);

		 	 if($result){
		 	 	//query successful... redirect
		 	 	header('Location:admin.php?admin_Modified=true');		 	 	
		 	 }else{
		 	 	$errors[] = 'Failed to Modify the record.';
		 	 }

		 }
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Modify Admin</title> 
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
    background-repeat: no-repeat;
    width:100%;
    height:100vh; 
	display: flex;          
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
	<div class="back"><a href="admin.php"><< </a></div>		
    <div class="name">&nbsp;Park Me</div>
    <div class="loggedin"> <?php echo $_SESSION['name']; ?> 
    <a href="logout.php">Log out</a>
    </div>

  </header>
	<div class="add">
				
	<h2>Modify Admin</h2>

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

	<form action="modify-admin.php" method="post" class="adminform">
	<input type="hidden" name="id" value="<?php echo $id;?>">
		<p>
			<label for="">Name:</label>
			<input type="text" name="name"<?php echo 'value="' . $name . '"';?>>
		</p>
		<p>
			<label for="">Email Address:</label>
			<input type="text" name="email"<?php echo 'value="' . $email . '"';?>>
		</p>
		<p>
			<label for="">Contact:</label>
			<input type="text" name="contact"<?php echo 'value="' . $contact . '"';?>>
		</p>
		<p>
			<label for="">Password:</label>
			 <a href="change-password.php?id=<?php echo $id; ?>">Change Password..</a>
		</p>
		<p>
			<label for="">&nbsp;</label>
			<button type="submit" name="submit">Save</button>
		</p>


	</form>		
	</div>
	</div>		
</body>
</html>
<?php mysqli_close($conn); ?>