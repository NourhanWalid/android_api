<?php


include('DB_Connect.php');
$conn = mysqli_connect("localhost","root","","android_api");

// json response array
$response = array("error" => FALSE);

if (isset($_POST['email']) && isset($_POST['shop_name']) && isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['special_offers'])) {
 
    // receiving the post params
    $email = $_POST['email'];
    $shop_name = $_POST['shop_name'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    number_format($price);
    $special_offers= $_POST['special_offers'];
 
    // check if user is already existed with the same email
    if (isSavedShopExisted($email,$shop_name,$product_name)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "This shop is already saved " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $shop = saveShop($email, $shop_name, $product_name, $price, $special_offers);
        if ($shop) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["shop"]["email"] = $shop["email"];
            $response["shop"]["shop_name"] = $shop["shop_name"];
            $response["shop"]["product_name"] = $shop["product_name"];
            $response["shop"]["price"] = $shop["price"];
            $response["shop"]["special_offers"] = $shop["special_offers"];

            echo json_encode($response);
        } 
        
        else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }


    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
    echo json_encode($response);
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

 function saveShop($email, $shop_name , $product_name , $price , $special_offers) {
    
    
    $conn = mysqli_connect("localhost","root","","android_api");
    
    $uuid = uniqid('', true);
    $stmt = $conn->prepare("INSERT INTO save_shop(email, shop_name,product_name,price,special_offers) VALUES(?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $email, $shop_name,$product_name,$price,$special_offers);
    $result = $stmt->execute();
    $stmt->close();

    // check for successful store
    if ($result) {
        $stmt = $conn->prepare("SELECT * FROM save_shop WHERE email = ? AND shop_name=? AND product_name=?");
        $stmt->bind_param("sss", $email, $shop_name,$product_name);
        $stmt->execute();
        $shop = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $shop;
        
        
    } else {
        return false ;
    }

   
}

?>