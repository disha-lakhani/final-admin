<?php
require 'db.php';

if (isset($_POST['custid']) && is_numeric($_POST['custid'])) {
    $custid = (int)$_POST['custid'];

    $sql = "DELETE FROM customers WHERE custid = $custid";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'customer deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete customer.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid customer ID.']);
}

mysqli_close($conn);
?>
