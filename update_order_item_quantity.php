<?php
include 'db.php'; // Database connection

// Check if the required parameters are provided
if (isset($_POST['order_id'], $_POST['item_id'], $_POST['quantity'])) {
    $order_id = intval($_POST['order_id']);
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch the product price from the database to recalculate the total price
    $query = "
        SELECT oi.price AS product_price
        FROM order_items oi
        WHERE oi.oitemid = ? AND oi.oid = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $item_id, $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $product_price = $row['product_price'];

        // Recalculate the total price for this item
        $total_price = $product_price * $quantity;

        // Update the quantity and total price in the database
        $update_query = "
            UPDATE order_items
            SET quantity = ?, total_price = ?
            WHERE oitemid = ? AND oid = ?
        ";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('idii', $quantity, $total_price, $item_id, $order_id);
        $update_stmt->execute();

        // Check if the update was successful
        if ($update_stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the quantity']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
}
?>
