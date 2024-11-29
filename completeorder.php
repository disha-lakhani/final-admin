<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Include your database connection file

// Get the current page from the GET parameter, or set default to 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 5; // Number of orders per page
$offset = ($page - 1) * $limit; // Calculate the offset for SQL query

// Fetch completed orders with customer names, with pagination
$query = "
    SELECT o.oid, o.custid, o.created_at, o.orderstatus, c.fname AS customer_name
    FROM orders o
    JOIN customers c ON o.custid = c.custid
    WHERE o.orderstatus = 'completed'
    ORDER BY o.created_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $limit, $offset);  // Bind limit and offset to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if the query executed successfully
if (!$result) {
    die("Database query failed: " . $conn->error);
}

// Store all results in an array to avoid reusing `$result` later
$orders = $result->fetch_all(MYSQLI_ASSOC);

// Get the total number of completed orders to calculate the total pages
$query_total = "SELECT COUNT(*) AS total_orders FROM orders WHERE orderstatus = 'completed'";
$result_total = $conn->query($query_total);
$total_orders = $result_total->fetch_assoc()['total_orders'];
$total_pages = ceil($total_orders / $limit); // Calculate total pages
?>

<?php include 'layout/header.php'; ?>

<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 mini-nav">
            <li class="breadcrumb-item text-white">Order</li>
            <li class="breadcrumb-item text-white active" aria-current="page">Completed Order</li>
        </ol>
    </nav>
</div>

<div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card bg-default shadow">
                <div class="card-header bg-transparent border-0">
                    <h3 class="mb-0 text-white">Order tables</h3>
                </div>
                <div class="table-responsive">
                    <?php if (count($orders) > 0): ?>
                        <table class="table align-items-center table-flush">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-white">
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order['oid']); ?></td>
                                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                        <td>
                                            <span class="btn btn-success">Completed</span>
                                        </td>
                                        <td>
                                            <a href="order_details.php?order_id=<?php echo $order['oid']; ?>"
                                                class="btn btn-info">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center text-white">No completed orders found.</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer py-4 bg-default">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            <!-- Previous Button -->
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
