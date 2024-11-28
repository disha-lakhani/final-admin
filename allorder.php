<?php

include 'layout/header.php'

  ?>



<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mini-nav">
      <li class="breadcrumb-item text-white">Order</li>
      <li class="breadcrumb-item text-white active" aria-current="page">All Order</li>
    </ol>
  </nav>
</div>
<div class="container-fluid mt--7">
  <!-- Table -->
  <div class="row">
    <div class="col">
      <div class="card bg-default  shadow">
        <div class="card-header bg-transparent border-0">
          <h3 class="mb-0 text-white">Order tables</h3>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Customer Name</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Image</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody class="text-white" id="orderTableBody">
             
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4 bg-default">
          <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">
                  <i class="fas fa-angle-left"></i>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="#">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
              </li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#">
                  <i class="fas fa-angle-right"></i>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Dark table -->


<script>
  $(document).ready(function () {
    // Fetch and display orders
    function fetchOrders() {
        $.ajax({
            url: 'fetch_order.php', // Endpoint to fetch orders
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    let orderHtml = '';
                    response.data.forEach(order => {
                        orderHtml += `
                            <tr>
                                <td>${order.customer_name}</td>
                                <td>${order.product_name}</td>
                                <td><img src="${order.product_image}" alt="${order.product_name}" width="100" height="100"></td>
                                <td>${parseFloat(order.product_price).toFixed(2)}</td>
                                <td>${order.quantity}</td>
                                <td>${parseFloat(order.total_price).toFixed(2)}</td>
                                <td>
                                    <button class="btn btn-success editOrder" data-id="${order.order_id}">Edit</button>
                                    <button class="btn btn-danger deleteOrder" data-id="${order.order_id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#orderTableBody').html(orderHtml);
                } else {
                    $('#orderTableBody').html('<tr><td colspan="7" class="text-center">No orders found.</td></tr>');
                }
            },
            error: function () {
                alert('Failed to fetch orders.');
            }
        });
    }

    // Fetch orders on page load
    fetchOrders();
});

</script>
  <?php
  include 'layout/footer.php';
  ?>