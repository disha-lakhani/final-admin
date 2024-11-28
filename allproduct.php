<?php

include 'layout/header.php'

  ?>



<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mini-nav">
      <li class="breadcrumb-item text-white">Product</li>
      <li class="breadcrumb-item text-white active" aria-current="page">All Product</li>
    </ol>
  </nav>
</div>
<div class="container-fluid mt--7">
  <!-- Table -->
   
  <div class="row">
    <div class="col">
      <div class="card bg-default  shadow">
        <div class="card-header bg-transparent border-0">
          <h3 class="mb-0 text-white">All Products</h3>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-dark">
              <tr>
                <th>S.No</th>
                <th>Product Name</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Images</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="productTable" class="text-white">

            </tbody>
          </table>
        </div>
        <div class="card-footer bg-default py-4">
          <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0" id="pagination">

            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Dark table -->





<script src="js/allproduct.js"></script>


  <?php
  include 'layout/footer.php';
  ?>