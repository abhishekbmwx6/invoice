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
    
    function check_tax($type,$id,$conn){
        $query = "SELECT it.*,t.name,t.value,t.tax_type 
        FROM `invoice_tax` it 
        inner join tax t on it.tax_id = t.tax_id
        where t.name = '$type' and it.invoice_product_id=$id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $invoice_tax_check = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return isset($invoice_tax_check[0])? true : false;
    }
    // print_r($_SESSION);

?>

<div class="col-md-1"></div>
<div class="col-md-10">
    <div class="form-area">  
        <form role="form" method="POST" onsubmit="return validateForm()" action="./controller/update.invoice.do.php?id=<?php echo $_GET['id']; ?>">
        <br style="clear:both">
                    <h3 style="margin-bottom: 25px; text-align: center;">Update Invoice</h3>
                    <h3 style="margin-bottom: 10px; text-align: left;">User Info</h3>
                    
                    <div class="form-group col-md-5">
                        <input type="tel" class="form-control chk" value="<?php echo isset($invoice_result['contact']) ? $invoice_result['contact']:"" ?>" onfocusout="getUserDetails()"  id="contact" name="contact" placeholder="User Contact Number" required>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($invoice_result['email']) ? $invoice_result['email']:"" ?>" placeholder="Email">
                    </div>
                    <div class="form-group">
						<input type="text" class="form-control chk" id="name" name="name" value="<?php echo isset($invoice_result['name']) ? $invoice_result['name']:"" ?>" placeholder="User Name" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control chk" id="address" name="address" value="<?php echo isset($invoice_result['address']) ? $invoice_result['address']:"" ?>" placeholder="User Address" required>
                    </div>

                    <h3 style="margin-bottom: 10px; text-align: left;">Products</h3>
                    <table id="myTable" class=" table order-list">
                    <thead>
                        <tr>
                            <th>#</td>
                            <td>Product</td>
                            <td>Qunatity</td>
                            <td>price</td>
                            <td>SGST</td>
                            <td>CGST</td>
                            <td>Total</td>
                            <td>Delete</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php  if(isset($invoice_products) && count($invoice_products)){
                            $count =1;
                            foreach($invoice_products as $product){ ?>
                                
                                <tr>
                            <td class="col-sm-1"><?php echo $count ?></td>
                            <td class="col-sm-4">
                                <input type="text" name="product[<?php echo $count  ?>]" id="product<?php echo $count  ?>" value="<?php echo isset($product['product_name']) ? $product['product_name']:"" ?>" class="form-control chk" />
                            </td>
                            <td class="col-sm-2">
                                <input type="number" name="quantity[<?php echo $count  ?>]"  id="quantity<?php echo $count  ?>" value="<?php echo isset($product['quantity']) ? $product['quantity']:"" ?>" onfocusout="showTotal(1)" class="form-control chk"/>
                            </td>
                            <td class="col-sm-2">
                                <input type="number" name="price[<?php echo $count  ?>]" id="price<?php echo $count  ?>" value="<?php echo isset($product['product_value']) ? $product['product_value']:"" ?>" onfocusout="showTotal(1)" class="form-control chk"/>
                            </td>
                            <td class="col-sm-1">
                                <input type="checkbox" name="sgst[<?php echo $count  ?>]" id="sgst<?php echo $count  ?>" value='6' onchange="showTotal(<?php echo $count  ?>)"  <?php echo check_tax("sgst",$product['invoice_product_id'],$conn) ? "checked" :"" ?> class="form-control"/>
                            </td>
                            <td class="col-sm-1">
                                <input type="checkbox" name="cgst[<?php echo $count  ?>]" id="cgst<?php echo $count  ?>" value='6' onchange="showTotal(<?php echo $count  ?>)" <?php echo check_tax("cgst",$product['invoice_product_id'],$conn) ? "checked" :"" ?> class="form-control"/>
                            </td>
                            <td class="col-sm-2">
                                <label id="total_label<?php echo $count  ?>" class="form-control" ><?php echo isset($product['final_product_value']) ? $product['final_product_value']:0.00 ?></label>
                                <input type="hidden" name="total[<?php echo $count  ?>]" class="final_grand_total" value="<?php echo isset($product['final_product_value']) ? $product['final_product_value']:0 ?>" id="total_label_hidden<?php echo $count  ?>"/>
                            </td>
                            <td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>
                        </tr>

                           <?php $count++; }

                        }else{ ?>

                        <tr>
                            <td class="col-sm-1">1</td>
                            <td class="col-sm-4">
                                <input type="text" name="product[1]" id="product1" class="form-control chk" />
                            </td>
                            <td class="col-sm-2">
                                <input type="number" name="quantity[1]"  id="quantity1" value="0" onfocusout="showTotal(1)" class="form-control chk"/>
                            </td>
                            <td class="col-sm-2">
                                <input type="number" name="price[1]" id="price1" value="0" onfocusout="showTotal(1)" class="form-control chk"/>
                            </td>
                            <td class="col-sm-1">
                                <input type="checkbox" name="sgst[1]" id="sgst1" value='6' onchange="showTotal(1)"  checked class="form-control"/>
                            </td>
                            <td class="col-sm-1">
                                <input type="checkbox" name="cgst[1]" id="cgst1" value='6' onchange="showTotal(1)" checked class="form-control"/>
                            </td>
                            <td class="col-sm-2">
                                <label id="total_label1" class="form-control" >0.00</label>
                                <input type="hidden" name="total[1]" class="final_grand_total" value="0" id="total_label_hidden1"/>
                            </td>
                            <td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: left;">
                                <input type="button" class="btn btn-lg btn-block " id="addrow" value="Add Row" />
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    </tfoot>
                </table>
                    <h3 style="margin-bottom: 10px; text-align: left;">Total : 
                        <label id="all_total"><?php echo isset($invoice_result['total_after_tax']) ? $invoice_result['total_after_tax']:0.00 ?></label>
                        <input type="hidden" name="grand_total" value="<?php echo isset($invoice_result['total_after_tax']) ? $invoice_result['total_after_tax']:0.00 ?>" id="all_total_hidden">
                    </h3>
                    
                                
        <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Update Invoice</button>
        </form>
    </div>
</div>
<script>
    var sgst_val = 6;
    var cgst_val = 6;
    function showTotal(counter){
        var quantity = $("#quantity"+counter).val();
        var price = $("#price"+counter).val();
        var sgst = $("#sgst"+counter).is(":checked");
        var cgst = $("#cgst"+counter).is(":checked");
        console.log(quantity, price, sgst, cgst);
        if(quantity>0 && price>0){
            var final_amt = 0;
            var total = parseInt(quantity) * parseInt(price);
            var total_sgst = sgst? parseInt(total*sgst_val/100) : 0;
            var total_cgst = cgst? parseInt(total*cgst_val/100) : 0;
            var grand_total_row = total + total_sgst + total_cgst;
            $("#total_label"+counter).text(grand_total_row);
            $("#total_label_hidden"+counter).val(grand_total_row);
            
            let t_count =0;
            $.each($(".final_grand_total"), function(){
                final_amt += parseInt($(this).val());
            });
            $("#all_total").text(final_amt);
            $("#all_total_hidden").val(final_amt);
        }
    }

    $(document).ready(function () {
    var counter = <?php echo $count; ?>;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td class="col-sm-1">'+counter+'</td>';
        cols += '<td class="col-sm-4"><input type="text" name="product['+counter+']" class="form-control chk" /></td>';
        cols += '<td class="col-sm-2"><input type="number" onfocusout="showTotal('+counter+')" value="0" id="quantity'+counter+'" name="quantity['+counter+']"  class="form-control chk"/></td>';
        cols += '<td class="col-sm-2"><input type="number" onfocusout="showTotal('+counter+')" value="0" name="price['+counter+']" id="price'+counter+'"  class="form-control chk"/></td>';
        cols += '<td class="col-sm-1"><input type="checkbox" onchange="showTotal('+counter+')" value="6" name="sgst['+counter+']" id="sgst'+counter+'"  checked class="form-control"/></td>';
        cols += '<td class="col-sm-1"><input type="checkbox" onchange="showTotal('+counter+')" value="6" name="cgst['+counter+']" id="cgst'+counter+'"  checked class="form-control"/></td>';
        cols += '<td><label class="form-control" id="total_label'+counter+'">0.00</label><input type="hidden" name="total['+counter+']" class="final_grand_total" id="total_label_hidden'+counter+'"></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();  
        showTotal(1);     
        counter -= 1
    });

    


});
function getUserDetails(){
        let contact = $("#contact").val();
        $.ajax({
        method: "POST",
        url: "./controller/check.user.php",
        data: { contact: contact }
        })
        .done(function( data ) {
            var data = JSON.parse(data);
            console.log(data);
            if(data.status=="success"){
                var user = JSON.parse(data.data);
                $("#email").val(user.email);
                $("#name").val(user.name);
                $("#address").val(user.address);

            }
        });
    }

function validateForm() {
    let check = true;
    $.each($(".chk"), function(){
        console.log($(this).val());
                if($(this).val()==="" || $(this).val()==0){
                    check = false;
                }
            });
    return check;        
}    

</script>
<?php require('./footer.php') ?>
