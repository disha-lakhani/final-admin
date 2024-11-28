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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
    $(document).ready(function () {
    function updateTotalPrice() {
        let grandTotal = 0;
        $('#orderTableBody tr').each(function () {
            grandTotal += parseFloat($(this).find('.totalPrice').text());
        });
        $('#grandTotal').text(grandTotal.toFixed(2));
    }

    // Function to display error messages
    function showMessage(message, type = 'danger') {
        const messageContainer = $('#messageContainer');
        messageContainer.removeClass('alert-danger alert-success').addClass(`alert alert-${type}`);
        messageContainer.text(message);
        messageContainer.show();
        setTimeout(() => {
            messageContainer.hide();
        }, 5000); 
    }


    $('#customer').on('change', function () {
        if ($('#orderTableBody tr').length > 0) {
            showMessage('Please first submit the order before changing the customer.');
            $(this).val($(this).data('previous-value')); 
        } else {
            $(this).data('previous-value', $(this).val()); 
        }
    });

    $('#add-more').click(function () {
    var customerSelected = $('#customer').val();
    var firstProductSelected = $('#orderTableBody tr').length > 0;

    if (!customerSelected) {
        showMessage('Please select a customer first.');
        return; 
    }

    if (!firstProductSelected) {
        showMessage('Please select the first product before adding more.');
        return;
    }

    var newDropdown = $('#product-container select').clone();

    newDropdown.val('');  
    newDropdown.prop('selectedIndex', 0); 

    newDropdown.removeAttr('id'); 

    $('#additional-products').append(newDropdown);
});




    // Event delegation for handling product selection from dynamically added dropdowns
    $(document).on('change', 'select[name="product[]"]', function () {
        var selectedProduct = $(this).val();
        var selectedProductPrice = $(this).find('option:selected').data('price');
        var selectedProductName = $(this).find('option:selected').text();
        var selectedProductImage = $(this).find('option:selected').data('image');

        if (selectedProduct) {
            // Check if the product is already added
            if ($('#orderTableBody').find(`tr[data-product-id="${selectedProduct}"]`).length === 0) {
                var row = `
                    <tr data-product-id="${selectedProduct}">
                        <td>${selectedProductName}</td>
                        <td><img src="${selectedProductImage}" alt="${selectedProductName}" width="100" height="100"></td>
                        <td>${selectedProductPrice}</td>
                        <td class="quantity-container">
                            <button type="button" class="btn btn-secondary btn-sm decreaseQty">-</button>
                            <input type="number" class="form-control quantity" value="1" min="1" readonly>
                            <button type="button" class="btn btn-secondary btn-sm increaseQty">+</button>
                        </td>
                        <td class="totalPrice">${selectedProductPrice}</td>
                        <td><button type="button" class="btn btn-danger removeProduct">Remove</button></td>
                    </tr>
                `;
                $('#orderTableBody').append(row);
                updateTotalPrice();
            } else {
                showMessage('This product is already added.');
            }
        }
    });

    // Handle quantity increase
    $(document).on('click', '.increaseQty', function () {
        var row = $(this).closest('tr');
        var quantity = row.find('.quantity');
        var price = parseFloat(row.find('td:nth-child(3)').text());
        var newQuantity = parseInt(quantity.val()) + 1;
        quantity.val(newQuantity);
        row.find('.totalPrice').text((price * newQuantity).toFixed(2));
        updateTotalPrice();
    });

    // Handle quantity decrease
    $(document).on('click', '.decreaseQty', function () {
        var row = $(this).closest('tr');
        var quantity = row.find('.quantity');
        var price = parseFloat(row.find('td:nth-child(3)').text());
        var newQuantity = Math.max(parseInt(quantity.val()) - 1, 1);
        quantity.val(newQuantity);
        row.find('.totalPrice').text((price * newQuantity).toFixed(2));
        updateTotalPrice();
    });

    // Remove product from the table
    $(document).on('click', '.removeProduct', function () {
        $(this).closest('tr').remove();
        updateTotalPrice();

        // Enable customer dropdown if no products are left
        if ($('#orderTableBody tr').length === 0) {
            $('#customer').prop('disabled', false);
        }
    });
});

  </script>
    <?php include 'layout/footer.php'; ?>