<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>A.K. Mobiles</title>
      <link rel="stylesheet" href="./css/style.css">
      <link rel="stylesheet" href="./css/bootstrap.min.css" media='all'>
      <link rel="stylesheet" href="./css/jquery.dataTables.min.css">
      <script src="./js/jquery-3.3.1.min.js"></script>
      
</head>
<body>
    <div class="container">
<?php 
$conn = include('./controller/connection.php');
if($_SESSION && $_SESSION["user"]){
?>
<div class="col-xs-12 alert alert-success">
    <div class="col-xs-3"><?php echo date("l jS \of F Y ") ?></div>    
    <div class="col-xs-3"></div>    
<div class="text-left col-xs-4"> Welcome : <?php echo $_SESSION['user']['name'] ?></div>
<div class="2"><a href="./home.php">Home</a>  /  <a href="./controller/logout.php">Logout</a></div>
</div>
<?php } ?>