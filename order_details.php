<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}
?>

<?php
include 'db.php'; // Database connection

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Fetch order and products details, along with the order status
$query = "
    SELECT 
        o.oid AS order_id,
        o.orderstatus AS order_status,
        c.fname AS customer_fname,
        c.lname AS customer_lname,
        oi.oitemid AS order_item_id,
        p.pname AS product_name,
        p.images AS product_image,
        oi.price AS product_price,
        oi.quantity AS product_quantity,
        oi.total_price AS total_price,
        o.created_at AS order_date
    FROM orders o
    INNER JOIN customers c ON o.custid = c.custid
    INNER JOIN order_items oi ON oi.oid = o.oid
    INNER JOIN products p ON oi.pid = p.pid
    WHERE o.oid = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

$order_items = [];
$customer_name = '';
$order_date = '';
$total_order_price = 0;
$order_status = '';

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if (!$customer_name) {
      $customer_name = $row['customer_fname'] . ' ' . $row['customer_lname'];
      $order_date = $row['order_date'];
      $order_status = $row['order_status'];
    }
    $order_items[] = $row;
    $total_order_price += $row['total_price'];
  }
} else {
  echo "<div class='alert alert-danger text-center'>Order not found!</div>";
  include 'layout/footer.php';
  exit;
}
?>

<?php include 'layout/header.php'; ?>

<!-- Page Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mini-nav">
      <li class="breadcrumb-item text-white">Order</li>
      <li class="breadcrumb-item text-white active" aria-current="page">Order Items Details</li>
    </ol>
  </nav>
</div>

<!-- Main Content -->
<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="card bg-default shadow">
        <div class="card-header bg-transparent border-0">
          <h3 class="mb-0 text-white">Order Details</h3>
          <p class="text-white mt-4">Order Date: <?php echo htmlspecialchars($order_date); ?></p>
          <p class="text-white">Customer: <?php echo htmlspecialchars($customer_name); ?></p>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($order_items)): ?>
                <tr>
                  <td colspan="6" class="text-center text-white">No Data Found</td>
                </tr>
              <?php else: ?>
                <?php foreach ($order_items as $item): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>
                      <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="Product Image" width="100"
                        height="100">
                    </td>
                    <td>$<?php echo number_format($item['product_price'], 2); ?></td>
                    <td>
                      <div class="d-flex justify-content-between">
                        <button class="border-none decreaseQtyBtn" data-order-id="<?php echo $order_id; ?>"
                          data-item-id="<?php echo $item['order_item_id']; ?>"
                          data-current-qty="<?php echo $item['product_quantity']; ?>">-</button>
                        <span
                          id="qty-<?php echo $item['order_item_id']; ?>"><?php echo htmlspecialchars($item['product_quantity']); ?></span>
                        <button class="increaseQtyBtn" data-order-id="<?php echo $order_id; ?>"
                          data-item-id="<?php echo $item['order_item_id']; ?>"
                          data-current-qty="<?php echo $item['product_quantity']; ?>">+</button>
                      </div>
                    </td>

                    <td>$<?php echo number_format($item['total_price'], 2); ?></td>
                    <td>
                      <button class="btn btn-danger deleteItemBtn" data-order-id="<?php echo $order_id; ?>"
                        data-item-id="<?php echo $item['order_item_id']; ?>">Delete</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Footer Section with Total Price -->
        <div class="card-footer bg-transparent">
          <div class="d-flex justify-content-between">
            <span class="text-white ml-auto">Total Price: $<?php echo number_format($total_order_price, 2); ?></span>
          </div>

          <!-- Only show the 'Complete Order' button if the order is not completed -->
          <?php if ($order_status != 'completed'): ?>
            <button id="completeOrderBtn" class="btn btn-success mt-2">Complete Order</button>
            <a href="allorder.php" class="btn btn-primary mt-2">Back to All Orders</a>
          <?php else: ?>
            <a href="completeorder.php" class="btn btn-primary mt-2">Back to Completed Orders</a>
          <?php endif; ?>
        </div>
        <div id="message" class="alert" style="display: none;"></div>
      </div>
    </div>
  </div>


<script>
  $(document).on('click', '.deleteItemBtn', function () {
    const orderId = $(this).data('order-id');
    const itemId = $(this).data('item-id');

    if (confirm('Are you sure you want to delete this item?')) {
      $.ajax({
        url: 'delete_order_item.php',
        method: 'POST',
        data: {
          order_id: orderId,
          item_id: itemId
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.success) {

            $('#message').removeClass('alert-danger').addClass('alert-success').text(response.message).fadeIn().delay(3000).fadeOut();
            setTimeout(function () {
              window.location.href = 'allorder.php'; 
            }, 3000);
          } else {

            $('#message').removeClass('alert-success').addClass('alert-danger').text(response.message || 'Failed to delete the item').fadeIn().delay(3000).fadeOut();
          }
        },
        error: function (error) {
          console.error('Error deleting item:', error);
          $('#message').removeClass('alert-success').addClass('alert-danger').text('An error occurred while deleting the item').fadeIn().delay(3000).fadeOut();
        }
      });
    }
  });

  $(document).on('click', '.increaseQtyBtn, .decreaseQtyBtn', function () {
    const orderId = $(this).data('order-id');
    const itemId = $(this).data('item-id');
    let currentQty = parseInt($(this).data('current-qty'));

    if ($(this).hasClass('increaseQtyBtn')) {
      currentQty++;
    } else if ($(this).hasClass('decreaseQtyBtn') && currentQty > 1) {
      currentQty--;
    }

    // Update the displayed quantity
    $('#qty-' + itemId).text(currentQty);

    $.ajax({
      url: 'update_order_item_quantity.php',
      method: 'POST',
      data: {
        order_id: orderId,
        item_id: itemId,
        quantity: currentQty
      },
      success: function (data) {
        const response = JSON.parse(data);
        if (response.success) {
          location.reload(); // Reload to reflect updated quantity
        } else {
          alert('Failed to update the quantity');
        }
      },
      error: function (error) {
        console.error('Error updating quantity:', error);
        alert('An error occurred while updating the quantity');
      }
    });
  });

  $('#completeOrderBtn').on('click', function () {
    if (confirm('Are you sure you want to complete this order?')) {
      const orderId = <?php echo $order_id; ?>;

      $.ajax({
        url: 'complete_order.php',
        method: 'POST',
        data: {
          order_id: orderId
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.success) {
            $('#message').removeClass('alert-danger').addClass('alert-success').text('Order Completed').fadeIn().delay(3000).fadeOut();
            setTimeout(function () {
              window.location.href = 'completeorder.php';
            }, 3000);
          } else {
            alert('Failed to complete the order');
          }
        },
        error: function (error) {
          console.error('Error completing the order:', error);
          alert('An error occurred while completing the order');
        }
      });
    }
  });
</script>

<?php include 'layout/footer.php'; ?>
