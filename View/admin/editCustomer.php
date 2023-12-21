<?php
    session_start();
    require_once("../../Controller/CategoryController.php");
    require_once("../../Controller/ConnectDB.php");
    require_once("../../Controller/UserController.php");

    $customerController = new UserController($conn);

    if (isset($_SESSION['admin'])) {
        if (isset($_SESSION['admin']['id']) && is_numeric($_SESSION['admin']['id'])) {
            $userId = (int)$_SESSION['admin']['id'];
            
            $userController = new UserController($conn);
            $user = $userController->getUserByID($userId);
        }
    } else {
        header("Location: ../login.php");
        exit();
    } 

    if(isset($_GET['id'])) {
        $customer_id = (int)$_GET['id'];
        $customer = $customerController->getCustomerByID($customer_id);
    } else {
        header("Location: AccountCustomer.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Update Product</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../../assets\images\favicon.ico">

        <!-- Bootstrap select pluings -->
        <link href="../../assets\libs\bootstrap-select\bootstrap-select.min.css" rel="stylesheet" type="text/css">

        <!-- c3 plugin css -->
        <link rel="stylesheet" type="text/css" href="/../../assets\libs\c3\c3.min.css">
        <link ref="stylesheet" href="/../../assets\css\category.css">

        <!-- App css -->
        <link href="../../assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet">
        <link href="../../assets\css\icons.min.css" rel="stylesheet" type="text/css">
        <link href="../../assets\css\app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet">
        <link href="../../assets\css\index.css" rel="stylesheet">

    </head>

    <body data-layout="horizontal">

        <div id="wrapper">
            <header id="topnav">
                <div class="navbar-custom">
                    <div class="container-fluid">
                        <ul class="list-unstyled topnav-menu float-right mb-0">

                            <li class="dropdown notification-list">
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                            </li>

                            <li class="d-none d-sm-block">
                                <form class="app-search">
                                    <div class="app-search-box">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit">
                                                    <i class="fe-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="../<?php echo ($user->img);?>" alt="user-image" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fe-user"></i>
                                        <span>Profile</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a href="../../Controller/ProcessLogout.php" class="dropdown-item notify-item">
                                        <i class="fe-log-out"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </li>
                        </ul>

                        <!-- LOGO -->
                        <div class="logo-box">
                            <a href="index.php" class="logo text-center logo-light"><span>AEBB</span> Company</a>

                            <a href="index.php" class="logo text-center logo-dark"><span>AEBB</span> Company</a>
                        </div>

                    </div>
                </div>
                <!-- end Topbar -->

                <div class="topbar-menu">
                    <div class="container-fluid">
                        <div id="navigation">
                            <ul class="navigation-menu">

                                <li class="has-submenu">
                                    <a href="index.php">
                                        <i class="fe-airplay"></i>Dashboard
                                    </a>
                                </li>

                                <li class="has-submenu">
                                    <a href="Category.php">
                                        <i class="fe-airplay"></i>Category
                                    </a>
                                </li>

                                <li class="has-submenu">
                                    <a href="Product.php">
                                        <i class="fe-airplay"></i>Product
                                    </a>
                                </li>

                                <li class="has-submenu">
                                    <a href="Order.php">
                                        <i class="fe-airplay"></i>Order
                                    </a>
                                </li>

                                <li class="has-submenu">
                                    <a href="AccountCustomer.php"> <i class="fe-target"></i>Account Customer
                                    <!-- <div class="arrow-down"></div> -->
                                </a>
                                    <!-- <ul class="submenu">
                                        <li><a href="AccountCustomer.php">Account</a></li>
                                    </ul> -->
                                </li>

                            </ul>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </header>
            <div class="content-page">
                <div class="content">
                    
                    <div class="container-fluid">
                        <div>
                            <div class="text-center">
                                <p class="h3">Edit Account Customer</p>
                            </div>
                            <form action="../../Controller/UpdateCustomer.php" method="POST" class="form-box" enctype="multipart/form-data">
                                <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                                <div class="mb-3">
                                    <label class="form-label" for="firstname">First Name:</label>
                                    <input type="text" name="firstname" class="form-control" required value="<?php echo $customer->firstname; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="middlename">Middle Name:</label>
                                    <input type="text" name="middlename" class="form-control" required value="<?php echo $customer->middlename; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="lastname">Last Name:</label>
                                    <input type="text" name="lastname" class="form-control" required value="<?php echo$customer->lastname; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="username">Username:</label>
                                    <input type="text" name="username" class="form-control" required value="<?php echo $customer->username; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email:</label>
                                    <input type="email" name="email" class="form-control" required value="<?php echo $customer->email; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Phone:</label>
                                    <input type="number" name="phone" class="form-control" required value="<?php echo $customer->phone; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address:</label>
                                    <input type="text" name="address" class="form-control" required value="<?php echo $customer->address; ?>">
                                </div>
                                <div class="mb-3">
                                    <img src="../<?php echo $customer->img;?>" alt="Image customer <?php $customer->username;?>" width="400px">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="image">Image:</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-success">Update Account</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>      
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="../../assets\js\vendor.min.js"></script>

        <!-- Bootstrap select plugin -->
        <script src="../../assets\libs\bootstrap-select\bootstrap-select.min.js"></script>

        <!-- plugins -->
        <script src="../../assets\libs\c3\c3.min.js"></script>
        <script src="../../assets\libs\d3\d3.min.js"></script>
        <!-- dashboard init -->
        <script src="../../assets\js\pages\dashboard.init.js"></script>

        <!-- App js -->
        <script src="../../assets\js\app.min.js"></script>
        
    </body>
</html>s