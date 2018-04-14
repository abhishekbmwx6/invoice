<?php require('./header.php') ?>
<?php
require_once('./controller/number_to_text.php');
  if(!($_GET && $_GET['id'])){
    echo "invalid Id";exit;
  } 
  $invoice_id = base64_decode($_GET['id']);
    //get invoice details
  $query = "SELECT 
    i.invoice_id,
    i.purches_date,
    i.total_before_tax,
    i.total_after_tax,
    i.saler_id,
    i.created_at,
    u.user_id,
    u.name,
    u.contact,
    u.email,
    u.address,
    u.role,
    us.name as saler,
    us.role as saler_role 
    FROM `invoice` i inner join user u on i.user_id = u.user_id 
    inner join user us on i.saler_id = us.user_id where i.invoice_id=$invoice_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $invoice_result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    // echo "<pre>";
    // print_r($invoice_result);

    $query = "SELECT * 
    FROM `invoice_products` where invoice_id=$invoice_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $invoice_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($invoice_products);

    $query = "SELECT it.*,t.name,t.value,t.tax_type 
    FROM `invoice_tax` it 
    inner join tax t on it.tax_id = t.tax_id
    where invoice_id=$invoice_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $invoice_tax = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($invoice_tax);
    // print_r($_SESSION);

?>
<div class="col-xs-2"></div>
<div class="col-xs-8 invoice_div" id="invoice_div">
  <div class="row">
      <div class="col-xs-5">
      <?php echo isset($_SESSION['user']['shop_name']) ? $_SESSION['user']['shop_name'] : "" ?>
      </div>
      <div class="col-xs-7">
        Tax Invoice/Bill of Supply/Cash Memo<br>
        (Original for Recipents)
      </div>
    </div>
    <hr>
  <div class="row">
      <div class="col-xs-6">
        Sold By:<br>
        <?php echo isset($_SESSION['user']['sold_by']) ? $_SESSION['user']['sold_by'] : "" ?>
      </div>
      <div class="col-xs-6">
        Billing Address: <br>
        <?php echo $invoice_result['address']; ?>
      </div>
    </div>
    <hr>
  <div class="row">
      <div class="col-xs-12">
        <div class="row">PAN No : <?php echo isset($_SESSION['user']['pen_no']) ? $_SESSION['user']['pen_no'] : "" ?></div>
        <div class="row">GST Registration No. : <?php echo isset($_SESSION['user']['gst_no']) ? $_SESSION['user']['gst_no'] : "" ?></div>
      </div>
    </div>
    <hr>  
  <div class="row">
      <div class="col-xs-6">
        Order Date : <?php echo $invoice_result['purches_date'] ?>
      </div>
      <div class="col-xs-6">
        <div class="row">Invoice Number : AKM00<?php echo $invoice_result['invoice_id'] ?></div>
        <div class="row">Invoice Date : <?php echo $invoice_result['created_at'] ?></div>
      </div>
    </div>
    <hr>
    <div class="row">
      <table class="table" >
        <thead>
          <th>Sr.No</th>
          <th>Product<br>Description</th>
          <th>Unit<br>Price</th>
          <th>Qunatity</th>
          <th>Net<br>Amount </th>
          <th>Tax<br>Rate</th>
          <th>Tax<br>Type</th>
          <th>Tax<br>Amount</th>
          <th>Total<br>Amount</th>
        </thead>
        <tbody>
            <?php $count=1; foreach($invoice_products as $product){
              $invoice_tax_rate = "";
              $invoice_tax_type = "";
              $invoice_tax_amount = "";

              foreach($invoice_tax as $tax){
                if($tax["invoice_product_id"]===$product["invoice_product_id"]){
                  $invoice_tax_rate .=$tax["rate"]."%<br>";
                  $invoice_tax_type .=$tax["name"]."<br>";
                  $invoice_tax_amount .=$tax["tax_amount"]." x ".$product["quantity"]."<br>";
                }
              }

              echo "<tr>";
              echo "<td>$count</td>";
              echo "<td>".$product["product_name"]."<br>".$product["Product_desc"]."</td>";
              echo "<td>".$product["product_value"]."</td>";
              echo "<td>".$product["quantity"]."</td>";
              echo "<td>".($product["product_value"]*$product["quantity"])."</td>";
              echo "<td>$invoice_tax_rate</td>";
              echo "<td>$invoice_tax_type</td>";
              echo "<td>$invoice_tax_amount</td>";
              echo "<td>".$product["final_product_value"]."</td>";
              echo "</tr>";
            $count++; } 
            
            echo "<tr>";
            echo "<td colspan='7'>Total</td>";
            echo "<td>".($invoice_result['total_after_tax'] - $invoice_result["total_before_tax"])."</td>";
            echo "<td>".$invoice_result["total_after_tax"]."</td>";
            echo "</tr>";
            echo "<tr><td colspan='9' class='text-capitalize' >Amount in Words: ".convert_number_to_words($invoice_result["total_before_tax"])."</td></tr>";
            
            echo "<tr><td colspan='6'></td><td colspan='3'>A.K. Mobiles <br><br><br></td></tr>";
            echo "<tr><td colspan='6'></td><td colspan='3'>Authorized Signatory</td></tr>";
            ?>
            
        </tbody>
      </table>
    </div>
</div>

<div class="row">
<div class="col-xs-9"></div>
<div class="col-xs-3">
  <button onClick="printContent('invoice_div')">PRINT</button>
</div>
</div>
<script>
 function printContent(el){
var restorepage = $('body').html();
var printcontent = $('#' + el).clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
}
</script>

<?php require('./footer.php') ?>
