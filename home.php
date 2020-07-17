<?php session_start(); ?>
<?php require_once('inc/confrig.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

  if (!isset($_SESSION['id'])){
  header('Location: login.php');
 }
?>
<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title> 
    <link rel="stylesheet" href="style/main.css">
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
      display: flex;
    }
    .mainbody{
      height: 100vh;
      width: 100%;

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
<div class="mainbody clearfix">
  <header>
    <div class="name">Park me</div>
    <div class="loggedin"> <?php echo $_SESSION['name']; ?> 
    <a href="logout.php">Log out</a>
    </div>

  </header>

    <section class="mbody clearfix">
     <div class="menubar">
      
        <ul>
           <li><a href="upload.php">PARKING LOT</a></li> <br>
              <li><a href="admin.php">ADMIN</a></li> <br>
              <li><a href="user.php">USER</a></li>     
        </ul>
     </div>
  </section>
</div>
</body>

</html>
