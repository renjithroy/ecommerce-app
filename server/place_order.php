<?php

session_start(); // we use session in this

include('connection.php'); // need access to database

//if user is not logged in
if(!isset($_SESSION['logged_in'])){
    header('location: ../checkout.php?message=Please login/register to place an order');
    exit;
    
}else{

    if(isset($_POST['place_order'])) { //if user clicked the place order button
    
        //1. get user info from checkout page to store in orders table
        $name = $_POST['name'];
        $email = $_POST['email']; 
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];

        $order_cost = $_SESSION['total'];
        $order_status = "not paid"; // order placed but not paid
        $user_id = $_SESSION['user_id'];
        $order_date = date('Y-m-d');

        //2. issue new order and store order info in database

        $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_name, user_email, user_phone, user_city, user_address, order_date) VALUES (?,?,?,?,?,?,?,?,?)"); 

        $stmt->bind_param("isississs",$order_cost, $order_status, $user_id, $name, $email, $phone, $city, $address, $order_date);

        $stmt_status = $stmt->execute();

        if(!$stmt_status){
            header('location: ../index.php');
            exit;
        }
        
        $order_id = $stmt->insert_id; // returns the new order id
        
        //3. get products from cart (from session)
        

        foreach($_SESSION['cart'] as $key => $value){     // [ 4=>[prodcut price,name,etc] ] 4 is the product id

            $product = $_SESSION['cart'][$key]; // [] all/each products in cart stored in $product

            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];
            $product_size = $product['product_size'];

            
        //4. store each single item in order_items table 

            //inserting into order_items table

            $stmt1 = $conn->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date,product_size)
                                            VALUES (?,?,?,?,?,?,?,?,?)");

            $stmt1->bind_param('iissiiiss',$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$user_id,$order_date,$product_size);                  

            $stmt1->execute();

            // order_id will be same for multiple product orders. 
            // order_id represents a person

        }     


        $_SESSION['order_id'] = $order_id;

        //6. inform user whether everything is fine (then take them to payment page) or there is a problem.
        header('location: ../payment.php?order_status=order placed successfully');

    }

}
?>