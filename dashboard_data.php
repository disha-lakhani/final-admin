<?php
require 'db.php'; // Include your database connection file

$response = [];

// Query to get total products
$productQuery = "SELECT COUNT(*) AS total_products FROM products";
$productResult = mysqli_query($conn, $productQuery);
if ($productRow = mysqli_fetch_assoc($productResult)) {
    $response['total_products'] = $productRow['total_products'];
}

// Query to get total categories
$categoryQuery = "SELECT COUNT(*) AS total_categories FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
if ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
    $response['total_categories'] = $categoryRow['total_categories'];
}

// Query to get total customers
$customerQuery = "SELECT COUNT(*) AS total_customers FROM customers";
$customerResult = mysqli_query($conn, $customerQuery);
if ($customerRow = mysqli_fetch_assoc($customerResult)) {
    $response['total_customers'] = $customerRow['total_customers'];
}

// Close connection
mysqli_close($conn);

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
