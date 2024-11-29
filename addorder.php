

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<?php

include 'db.php';

// Fetch customers from the customers table
$customers_query = "SELECT * FROM customers";
$customers_result = mysqli_query($conn, $customers_query);

// Fetch products from the products table
$products_query = "SELECT * FROM products";
$products_result = mysqli_query($conn, $products_query);

?>

<?php include 'layout/header.php'; ?>

<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 mini-nav">
            <li class="breadcrumb-item text-white">Order</li>
            <li class="breadcrumb-item text-white active" aria-current="page">Add Order</li>
        </ol>
    </nav>
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Create Order</h3>
                </div>
                <div class="card-body">
                    <form role="form" id="orderForm">

                        <div class="form-group">
                            <label for="customer">Select Customer</label>
                            <select class="form-control" id="customer" name="customer">
                                <option value="">Select Customer</option>
                                <?php
                                while ($customer = mysqli_fetch_assoc($customers_result)) {
                                    echo "<option value='" . $customer['custid'] . "'>" . $customer['fname'] . " " . $customer['lname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group" id="product-container">
                            <label for="product">Select Product</label>
                            <select class="form-control productSelect" name="product[]">
                                <option value="">Select Product</option>
                                <?php
                                while ($product = mysqli_fetch_assoc($products_result)) {
                                    echo "<option value='" . $product['pid'] . "' data-price='" . $product['price'] . "' data-image='" . $product['images'] . "'>" . $product['pname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <div id="additional-products"></div> -->

                        <div class="form-group">
                            <button type="button" id="add-more" class="btn btn-primary">Add More</button>
                        </div>

                        <div id="messageContainer" style="display: none;" class="alert alert-danger"></div>

                        
                        <table class="table table-bordered" id="orderTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="orderTableBody">
                                <!-- Dynamic product rows will be added here -->
                            </tbody>
                        </table>

                        <!-- Total Price -->
                        <div id="grandTotalContainer" class="text-right mt-5">
                            <strong>Grand Total: <span id="grandTotal">0.00</span></strong>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary mt-4" id="submitOrder">Submit Order</button>
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>

    <script src="js/order.js"></script>

    <?php include 'layout/footer.php'; ?>