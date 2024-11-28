<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pid = isset($_POST['pid']) ? (int) $_POST['pid'] : 0;
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $pdes = mysqli_real_escape_string($conn, $_POST['pdes']);
    $price = (float) $_POST['price'];
    $category = (int) $_POST['category'];
    $stock = (int) $_POST['stock'];

    
    $updateQuery = "
        UPDATE products 
        SET pname = '$pname', pdes = '$pdes', price = '$price', cid = '$category', stock = '$stock' 
        WHERE pid = $pid
    ";

    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
    }


} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product. Error: ' . mysqli_error($conn)]);
}

mysqli_close($conn);

?>