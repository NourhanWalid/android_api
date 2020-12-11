<?php

include('DB_Connect.php');
$conn = mysqli_connect("localhost","root","","android_api");
$stmt = $conn->prepare("SELECT name, description, image_url FROM product");

$stmt ->execute();
$stmt -> bind_result($name, $description, $image_url);

$product = array();

while($stmt ->fetch()){

    $temp = array();
	
	$temp['name'] = $name;
	$temp['description'] = $description;
	$temp['image_url'] = $image_url;

	array_push($product,$temp);
	}

	echo json_encode($product);

?>