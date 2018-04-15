<?php require('./header.php') ?>
<?php
$query = "SELECT i.invoice_id,i.purches_date,i.total_after_tax,i.saler_id,u.user_id,u.name,u.contact,u.role,us.name as saler FROM `invoice` i inner join user u on i.user_id = u.user_id inner join user us on i.saler_id = us.user_id where i.status='active' order by i.created_at desc";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>
<div class="alert alert-info col-md-12">
<span class="col-md-9"> >> Invoice List </span>
<a href="./create.invoice.php"><span class="col-md-3">  Create Invoice</span></a>
</div>
<table id="invoice_table" class="display text-center" cellspacing="0" width="100%" >
<thead>
<th>Sr.No.</th>
<th>Invoince Id</th>
<th>Purches Date</th>
<th>Total Amt.</th>
<th>Saler</th>
<th>Customer</th>
<th>Contact</th>
<th>Type</th>
<th>View</th>
<th>Update</th>
<th>Delete</th>
</thead>
<tbody>
<?php
$count = 0;
foreach ($result as &$value) {
    $count++;
    echo "<tr>";
    echo"<td>$count</td>";
    echo"<td>AKM".$value["invoice_id"]."</td>";
    echo"<td>".$value["purches_date"]."</td>";
    echo"<td>".$value["total_after_tax"]."</td>";
    echo"<td>".$value["saler"]."</td>";
    echo"<td>".$value["name"]."</td>";
    echo"<td>".$value["contact"]."</td>";
    echo"<td>".$value["role"]."</td>";
    echo"<td><a href='./view.invoice.php?id=".base64_encode($value["invoice_id"])."'>View</a></td>";
    echo"<td><a href='./update.invoice.php?id=".base64_encode($value["invoice_id"])."'>Update</a></td>";
    echo"<td><a href='./controller/delete.invoice.do.php?id=".base64_encode($value["invoice_id"])."'>Delete</a></td>";
    echo "</tr>";
}
?>
</tbody>
</table>

<?php require('./footer.php') ?>