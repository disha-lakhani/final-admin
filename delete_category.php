<?php
require 'db.php';

// Check if 'cid' is provided in POST request
if (isset($_POST['cid']) && is_numeric($_POST['cid'])) {
    $cid = (int)$_POST['cid'];

    // Prepare the DELETE query
    $sql = "DELETE FROM categories WHERE cid = $cid";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete category.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid category ID.']);
}

// Close the connection
mysqli_close($conn);
?>
