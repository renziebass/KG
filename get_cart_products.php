<?php
require('config_app.php');

$transaction_id = $_GET['transaction_id'];
 
$sql="SELECT *
FROM (SELECT
		tb_products.id,
		CONCAT(tb_products.category,' ',tb_products.product_brand,' ',tb_products.mc_brand,' ',tb_products.mc_model) AS specification,
		  tb_products.price
		FROM tb_cart LEFT JOIN tb_products ON tb_cart.product_id=tb_products.id) AS A
JOIN (SELECT
		tb_cart.product_id,
		SUM(tb_cart.quantity) AS quantity,
		SUM(tb_cart.price*tb_cart.quantity) AS total
		FROM tb_cart WHERE tb_cart.transaction_id='$transaction_id'
		GROUP BY tb_cart.product_id) AS B
ON A.id=B.product_id
GROUP BY B.product_id";

$result = mysqli_query($con,$sql);

while(($row = mysqli_fetch_assoc($result)) == true){
	$data[]=$row;
}
echo json_encode($data);
?>