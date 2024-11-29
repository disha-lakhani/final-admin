<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (!isset($_POST['customerId']) || !isset($_POST['orderItems'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required POST data']);
        exit;
    }

    $customerId = $_POST['customerId'];
    $orderItems = $_POST['orderItems'];


    mysqli_autocommit($conn, false);
    $isSuccessful = true;
    $errorMessage = '';


    $orderQuery = "INSERT INTO orders (custid, orderstatus) VALUES ('$customerId', 'Pending')";
    if (mysqli_query($conn, $orderQuery)) {
        $orderId = mysqli_insert_id($conn);
    } else {
        $isSuccessful = false;
        $errorMessage = 'Error inserting order: ' . mysqli_error($conn);
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
        exit;
    }

    if ($isSuccessful) {
        foreach ($orderItems as $item) {
            $productId = $item['productId'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalPrice = $item['totalPrice'];


            $productQuery = "SELECT images FROM products WHERE pid = '$productId'";
            $productResult = mysqli_query($conn, $productQuery);
            if ($productResult && $product = mysqli_fetch_assoc($productResult)) {
                $image = $product['images'];


                $itemQuery = "INSERT INTO order_items (oid, pid, quantity, price, total_price, images) 
                              VALUES ('$orderId', '$productId', '$quantity', '$price', '$totalPrice', '$image')";
                if (!mysqli_query($conn, $itemQuery)) {
                    $isSuccessful = false;
                    $errorMessage = 'Error inserting order item: ' . mysqli_error($conn);
                    break;
                }
            } else {
                $isSuccessful = false;
                $errorMessage = 'Error retrieving product image: ' . mysqli_error($conn);
                break;
            }
        }
    }

    if ($isSuccessful) {
        mysqli_commit($conn);
        echo json_encode(['status' => 'success', 'message' => 'Data added successfully']);
    } else {

        mysqli_rollback($conn);
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>
