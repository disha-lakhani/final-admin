<?php
include 'db.php';

header('Content-Type: application/json'); 

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            session_start();
            $_SESSION['user_id'] = $user['id']; 
            
            echo json_encode(['success' => true, 'message' => 'Login successful', 'redirect' => 'dashboard.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not registered']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
}

mysqli_close($conn);
?>
