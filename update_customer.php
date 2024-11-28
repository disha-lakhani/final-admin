
<?php
require 'db.php';


// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $custid = $_POST['custid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    
    $updateQuery = "
        UPDATE customers 
        SET fname = '$fname',lname='$lname',gender='$gender',contact='$contact',email='$email',address='$address',city='$city',state='$state'  
        WHERE custid = $custid
    ";

   
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['success' => true, 'message' => 'customer updated successfully.']);
    }


} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product. Error: ' . mysqli_error($conn)]);
}

mysqli_close($conn);

?>
