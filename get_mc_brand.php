<?php 

define('HOST','localhost');
define('USER','u186319490_admin123');
define('PASS','Kg9182022');
define('DB','u186319490_kg_db');

$con = mysqli_connect(HOST,USER,PASS,DB);

$sql = "SELECT * FROM tb_mc_brand";

$con = mysqli_query($con,$sql);

$result = array();

while($row = mysqli_fetch_array($con)){
    array_push($result,array(
        'brand'=>$row['brand']
    ));
}

echo json_encode(array('result'=>$result));
?>