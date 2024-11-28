<?php

include 'db.php';

$categoryName = $_POST['category_name'];
$categoryDescription = $_POST['category_description'];

if (empty($categoryName) || empty($categoryDescription)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

$sql = "INSERT INTO categories (cname, cdes) VALUES ('$categoryName', '$categoryDescription')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Category added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error inserting data: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
