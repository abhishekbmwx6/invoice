<?php
$conn = include('./connection.php');
error_reporting(E_ERROR | E_PARSE);

  if(!($_GET && $_GET['id'])){
    echo "invalid Id";exit;
  } 
  $invoice_id = base64_decode($_GET['id']);
    try {

     echo $query = "update invoice set status='inactive' where invoice_id='".$invoice_id."'";
      $stmt = $conn->prepare($query); 
      $stmt->execute();   

   } catch(PDOException $e) {
    $conn->rollBack();
    echo $e;
    throw $e;
   }
   header("location: ../home.php?success='invoice deleted successful!'");

?>