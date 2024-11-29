
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
            <li class="breadcrumb-item text-white">Category</li>
            <li class="breadcrumb-item text-white active" aria-current="page">Add Category</li>
        </ol>
    </nav>
</div>
<div class="container-fluid mt--7">

    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">ADD CATEGORIES</h3>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="card bg-secondary shadow border-0">

                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Add Category</small>
                                    </div>
                                    <div class="form-container border shadow-lg p-4 rounded">
                                        <form role="form bordr" id="addCategoryForm">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fa-solid fa-tag"></i></span>
                                                    </div>
                                                    <input class="form-control" id="categoryName" name="categoryName"
                                                        placeholder="Category Name"  type="text">
                                                </div>
                                                <span id="demo1" style="color: red;">Please enter category Name</span>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fa-regular fa-clipboard"></i></span>
                                                    </div>
                                                    <textarea class="form-control" id="categoryDescription" name="categoryDescription"
                                                        placeholder="Category Description"
                                                        rows="3"></textarea>
                                                </div>
                                                <span id="demo2" style="color: red;">Please enter Description</span>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" id="addCategoryBtn"
                                                    class="btn btn-primary mt-4">Add Category</button>
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

    <script src="js/category.js"></script>
    <?php

    include 'layout/footer.php';

    ?>