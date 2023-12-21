<?php
    session_start();

    require_once("../../Controller/UserController.php");

    
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dashboard</title>
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
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo($user->firstname . ' ' . $user->middlename . ' ' . $user->lastname); ?></a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Welcome <?php echo($user->firstname . ' ' . $user->middlename . ' ' . $user->lastname); ?> !</h4>
                                </div>
                            </div>
                        </div>     
                        <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <div class="card widget-box-two bg-purple">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body wigdet-two-content">
                                                <p class="m-0 text-uppercase text-white" title="Statistics">Statistics</p>
                                                <h2 class="text-white"><span data-plugin="counterup">65841</span> <i class="mdi mdi-arrow-up text-white font-22"></i></h2>
                                                <p class="text-white m-0"><b>10%</b> From previous period</p>
                                            </div>
                                            <div class="avatar-lg rounded-circle bg-soft-light ml-2 align-self-center">
                                                <i class="mdi mdi-chart-line font-22 avatar-title text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
        
                            <div class="col-xl-3 col-md-6">
                                <div class="card widget-box-two bg-info">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body wigdet-two-content">
                                                <p class="m-0 text-white text-uppercase" title="User Today">User Today</p>
                                                <h2 class="text-white"><span data-plugin="counterup">52142</span> <i class="mdi mdi-arrow-up text-white font-22"></i></h2>
                                                <p class="text-white m-0"><b>5.6%</b> From previous period</p>
                                            </div>
                                            <div class="avatar-lg rounded-circle bg-soft-light ml-2 align-self-center">
                                                <i class="mdi mdi-access-point-network  font-22 avatar-title text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
        
                            <div class="col-xl-3 col-md-6">
                                <div class="card widget-box-two bg-pink">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body wigdet-two-content">
                                                <p class="m-0 text-uppercase text-white" title="Request Per Minute">Request Per Minute</p>
                                                <h2 class="text-white"><span data-plugin="counterup">2365</span> <i class="mdi mdi-arrow-up text-white font-22"></i></h2>
                                                <p class="text-white m-0"><b>7.02%</b> From previous period</p>
                                            </div>
                                            <div class="avatar-lg rounded-circle bg-soft-light ml-2 align-self-center">
                                                <i class="mdi mdi-timetable font-22 avatar-title text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
        
                            <div class="col-xl-3 col-md-6">
                                <div class="card widget-box-two bg-success">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body wigdet-two-content">
                                                <p class="m-0 text-white text-uppercase" title="New Downloads">New Downloads</p>
                                                <h2 class="text-white"><span data-plugin="counterup">854</span> <i class="mdi mdi-arrow-up text-white font-22"></i></h2>
                                                <p class="text-white m-0"><b>9.9%</b> From previous period</p>
                                            </div>
                                            <div class="avatar-lg rounded-circle bg-soft-light ml-2 align-self-center">
                                                <i class="mdi mdi-cloud-download font-22 avatar-title text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
        
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Last 30 days statistics</h4>
    
                                        <div dir="ltr">
                                            <div id="donut-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Total Revenue share</h4>
                                        <div dir="ltr">
                                            <div id="combine-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Total Revenue share</h4>
                                        <div dir="ltr">
                                            <div id="roated-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Recent Projects</h4>
    
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project Name</th>
                                                    <th>Start Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Assign</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Codefox Admin v1</td>
                                                        <td>01/01/2019</td>
                                                        <td>26/04/2019</td>
                                                        <td><span class="badge badge-info">Released</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Codefox Frontend v1</td>
                                                        <td>01/01/2019</td>
                                                        <td>26/04/2019</td>
                                                        <td><span class="badge badge-success">Released</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Codefox Admin v1.1</td>
                                                        <td>01/05/2019</td>
                                                        <td>10/05/2019</td>
                                                        <td><span class="badge badge-pink">Pending</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Codefox Frontend v1.1</td>
                                                        <td>01/01/2019</td>
                                                        <td>31/05/2019</td>
                                                        <td><span class="badge badge-purple">Work in Progress</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Codefox Admin v1.3</td>
                                                        <td>01/01/2019</td>
                                                        <td>31/05/2019</td>
                                                        <td><span class="badge badge-warning">Coming soon</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Codefox Admin v1</td>
                                                        <td>01/01/2019</td>
                                                        <td>26/04/2019</td>
                                                        <td><span class="badge badge-info">Released</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Codefox Frontend v1</td>
                                                        <td>01/01/2019</td>
                                                        <td>26/04/2019</td>
                                                        <td><span class="badge badge-success">Released</span></td>
                                                        <td>Coderthemes</td>
                                                    </tr>
    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card widget-box-three">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="bg-icon avatar-lg text-center bg-light rounded-circle">
                                                        <i class="fe-database h2 text-muted m-0 avatar-title"></i>
                                                    </div>
                                                    <div class="media-body text-right ml-2">
                                                        <p class="text-uppercase">Statistics</p>
                                                        <h2 class="mb-0"><span data-plugin="counterup">2,562</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card widget-box-three">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="bg-icon avatar-lg text-center bg-light rounded-circle">
                                                        <i class="fe-briefcase h2 text-muted m-0 avatar-title"></i>
                                                    </div>
                                                    <div class="media-body text-right ml-2">
                                                        <p class="text-uppercase">User Today</p>
                                                        <h2 class="mb-0"><span data-plugin="counterup">8,542</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card widget-box-three">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="bg-icon avatar-lg text-center bg-light rounded-circle">
                                                        <i class="fe-download h2 text-muted m-0 avatar-title"></i>
                                                    </div>
                                                    <div class="media-body text-right ml-2">
                                                        <p class="text-uppercase">Request Per Minute</p>
                                                        <h2 class="mb-0"><span data-plugin="counterup">6,254</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card widget-box-three">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="bg-icon avatar-lg text-center bg-light rounded-circle">
                                                        <i class="fe-bar-chart-2 h2 text-muted m-0 avatar-title"></i>
                                                    </div>
                                                    <div class="media-body text-right ml-2">
                                                        <p class="text-uppercase">New Downloads</p>
                                                        <h2 class="mb-0"><span data-plugin="counterup">7,524</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card widget-user">
                                            <div class="card-body">
                                                <img src="../../assets\images\users\avatar-3.jpg" class="img-fluid d-block rounded-circle avatar-md" alt="user">
                                                <div class="wid-u-info">
                                                    <h5 class="mt-3 mb-1">Chadengle</h5>
                                                    <p class="text-muted mb-0">coderthemes@gmail.com</p>
                                                    <div class="user-position">
                                                        <span class="text-warning">Admin</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card widget-user">
                                            <div class="card-body">
                                                <img src="../../assets\images\users\avatar-2.jpg" class="img-fluid d-block rounded-circle avatar-md" alt="user">
                                                <div class="wid-u-info">
                                                    <h5 class="mt-3 mb-1">Michael Zenaty</h5>
                                                    <p class="text-muted mb-0">coderthemes@gmail.com</p>
                                                    <div class="user-position">
                                                        <span class="text-info">User</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                        
                    </div> <!-- end container-fluid -->

                </div> <!-- end content -->

                

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                2016 - 2020 &copy; Codefox theme by <a href="">Coderthemes</a>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="#">About Us</a>
                                    <a href="#">Help</a>
                                    <a href="#">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close"></i>
                </a>
                <h5 class="m-0 text-white">Theme Customizer</h5>
            </div>
            <div class="slimscroll-menu">

                <div class="p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, layout, etc.
                    </div>
                    <div class="mb-2">
                        <img src="../../assets\images\layouts\light.png" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked="">
                        <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="../../assets\images\layouts\dark.png" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsstyle="../../assets/css/bootstrap-dark.min.css" data-appstyle="../../assets/css/app-dark.min.css">
                        <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="../../assets\images\layouts\rtl.png" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appstyle="../../assets/css/app-rtl.min.css">
                        <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="../../assets\images\layouts\dark-rtl.png" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-5">
                        <input type="checkbox" class="custom-control-input theme-choice" id="dark-rtl-mode-switch" data-bsstyle="../../assets/css/bootstrap-dark.min.css" data-appstyle="../../assets/css/app-dark-rtl.min.css">
                        <label class="custom-control-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>

                    <a href="https://wrapbootstrap.com/theme/codefox-admin-dashboard-template-WB0X27670?ref=coderthemes" class="btn btn-danger btn-block" target="_blank"><i class="mdi mdi-download mr-1"></i> Download Now</a>
                </div>
            </div> <!-- end slimscroll-menu-->
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
</html>