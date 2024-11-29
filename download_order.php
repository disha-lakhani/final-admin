<?php
include 'db.php';

$order_id = $_GET['order_id'];

// Fetch order details
$query = "
  SELECT 
    oi.*, p.pname, CONCAT(c.fname, ' ', c.lname) AS customer_name
  FROM order_items oi
  INNER JOIN orders o ON oi.oid = o.oid
  INNER JOIN customers c ON o.custid = c.custid
  INNER JOIN products p ON oi.pid = p.pid
  WHERE oi.oitemid = $order_id
";
$result = $conn->query($query);
$order = $result->fetch_assoc();

if ($order) {
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="order_' . $order_id . '.csv"');

  $output = fopen('php://output', 'w');
  fputcsv($output, array_keys($order)); // Headers
  fputcsv($output, $order); // Data
  fclose($output);
} else {
  echo 'Order not found';
}
?>
