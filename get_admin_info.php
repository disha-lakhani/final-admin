<?php
session_start();
require 'db.php'; 
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']); 

    
    $query = "
        SELECT user_info.name, user_info.profileimage 
        FROM user_info 
        INNER JOIN users ON users.id = user_info.user_id 
        WHERE user_info.user_id = $user_id
    ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $profileimage = $row['profileimage'] ? $row['profileimage'] : 'default.png';

            echo json_encode([
                'success' => true,
                'name' => $row['name'],
                'profileimage' => "uploads/$profileimage" 
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No admin details found.']);
        }

        mysqli_free_result($result);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to execute query: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
}

mysqli_close($conn);
?>
