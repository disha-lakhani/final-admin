<?php

include 'layout/header.php'

  ?>



<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mini-nav">
      <li class="breadcrumb-item text-white">Customer</li>
      <li class="breadcrumb-item text-white active" aria-current="page">All Customer</li>
    </ol>
  </nav>
</div>
<div class="container-fluid mt--7">
  <!-- Table -->
   
  <div class="row">
    <div class="col">
      <div class="card bg-default  shadow">
        <div class="card-header bg-transparent border-0">
          <h3 class="mb-0 text-white">Customer tables</h3>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-dark">
              <tr>
              <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Contact</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">City</th>
                <th scope="col">State</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody id="customerTable" class="text-white">
             
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4 bg-default">
          <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0"  id="pagination">
             
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Dark table -->

<script src="js/allcustomer.js"></script>

  <?php
  include 'layout/footer.php';
  ?>