<?php
require 'db.php';

if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    $cid = (int) $_GET['cid'];

    $sql = "SELECT * FROM categories WHERE cid = $cid";
    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => false, 'message' => 'ID not found or invalid.']);
        } else {
            echo "ID not found or invalid.";
        }
        exit();
    }

    $category = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cid = (int) $_POST['cid'];
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $categoryDescription = mysqli_real_escape_string($conn, $_POST['categoryDescription']);


    $sql = "UPDATE categories SET
        cname='$categoryName',
        cdes='$categoryDescription'
        
        WHERE cid='$cid'";



    if (mysqli_query($conn, $sql)) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => true, 'message' => 'Data updated successfully!']);
            exit();
        } else {
            header("Location: allcategory.php");
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        exit();
    }
}

mysqli_close($conn);
?>


<?php

include 'layout/header.php';

?>


<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent px-0 mini-nav">
            <li class="breadcrumb-item text-white">Category</li>
            <li class="breadcrumb-item text-white active" aria-current="page">Edit Category</li>
        </ol>
    </nav>
</div>
<div class="container-fluid mt--7">

    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">EDIT CATEGORIES</h3>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="card bg-secondary shadow border-0">

                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Edit Category</small>
                                    </div>
                                    <div class="form-container border shadow-lg p-4 rounded">
                                        <form role="form bordr" id="msform"
                                            action="update.php?id=<?php echo $category['cid']; ?>" method="post">
                                            <input type="hidden" name="cid" id="cid"
                                                value="<?php echo $category['cid']; ?>">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                        class="fa-solid fa-tag"></i></span>
                                                    </div>
                                                    <input class="form-control"  id="categoryName" name="categoryName"
                                                        value="<?php echo isset($category['cname']) ? $category['cname'] : ''; ?>"
                                                        placeholder="Category Name" type="text">
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
                                                        rows="3"><?php echo isset($category['cdes']) ? $category['cdes'] : ''; ?></textarea>
                                                </div>
                                                <span id="demo2" style="color: red;">Please enter Description</span>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" name="submit" class="btn btn-primary mt-4">Save
                                                    Category</button>
                                            </div>
                                        </form>
                                        <div id="resultMessage" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

   <script src="js/editcategory.js"></script>




    <?php

    include 'layout/footer.php';

    ?>