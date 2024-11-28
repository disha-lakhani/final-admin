<?php
include 'db.php';

$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM products";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch paginated products with category name
$query = "
    SELECT products.pid, products.pname, products.pdes, products.price, products.stock, products.images,categories.cname 
    FROM products 
    JOIN categories ON categories.cid= products.cid
    ORDER BY products.pid DESC 
    LIMIT $limit OFFSET $offset
";
$result = mysqli_query($conn, $query);

$data = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

// Return data as JSON
echo json_encode([
    'data' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);

mysqli_close($conn);
?>