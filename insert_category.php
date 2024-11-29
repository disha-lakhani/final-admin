<?php
// Include database connection
include 'db.php';  // Make sure this file connects to your MySQL database

// Retrieve data from the AJAX request
$category_name = $_POST['category_name'];
$category_description = $_POST['category_description'];

// Check if the category already exists
$sql = "SELECT COUNT(*) FROM categories WHERE cname = ?";
$stmt = mysqli_prepare($conn, $sql);

// Check if the query preparation was successful
if ($stmt === false) {
    die('MySQL prepare error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $category_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $categoryCount);
mysqli_stmt_fetch($stmt);

// Close the first statement
mysqli_stmt_close($stmt);

if ($categoryCount > 0) {
    // Category exists
    echo json_encode(['success' => false, 'message' => 'Category already exists.']);
} else {
    // Insert the category into the database
    $insertSql = "INSERT INTO categories (cname, cdes) VALUES (?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertSql);
    
    // Check if the insert query preparation was successful
    if ($insertStmt === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($insertStmt, "ss", $category_name, $category_description);
    
    if (mysqli_stmt_execute($insertStmt)) {
        echo json_encode(['success' => true, 'message' => 'Category added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add category.']);
    }

    // Close the insert statement
    mysqli_stmt_close($insertStmt);
}

// Close the database connection
mysqli_close($conn);
?>
