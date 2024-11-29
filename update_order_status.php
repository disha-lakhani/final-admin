<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
