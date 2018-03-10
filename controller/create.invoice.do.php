<?php
$conn = include('./connection.php');
error_reporting(E_ERROR | E_PARSE);
if($_POST && $_POST["contact"]){
    // echo "<pre>";
    // print_r($_SESSION);
    // print_r($_POST);
    // exit;
    try {

    $total_before_tax = 0;

    foreach($_POST["price"] as $key=>$val){
        $total_before_tax += $_POST["quantity"][$key] * $val ;
    }
        
       $conn->beginTransaction(); 

    $query ='INSERT INTO `user` SET
    name="'.$_POST['name'].'"
   ,contact="'.$_POST['contact'].'"
   ,email="'.($_POST['email'] && $_POST['email']!=="" ?$_POST['email']:null).'"
   ,address="'.$_POST['address'].'",
    role="user" 
    ON DUPLICATE KEY UPDATE 
    name="'.$_POST['name'].'"
   ,contact="'.$_POST['contact'].'"
   ,email="'.($_POST['email'] && $_POST['email']!=="" ?$_POST['email']:null).'"
   ,address="'.$_POST['address'].'",
    role="user"';
    $stmt = $conn->prepare($query); 
    $stmt->execute();
    $user_id = $conn->lastInsertId();
    
    if(!isset($user_id) || $user_id==0){
        echo $query = "select user_id from user where contact='".$_POST['contact']."'";
        $stmt = $conn->prepare($query); 
        $stmt->execute();
        $user_id = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["user_id"];
    }
    
    // echo "<br>";
    //insert Invoice
    $query ='INSERT INTO `invoice` SET user_id="'.$user_id.'"
   , purches_date=now()
   , total="'.$_POST['grand_total'].'"
   , total_before_tax="'.$total_before_tax.'"
   , total_after_tax="'.array_sum($_POST['total']).'"
   , saler_id="'.$_SESSION['user']['user_id'].'"';

   $stmt = $conn->prepare($query); 
   $stmt->execute();

   $invoice_id = $conn->lastInsertId();

   //insert product
   foreach($_POST["product"] as $key => $value){
    // echo "<br>";
   $query ='INSERT INTO `invoice_products` SET invoice_id="'.$invoice_id.'"
    , product_name="'.$value.'"
    , product_value="'.$_POST['price'][$key].'"
    , value_before_tax="'.$_POST['price'][$key].'"
    , value_after_tax="'.$_POST['total'][$key].'"
    , quantity="'.$_POST['quantity'][$key].'"
    , final_product_value="'.($_POST['total'][$key]).'"';

    $stmt = $conn->prepare($query); 
    $stmt->execute();

    $invoice_product_id = $conn->lastInsertId();

        if($_POST['sgst'][$key]){

            echo $query ='INSERT INTO `invoice_tax` SET invoice_id="'.$invoice_id.'"
            , invoice_product_id="'.$invoice_product_id.'"
            , tax_id=1
            , rate="'.$_POST['sgst'][$key].'"
            , tax_amount="'.(($_POST['price'][$key]*$_POST['sgst'][$key])/100).'"';

            $stmt = $conn->prepare($query); 
            $stmt->execute();
        }

        if($_POST['cgst'][$key]){
            echo $query ='INSERT INTO `invoice_tax` SET invoice_id="'.$invoice_id.'"
            , invoice_product_id="'.$invoice_product_id.'"
            , tax_id=2
            , rate="'.$_POST['cgst'][$key].'"
            , tax_amount="'.(($_POST['price'][$key]*$_POST['cgst'][$key])/100).'"';

            $stmt = $conn->prepare($query); 
            $stmt->execute();
        }
   }
//    exit;
   $conn->commit();

   } catch(PDOException $e) {
    $conn->rollBack();
    echo $e;
    throw $e;
   }

   header("location: ../home.php?success='invoice added successful!'");

}else{
    //contact not found
   header("location: ../home.php?error='all fields are required!'");
    
}
?>