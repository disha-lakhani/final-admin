
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<?php

require 'db.php';

if (isset($_GET['custid'])) {
    $custid = (int) $_GET['custid'];

    // Fetch the product data for the given pid
    $query = "SELECT * FROM customers WHERE custid = $custid";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => false, 'message' => 'ID not found or invalid.']);
        } else {
            echo "ID not found or invalid.";
        }
        exit();
    }

    $customer = mysqli_fetch_assoc($result);
}

?>





<?php

include 'layout/header.php';

?>


<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 mini-nav">
            <li class="breadcrumb-item text-white">Customer</li>
            <li class="breadcrumb-item text-white active" aria-current="page">Edit Customer</li>
        </ol>
    </nav>
</div>
<div class="container-fluid mt--7">

    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">EDIT CUSTOMERS</h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="card bg-secondary shadow border-0 card-margin">
                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Edit Customer</small>
                                    </div>
                                    <div class="form-container border shadow-lg p-4 rounded">
                                        <form role="form" id="addCustomerForm">
                                        <input type="hidden" name="custid" id="custid" value="<?php echo $customer['custid']; ?>">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                                    </div>
                                                    <input class="form-control" name="fname" id="fname" value="<?php echo isset($customer['fname']) ? $customer['fname'] : ''; ?>" placeholder="First Name" type="text">
                                                </div>
                                                <span id="demo1" style="color: red;">Please enter first Name</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                                    </div>
                                                    <input class="form-control" name="lname" id="lname"  value="<?php echo isset($customer['lname']) ? $customer['lname'] : ''; ?>" placeholder="Last Name" type="text">
                                                </div>
                                                <span id="demo2" style="color: red;">Please enter last Name</span>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label class="form-control-label d-block">Gender:</label>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="male" name="gender" value="Male"
                                                        class="custom-control-input" <?php echo (isset($customer['gender']) && $customer['gender'] == 'Male') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="male">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="female" name="gender"value="Female"
                                                        class="custom-control-input"  <?php echo (isset($customer['gender']) && $customer['gender'] == 'Female') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="female">Female</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="other" name="gender"value="Other"
                                                        class="custom-control-input"  <?php echo (isset($customer['gender']) && $customer['gender'] == 'Other') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="other">Other</label>
                                                </div>
                                               
                                            </div>
                                            <span id="demo3" style="color: red;">Please select gender</span>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-mobile"></i></span>
                                                    </div>
                                                    <input class="form-control" name="contact" id="contact" value="<?php echo isset($customer['contact']) ? $customer['contact'] : ''; ?>" placeholder="Contact No:" type="tel">
                                                </div>
                                                <span id="demo4" style="color: red;">Please enter contact number</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                                    </div>
                                                    <input class="form-control" id="email" name="email"  value="<?php echo isset($customer['email']) ? $customer['email'] : ''; ?>" placeholder="Email" type="email">
                                                </div>
                                                <span id="demo5" style="color: red;">Please enter email</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                                                    </div>
                                                    <textarea class="form-control" id="address" name="address" placeholder="Address"
                                                        rows="3"><?php echo isset($customer['address']) ? $customer['address'] : ''; ?></textarea>
                                                </div>
                                                <span id="demo6" style="color: red;">Please enter address</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                        <i class="fa-solid fa-city"></i></span>
                                                    </div>
                                                    <select class="form-control" name="city" id="city">
                                                        <option value="">Select City</option>
                                                        <option value="Surat" <?php echo (isset($customer['city']) && $customer['city'] == 'Surat') ? 'selected' : ''; ?>>Surat</option>
                                                        <option value="Mumbai" <?php echo (isset($customer['city']) && $customer['city'] == 'Mumbai') ? 'selected' : ''; ?>>Mumbai</option>
                                                        <option value="Udaipur" <?php echo (isset($customer['city']) && $customer['city'] == 'Udaipur') ? 'selected' : ''; ?>>Udaipur</option>
                                                        <option value="Baroda" <?php echo (isset($customer['city']) && $customer['city'] == 'Baroda') ? 'selected' : ''; ?>>Baroda</option>
                                                        <option value="Pune" <?php echo (isset($customer['city']) && $customer['city'] == 'Pune') ? 'selected' : ''; ?>>Pune</option>
                                                    </select>
                                                </div>
                                                <span id="demo7" style="color: red;">Please select city</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-building-flag"></i></span>
                                                    </div>
                                                    <select class="form-control" name="state" id="state">
                                                        <option value="">Select State</option>
                                                        <option value="Gujarat" <?php echo (isset($customer['state']) && $customer['state'] == 'Gujarat') ? 'selected' : ''; ?>>Gujarat</option>
                                                        <option value="Maharashtra" <?php echo (isset($customer['state']) && $customer['state'] == 'Maharashtra') ? 'selected' : ''; ?>>Maharashtra</option>
                                                        <option value="Rajsthan" <?php echo (isset($customer['state']) && $customer['state'] == 'Rajsthan') ? 'selected' : ''; ?>>Rajsthan</option>
                                                       
                                                    </select>
                                                </div>
                                                <span id="demo8" style="color: red;">Please select state</span>
                                            </div>

                                            <!-- City Dropdown -->
                                            
                                            <div class="text-center">
                                                <button type="submit" id="edit" class="btn btn-primary mt-4">Edit Customer</button>
                                            </div>
                                        </form>
                                        <p id="errorMsg"></p>
                                        <div id="message" class="mt-3"></div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="js/editcustomer.js"></script>




    <?php

    include 'layout/footer.php';

    ?>