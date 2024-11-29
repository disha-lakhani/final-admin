<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>


<?php

require 'db.php';

if (isset($_GET['pid'])) {
    $pid = (int) $_GET['pid'];

    // Fetch the product data for the given pid
    $query = "SELECT * FROM products WHERE pid = $pid";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => false, 'message' => 'ID not found or invalid.']);
        } else {
            echo "ID not found or invalid.";
        }
        exit();
    }

    $product = mysqli_fetch_assoc($result);
}

$categoryQuery = "SELECT * FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = [];
if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
    while ($category = mysqli_fetch_assoc($categoryResult)) {
        $categories[] = $category;
    }
}
?>





<?php

include 'layout/header.php';

?>


<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 mini-nav">
            <li class="breadcrumb-item text-white">Product</li>
            <li class="breadcrumb-item text-white active" aria-current="page">Edit Product</li>
        </ol>
    </nav>
</div>
<div class="container-fluid mt--7">

    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow ">
                <div class="card-header border-0">
                    <h3 class="mb-0">EDIT PRODUCT</h3>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="card bg-secondary shadow border-0">

                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Edit Products</small>
                                    </div>
                                    <div class="form-container border shadow-lg p-4 rounded">
                                        <form role="form" id="product-form" enctype="multipart/form-data">
                                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                                    </div>
                                                    <input class="form-control" placeholder="Product Name" id="pname" name="pname"
                                                        type="text" value="<?php echo $product['pname']; ?>">
                                                </div>
                                                <span id="demo1" style="color: red;">Please enter Product Name</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-regular fa-clipboard"></i></span>
                                                    </div>
                                                    <textarea class="form-control" placeholder="Description" id="pdes" name="pdes"
                                                        rows="3"><?php echo $product['pdes']; ?></textarea>
                                                </div>
                                                <span id="demo2" style="color: red;">Please enter description</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-brands fa-bitcoin"></i></span>
                                                    </div>
                                                    <input class="form-control" name="price" id="price" placeholder="Price"
                                                        type="number" step="0.01"
                                                        value="<?php echo $product['price']; ?>">
                                                </div>
                                                <span id="demo3" style="color: red;">Please enter Product Price</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-sitemap"></i></span>
                                                    </div>
                                                    <select class="form-control" name="category" placeholder="Category"
                                                        id="category">
                                                        <option value="">Select Category</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['cid']; ?>" <?php echo ($category['cid'] == $product['cid']) ? 'selected' : ''; ?>>
                                                                <?php echo $category['cname']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <span id="demo4" style="color: red;">Please select categories</span>
                                            </div>
                                        
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-cubes-stacked"></i></span>
                                                    </div>
                                                    <input class="form-control" name="stock" id="stock"
                                                        placeholder="Stock Quantity" type="number"
                                                        value="<?php echo $product['stock']; ?>">
                                                </div>
                                                <span id="demo6" style="color: red;">Please enter Total Stock</span>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary mt-4">Save Product</button>
                                            </div>
                                        </form>
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


    <script src="js/editproduct.js"></script>


    <?php

    include 'layout/footer.php';

    ?>