<?php

include('DB_Connect.php');
$conn = mysqli_connect("localhost","root","","android_api");
$stmt = $conn->prepare("SELECT email, shop_name, product_name, price, special_offers FROM save_shop");

$stmt ->execute();
$stmt -> bind_result($email, $shop_name, $product_name, $price, $special_offers);

$saved_shops = array();

while($stmt ->fetch()){

    $temp = array();
	
	$temp['email'] = $email;
	$temp['shop_name'] = $shop_name;
	$temp['product_name'] = $product_name;
	$temp['price'] = $price;
	$temp['special_offers'] = $special_offers;


   

	array_push($saved_shops,$temp);
	}

	echo json_encode($saved_shops);

?>