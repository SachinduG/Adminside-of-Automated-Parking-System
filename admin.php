<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

  if (!isset($_SESSION['id'])){
  header('Location: login.php');
 }
   $admin_list ='';
   //get list
   $query = "SELECT id, name, email, contact FROM admin ORDER BY id";
   $admins = mysqli_query($conn,$query);

   verify_query($admins);
   		while($admin = mysqli_fetch_assoc($admins)){
   			$admin_list .="<tr>";
   			$admin_list .="<td>{$admin['id']}</td>";
   			$admin_list .="<td>{$admin['name']}</td>";
   			$admin_list .="<td>{$admin['email']}</td>";
        $admin_list .="<td>{$admin['contact']}</td>";
   			$admin_list .="<td><a href=\"modify-admin.php?id={$admin['id']}\">Edit</a></td>";
   			$admin_list .="<td><a href=\"delete-admin.php?id={$admin['id']}\"
                        onclick=\"return confirm('Are You Sure?');\">Delete</a></td>";
   			$admin_list .="</tr>";
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admins</title> 

	
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
    height: 100%;
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
    <div class="back"><a href="home.php"><< </a></div>
    <div class="name">&nbsp;Park Me</span></div>
    <div class="loggedin"> <?php echo $_SESSION['name']; ?> 
    <a href="logout.php">Log out</a>
    </div>

  </header>
	<div class="main clearfix">		
	<h1>Admins</h1><span><a href="addadmin.php">+ Add New Admin</a></span>

		<table class="list clearfix">
		<tr>
			<th>Username</th>
			<th>Name</th>
			<th>Email</th>
      <th>Phone</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php echo $admin_list ?>

		</table>
	</div>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>