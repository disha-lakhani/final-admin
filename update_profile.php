<?php
session_start();
require 'db.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Fetch form data
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $new_contact = trim($_POST['contact']);
    $new_gender = trim($_POST['gender']);
    $new_dob = trim($_POST['dob']);

    // Validation
    if (empty($new_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Name is required.']);
        exit;
    }
    if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }
    if (empty($new_contact)) {
        echo json_encode(['status' => 'error', 'message' => 'Contact is required.']);
        exit;
    }
    if (empty($new_gender)) {
        echo json_encode(['status' => 'error', 'message' => 'Gender is required.']);
        exit;
    }
    if (empty($new_dob)) {
        echo json_encode(['status' => 'error', 'message' => 'Date of birth is required.']);
        exit;
    }

    // Handle profile image upload
    $image_name = null;
    if (!empty($_FILES['profileimage']['name'])) {
        $profileimage = $_FILES['profileimage'];
        $image_name = time() . '-' . basename($profileimage['name']);
        $target_path = "uploads/" . $image_name;

        // Validate file type (JPG, JPEG, PNG)
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($profileimage['type'], $allowed_types)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image type. Only JPG, JPEG, and PNG are allowed.']);
            exit;
        }

        // Validate file size (max 2MB)
        $max_size = 2 * 1024 * 1024; // 2MB
        if ($profileimage['size'] > $max_size) {
            echo json_encode(['status' => 'error', 'message' => 'Image size exceeds the maximum limit of 2MB.']);
            exit;
        }

        // Try to upload the image
        if (!move_uploaded_file($profileimage['tmp_name'], $target_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading image.']);
            exit;
        }
    }

    if ($image_name) {
        // Update with profile image
        $query = "UPDATE user_info SET name = ?, profileimage = ?, gender = ?, contact = ?, dob = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssssi', $new_name, $image_name, $new_gender, $new_contact, $new_dob, $user_id);
    } else {
        $query = "UPDATE user_info SET name = ?, gender = ?, contact = ?, dob = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $new_name, $new_gender, $new_contact, $new_dob, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating profile.']);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
