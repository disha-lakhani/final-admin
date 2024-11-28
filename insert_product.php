<?php
include 'db.php';

// Get POST data
$pname = $_POST['pname'];
$pdes = $_POST['pdes'];
$price = $_POST['price'];
$category = $_POST['category'];
$stock = $_POST['stock'];

// Check if category exists
$check_category_query = "SELECT * FROM categories WHERE cid = '$category'";
$check_category_result = mysqli_query($conn, $check_category_query);
if (mysqli_num_rows($check_category_result) == 0) {
    echo json_encode(["success" => false, "message" => "Invalid category ID."]);
    exit;
}

// Handle image upload
$uploaded_images = [];
if (!empty($_FILES['images']['name'][0])) {
    $files = $_FILES['images'];
    foreach ($files['name'] as $key => $file_name) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file_name);
        if (move_uploaded_file($files['tmp_name'][$key], $target_file)) {
            $uploaded_images[] = $target_file;
        }
    }
}

if (empty($uploaded_images)) {
    echo json_encode(["success" => false, "message" => "No images uploaded."]);
    exit;
}

$images = implode(',', $uploaded_images); 

// Prepare and execute SQL query
$sql = "INSERT INTO products (pname, pdes, price, cid, stock, images) 
        VALUES ('$pname', '$pdes', '$price', '$category', '$stock', '$images')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error inserting data: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
