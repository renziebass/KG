<?php
  define('HOST','https://auth-db445.hstgr.io/');
  define('USER','u186319490_admin123');
  define('PASS','Kg9182022');
  define('DB','u186319490_kg_db');


$con = mysqli_connect(HOST,USER,PASS,DB);

$except= $_GET['except'];
 
$sql="SELECT *
FROM (SELECT
      tb_payments.id,
		tb_payments.date,
		COUNT(tb_payments.id) AS customers,
      SUM(tb_payments.total) AS amount
		FROM tb_payments
      WHERE tb_payments.date NOT IN (
      SELECT tb_payments.date FROM tb_payments WHERE tb_payments.date='$except')
     GROUP BY tb_payments.date) AS A
JOIN (SELECT
      tb_cart.transaction_id,
		COUNT(tb_cart.product_id) as items
		FROM tb_cart
		GROUP BY tb_cart.product_id) AS B
ON A.id=B.transaction_id
GROUP BY A.date";

$result = mysqli_query($con,$sql);

while(($row = mysqli_fetch_assoc($result)) == true){
	$data[]=$row;
}
echo json_encode($data);
?>