<?php

include('DB_Connect.php');
$conn = mysqli_connect("localhost","root","","android_api");
$stmt = $conn->prepare("SELECT name, latitude, longitude FROM shop");

$stmt ->execute();
$stmt -> bind_result($name, $latitude, $longitude);

$shop = array();

while($stmt ->fetch()){

    $temp = array();
	
	$temp['name'] = $name;
	$temp['latitude'] = $latitude;
	$temp['longitude'] = $longitude;

	array_push($shop,$temp);
	}

	echo json_encode($shop);

?>