<?php

include('DB_Connect.php');
$conn = mysqli_connect("localhost","root","","android_api");

if (isset($_POST['email']) && isset($_POST['shop_name']) && isset($_POST['product_name'])){
    $email=$_POST['email'];
    $shop_name=$_POST['shop_name'];
    $product_name=$_POST['product_name'];
    $s =isSavedShopExisted($email,$shop_name,$product_name);
    if($s){
    $sql= "DELETE FROM save_shop WHERE save_shop.email='$email' AND save_shop.shop_name='$shop_name' AND save_shop.product_name='$product_name'";
    if(mysqli_query($conn,$sql)){
        $pros["error_msg"] = "Saved Shop Deleted Successfully";
        echo json_encode($pros);

    }
    else{
        $pros["error_msg"] = "ERROR: Could not execte1 $sql. " . mysqli_error($conn);
        echo json_encode($pros);
    }

    mysqli_close($conn);
}
}
else{
    $pros["error_msg"] = "ERROR: Could not execte2 ";
    echo json_encode($pros);
}

function isSavedShopExisted($email,$shop_name,$product_name) {

    
    $conn = mysqli_connect("localhost","root","","android_api");
    echo $email;
    echo $shop_name;
    echo $product_name;
    
    
    $stmt = $conn->prepare("SELECT email ,shop_name ,product_name FROM save_shop WHERE email = ?  AND shop_name = ? AND product_name = ?");

    $stmt->bind_param("sss", $email, $shop_name ,$product_name );
    $stmt->execute();

    $stmt->store_result();
    


    if ($stmt->num_rows > 0) {
        // user existed 
        $stmt->close();
        return true;
    } 
    
    else {
        // user not existed
        $stmt->close();
        return false;
    }
    
}




?>




