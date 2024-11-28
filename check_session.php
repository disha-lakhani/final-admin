<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
}
?>
