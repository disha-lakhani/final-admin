<?php
include 'db.php'; // Include your database connection

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$query = "
    SELECT o.oid AS order_id, 
           c.fname AS customer_name, 
           c.lname AS customer_lname,
           COUNT(oi.oitemid) AS product_count,
           SUM(oi.total_price) AS total_price, 
           o.created_at AS order_date
    FROM orders o
    INNER JOIN customers c ON o.custid = c.custid
    INNER JOIN order_items oi ON oi.oid = o.oid
    GROUP BY o.oid, c.fname, c.lname, o.created_at
    ORDER BY o.created_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Debug: Check the query result
if (empty($orders)) {
    echo "No orders found in the database.";
}

$query_total = "SELECT COUNT(*) AS total_orders FROM orders";
$result_total = $conn->query($query_total);
$total_orders = $result_total->fetch_assoc()['total_orders'];
$total_pages = ceil($total_orders / $limit);

echo json_encode(['orders' => $orders, 'total_pages' => $total_pages]);
?>
