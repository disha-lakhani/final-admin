
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
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
            <li class="breadcrumb-item text-white active" aria-current="page">Add Product</li>
        </ol>
    </nav>
</div>
<div class="container-fluid mt--7">

    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow ">
                <div class="card-header border-0">
                    <h3 class="mb-0">ADD PRODUCT</h3>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="card bg-secondary shadow border-0">

                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Add Products</small>
                                    </div>
                                    <div class="form-container border shadow-lg p-4 rounded">
                                        <form role="form" id="product-form" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                                                    </div>
                                                    <input class="form-control" name="pname" id="pname" placeholder="Product Name"
                                                        type="text">
                                                </div>
                                                <span id="demo1" style="color: red;">Please enter Product Name</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-regular fa-clipboard"></i></span>
                                                    </div>
                                                    <textarea name="pdes" id="pdes" class="form-control" placeholder="Description"
                                                        rows="3"></textarea>
                                                </div>
                                                <span id="demo2" style="color: red;">Please enter description</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-brands fa-bitcoin"></i></span>
                                                    </div>
                                                    <input name="price" id="price" class="form-control" placeholder="Price"
                                                        type="number" step="0.01">
                                                </div>
                                                <span id="demo3" style="color: red;">Please enter Product Price</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-sitemap"></i></span>
                                                    </div>
                                                    <select class="form-control" placeholder="Category" name="category"
                                                        id="category">
                                                        <?php
                                                            $categories_query = "SELECT * FROM categories";
                                                            $categories_result = mysqli_query($conn, $categories_query);
                                                            while ($category = mysqli_fetch_assoc($categories_result)) {
                                                                echo "<option value='" . $category['cid'] . "'>" . $category['category_name'] . "</option>";
                                                            }
                                                            ?>

                                                    </select>
                                                </div>
                                                <span id="demo4" style="color: red;">Please select categories</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-regular fa-image"></i></span>
                                                    </div>
                                                    <input class="form-control" id="image" name="images[]"
                                                        placeholder="Upload Images" type="file" multiple>
                                                </div>
                                                <span id="demo5" style="color: red;">Please upload the images</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa-solid fa-cubes-stacked"></i></span>
                                                    </div>
                                                    <input class="form-control" id="stock" name="stock"
                                                        placeholder="Stock Quantity" type="number">
                                                </div>
                                                <span id="demo6" style="color: red;">Please enter Total Stock</span>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary mt-4">Add Product</button>
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

   <script src="js/product.js"></script>

    <?php

    include 'layout/footer.php';

    ?>