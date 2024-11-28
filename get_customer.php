<?php
include 'db.php';

$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalQuery = "SELECT COUNT(*) AS total FROM customers";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

$query = "SELECT * FROM customers ORDER BY custid DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);


$data = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode([
    'data' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);

mysqli_close($conn);
?>
