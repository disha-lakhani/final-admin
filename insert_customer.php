<?php
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];

    if (empty($fname) || empty($lname) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        exit;
    }
    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid gender value!']);
        exit;
    }

    $check_email_sql = "SELECT * FROM customers WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
        exit;
    }

    $sql = "INSERT INTO customers (fname, lname, gender, contact, email, address, city, state) 
            VALUES ('$fname', '$lname', '$gender', '$contact', '$email', '$address', '$city', '$state')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Customer added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
