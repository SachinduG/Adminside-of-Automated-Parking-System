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
	$parking_id = '';
	$address = '';
	$available_slots = '';
	$image = '';

	if(isset($_POST['upload'])){

		$parking_id = $_POST['parking_id'];
		$address = $_POST['address'];
		$available_slots = $_POST['available_slots'];
		$image = $_FILES['image']['name'];
		$temp_name = $_FILES['image']['tmp_name'];
		$fileError = $_FILES['image']['error'];
		$fileSize = $_FILES['image']['size'];

		//check required feilds
		 $req_field = array('parking_id','address','available_slots');

		 foreach ($req_field as $field) {
		 	if(empty(trim($_POST[$field]))){
		 		$errors[] = '- '.$field . ' is required';
		 	}
		 }
		 if(empty($_FILES['image']['name'])){
		 	$errors[] = '- Choose File?';
		 }
		 if(empty($errors)){
				$fileExt = explode('.',$image);
				$fileActualExt = strtolower(end($fileExt));

				$allowed = array('jpg','png','jpeg');
				if (in_array($fileActualExt,$allowed) === false){
					$errors[] = 'You Cannot Upload Files of This Type!';
				}
				if ($fileSize > 1000000){
					$errors[] = 'Your file is too big!';
				}
			}
		 	$upload_to = "upload/".basename($_FILES['image']['name']);
		 	if(empty($errors)){
		 	$query = "INSERT INTO parking_lot(parking_id,address,available_slots,image)
			 		  VALUES ('$parking_id','{$address}','{$available_slots}','{$image}')";
		 	mysqli_query($conn, $query);

		 	if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_to)) {
		 		header("Location:upload.php?upload=success");
		 		$errors[] = 'Image uploaded successfully!';
		 	}else{
		 		$errors[] = '- There was problem.';

		 	}
		 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>UPLOAD</title>
	<link rel="stylesheet" href="style/main.css">
	<link rel="stylesheet" href="style/upload.css">
	<style>
	 body{
      margin: 0;
      padding: 0;
    }
	body {
    background: url(images/parking.jpg);
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
    width:100%;
    height:100vh;  
    height: 100%;
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
	<div class="back"><a href="home.php"><< </a></div>		
    <div class="name">&nbsp;Park Me</div>
    <div class="loggedin"> <?php echo $_SESSION['name']; ?> 
    <a href="logout.php">Log out</a>
    </div>

  </header>
  <div class="container">
	<div class="upimage">
		<div class="upimghead">
			<h2>Upload Images</h2>
		</div>
		<div class="upimgbody">
		<?php
			if (!empty($errors)){
				echo '<div class="errmsg">';
				echo '<b>There were error(s) on your Upload.</br>';
				foreach ($errors as $error) {
				echo $error . '<br>';
				}
				echo '</div>';
			}
		?>
		<form action="upload.php" method="post" enctype="multipart/form-data" class="uploadform">
		<p>
		<label for="">Parking ID:</label>
		<input type="text" name="parking_id" placeholder="Parking ID"<?php echo 'value="' . $parking_id . '"';?>>
		</p>
		<p>			
		<label for="">Address:</label>
		<input type="text" name="address" placeholder="Address"<?php echo 'value="' . $address . '"';?>>
		</p>
		<p>
		<label for="">Available Slots:</label>
		<input type="text" name="available_slots" placeholder="Available Slots"<?php echo 'value="' . $available_slots . '"';?>>
		</p>
		<p>
		<label for="">&nbsp;</label>
		<input type="file" name="image">
		</p>
		<p>
		<label for="">&nbsp;</label>
		<input type="submit" name="upload" value="UPLOAD">
		</p>
		</form>
		</div>

		<div class="upimggallery clearfix">
			<?php
				$query = "SELECT  image, parking_id, address, available_slots 
						  FROM parking_lot
						  ORDER BY parking_id";

				$result = mysqli_query($conn,$query);
				
				while ($row = mysqli_fetch_array($result)){
					echo "<div class='tag'>";
					echo "<img src='upload/".$row['image']."'>";
					echo "<h2>".$row['parking_id']."</h2>";
					echo "<h3>".$row['address']."</h3>";
					echo "<h4>".$row['available_slots']."</h4>";
					echo "<h5><a href=\"delete-image.php?parking_id={$row['parking_id']}\"
                        onclick=\"return confirm('Are You Sure?');\">Delete</a></h5>";
					echo "</div>";
				}

			?>
		</div>
	</div>
  </div>

</div>
</body>
</html>