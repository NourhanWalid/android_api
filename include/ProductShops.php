<?php

include('DB_Connect.php');
$conn = mysqli_connect("localhost","root","","android_api");
$stmt = $conn->prepare("SELECT shop_name, product_name, price, special_offers FROM shop_product");

$stmt ->execute();
$stmt -> bind_result($shop_name, $product_name, $price, $special_offers);

$product_shops = array();

while($stmt ->fetch()){

    $temp = array();
	
	$temp['shop_name'] = $shop_name;
	$temp['product_name'] = $product_name;
    $temp['price'] = $price;
    $temp['special_offers'] = $special_offers;

	array_push($product_shops,$temp);
	}

	echo json_encode($product_shops);

?>