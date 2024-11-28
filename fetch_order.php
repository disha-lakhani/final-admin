<?php
// fetch_orders.php
include 'db_connection.php';

$response = ['success' => false, 'data' => []];

$query = "
    SELECT 
        o.id AS order_id,
        c.name AS customer_name,
        p.name AS product_name,
        p.image AS product_image,
        op.price AS product_price,
        op.quantity,
        op.total_price
    FROM orders o
    JOIN customers c ON o.customer_id = c.id
    JOIN order_products op ON o.id = op.order_id
    JOIN products p ON op.product_id = p.id
    ORDER BY o.created_at DESC
";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $response['success'] = true;
    $response['data'] = $orders;
}

echo json_encode($response);
?>
