<?php
include 'db.php';

$customer_id = $_POST['customer_id'];
$products = json_decode($_POST['products'], true);
$total_price = $_POST['total_price'];

// Insert the order into the 'orders' table
$order_query = "INSERT INTO orders (custid, orderstatus, created_at) VALUES ('$customer_id', 'Pending', NOW())";
$order_result = mysqli_query($conn, $order_query);

if ($order_result) {
    $order_id = mysqli_insert_id($conn); // Get the last inserted order ID
    
    // Insert order items into the 'order_items' table
    foreach ($products as $product) {
        $product_id = $product['product_id'];
        $quantity = $product['quantity'];
        $price = $product['price'];
        $total_product_price = $product['total_price'];
        
        $order_product_query = "INSERT INTO order_items (oid, pid, quantity, price, total_price) 
                                VALUES ('$order_id', '$product_id', '$quantity', '$price', '$total_product_price')";
        mysqli_query($conn, $order_product_query);
    }
    
    // Return success response
    echo json_encode(['success' => true]);
} else {
    // Return error response
    echo json_encode(['success' => false]);
}

mysqli_close($conn); // Close the database connection
?>
