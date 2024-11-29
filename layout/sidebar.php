<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-dark bg-dark text-light" id="sidenav-main">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand pt-0" href="dashboard.php">
            <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>


        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="dashboard.php">
                            <img src="assets/img/brand/blue.png">
                        </a>
                    </div>
                </div>
            </div>

            <ul class="navbar-nav">
                <!-- Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="ni ni-tv-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportDropdown" role="button"
                        data-toggle="collapse" data-target="#reportMenu" aria-expanded="false"
                        aria-controls="reportMenu">
                        <i class="ni ni-chart-bar-32 text-purple"></i> Category
                    </a>
                    <div class="collapse" id="reportMenu">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="addcategory.php" class="nav-link">
                                    <i class="ni ni-fat-add text-blue"></i>Add Category
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="allcategory.php" class="nav-link">
                                    <i class="ni ni-chart-pie-35 text-blue"></i> All Category
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Dropdown: Components -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="componentsDropdown" role="button"
                        data-toggle="collapse" data-target="#componentsMenu" aria-expanded="false"
                        aria-controls="componentsMenu">
                        <i class="ni ni-box-2 text-orange"></i> Product
                    </a>
                    <div class="collapse" id="componentsMenu">
                        <ul class="nav nav-sm flex-column">
                            
                            <li class="nav-item">
                                <a href="addproduct.php" class="nav-link">
                                    <i class="ni ni-fat-add text-blue"></i> Add Product
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="allproduct.php" class="nav-link">
                                    <i class="ni ni-single-copy-04 text-red"></i> All Products
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Dropdown: Utilities -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="utilitiesDropdown" role="button"
                        data-toggle="collapse" data-target="#utilitiesMenu" aria-expanded="false"
                        aria-controls="utilitiesMenu">
                        <i class="ni ni-settings-gear-65 text-yellow"></i> Customer
                    </a>
                    <div class="collapse" id="utilitiesMenu">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="addcustomer.php" class="nav-link">
                                    <i class="ni ni-fat-add text-blue"></i> Add Customer
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="allcustomer.php" class="nav-link">
                                    <i class="ni ni-circle-08 text-info"></i> All Customers
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-toggle="collapse"
                        data-target="#orderMenu" aria-expanded="false" aria-controls="orderMenu">
                        <i class="ni ni-cart text-green"></i> Orders
                    </a>
                    <div class="collapse" id="orderMenu">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="addorder.php" class="nav-link">
                                    <i class="ni ni-fat-add text-blue"></i> Add Order
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="allorder.php" class="nav-link">
                                    <i class="ni ni-archive-2 text-red"></i> All Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="completeorder.php" class="nav-link">
                                    <i class="ni ni-archive-2 text-red"></i> Completed Orders
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Profile.php">
                        <i class="ni ni-single-02 text-yellow"></i> User Profile
                    </a>
                </li>
                <li class="nav-item">

                <a href="#" id="logoutBtn" class="btn btn-sm btn-primary log">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


