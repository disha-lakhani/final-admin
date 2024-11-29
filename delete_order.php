<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['order_id']) && is_numeric($_POST['order_id'])) {
        $order_id = (int)$_POST['order_id'];

        // Log incoming data
        file_put_contents('debug.log', "Processing order_id: $order_id\n", FILE_APPEND);

        mysqli_begin_transaction($conn);

        try {
            // Verify order exists
            // $sql_check = "SELECT * FROM orders WHERE oid = $order_id";
            // $result = mysqli_query($conn, $sql_check);
            
            // if (mysqli_num_rows($result) === 0) {
            //     throw new Exception("Order ID $order_id does not exist.");
            // }

            // Delete items associated with the order
            $sql_delete_items = "DELETE FROM order_items WHERE `oitemid` = $order_id"; // Adjust to match your column name
            if (!mysqli_query($conn, $sql_delete_items)) {
                throw new Exception("Error deleting from order_items: " . mysqli_error($conn));
            }

            // Delete the order
            $sql_delete_order = "DELETE FROM orders WHERE oid = $order_id";
            if (!mysqli_query($conn, $sql_delete_order)) {
                throw new Exception("Error deleting from orders: " . mysqli_error($conn));
            }

            // Commit the transaction
            mysqli_commit($conn);

            echo json_encode(['success' => true, 'message' => 'Order and associated items deleted successfully.']);

        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($conn);
            file_put_contents('debug.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid order ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

// Close the database connection
mysqli_close($conn);
?>
