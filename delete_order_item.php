<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['order_id']) && isset($_POST['item_id'])) {
    $order_id = $_POST['order_id'];
    $item_id = $_POST['item_id'];

    // Step 1: Delete the item from the order_items table
    $stmt = $conn->prepare("DELETE FROM order_items WHERE oitemid = ? AND oid = ?");
    $stmt->bind_param('ii', $item_id, $order_id);

    if ($stmt->execute()) {
        // Step 2: Check if the order is now empty
        $checkOrder = $conn->prepare("SELECT COUNT(*) AS item_count FROM order_items WHERE oid = ?");
        $checkOrder->bind_param('i', $order_id);
        $checkOrder->execute();
        $result = $checkOrder->get_result();
        $row = $result->fetch_assoc();

        if ($row['item_count'] == 0) {
            // Step 3: Delete the order from orders table
            $deleteOrder = $conn->prepare("DELETE FROM orders WHERE oid = ?");
            $deleteOrder->bind_param('i', $order_id);
            $deleteOrder->execute();

            // Step 4: Optionally, delete the customer (if required)
            // Make sure this is correct based on your database structure and use case
            $deleteCustomer = $conn->prepare("DELETE FROM customers WHERE custid = (SELECT custid FROM orders WHERE oid = ?)");
            $deleteCustomer->bind_param('i', $order_id);
            $deleteCustomer->execute();

            echo json_encode(['success' => true, 'message' => 'Item and order deleted successfully']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete item']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>
