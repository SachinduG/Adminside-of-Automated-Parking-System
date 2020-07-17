<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

  if (!isset($_SESSION['id'])){
  header('Location: login.php');
 }
  $user_list ='';
   //get list
   $query = "SELECT c_username, c_fname, c_lname, c_nic, license_no, c_address, c_email, c_phone, c_password
             FROM customer  
             ORDER BY c_username";
   $users = mysqli_query($conn,$query);

   verify_query($users);
      while($user = mysqli_fetch_assoc($users)){
        $user_list .="<tr>";
        $user_list .="<td>{$user['c_username']}</td>";
        $user_list .="<td>{$user['c_fname']}</td>";
        $user_list .="<td>{$user['c_lname']}</td>";
        $user_list .="<td>{$user['c_nic']}</td>";
        $user_list .="<td>{$user['license_no']}</td>";
        $user_list .="<td>{$user['c_address']}</td>";
        $user_list .="<td>{$user['c_email']}</td>";
        $user_list .="<td>{$user['c_phone']}</td>";
        $user_list .="<td>{$user['c_password']}</td>";
        $user_list .="</tr>";
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Users</title>
	<link rel="stylesheet" href="style/main.css">
  <link rel="stylesheet" href="style/user.css">
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
    <div class="back"><a href="home.php"><< </a></div>
    <div class="name">&nbsp;Park Me</div>
    <div class="loggedin"> <?php echo $_SESSION['name']; ?> 
    <a href="logout.php">Log out</a>
    </div> 
  </header> 

  <div class="mains clearfix">   
  <div class="h clearfix"><h1>Users</h1></div>
    <br>
    <table class="lists clearfix">
    <tr>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>NIC Number</th>
      <th>License Number</th>
      <th>Address</th>
      <th>Email</th>
      <th>Contact</th>
      <th>Password</th>
    </tr>
    <?php echo $user_list ?>

    </table>
  </div>
</div>
</body>
</html>