<?php
require 'db.php';

// Check if 'pid' is provided in POST request
if (isset($_POST['pid']) && is_numeric($_POST['pid'])) {
    $pid = (int)$_POST['pid'];  // Product ID to delete

    // Prepare the DELETE query
    $sql = "DELETE FROM products WHERE pid = $pid";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete product.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
}

// Close the connection
mysqli_close($conn);
?>
