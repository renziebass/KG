<?php
require('config_app.php');

$DateNow = $_GET['datenow'];
 
$sql = "SELECT
CONCAT(FORMAT(SUM(tb_cart.price*tb_cart.quantity), 2)) AS income_today,
(SELECT COUNT(tb_payments.id)
FROM tb_payments WHERE tb_payments.date='$DateNow') AS customers,
SUM(tb_cart.quantity) AS items
FROM tb_payments
JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE tb_payments.date='$DateNow'";

 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
array_push($result,
array('income_today'=>$row[0]),
array('customers'=>$row[1]),
array('items'=>$row[2]));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>