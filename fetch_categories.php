<?php
include 'db.php';

// Query to fetch categories
$sql = "SELECT cid, cname FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['cid'] . "'>" . $row['cname'] . "</option>";
    }
} else {
    echo "<option value=''>No categories available</option>";
}

$conn->close();
?>
