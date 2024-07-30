<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
 require_once 'db/connect.php';


$id = $_SESSION['user_id'];

?>
<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | Bootstrap Simple Admin Template</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="assets/img/pdslogo2.png" alt="bootraper logo" class="app-logo w-50 p-1 "  >
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="package.php" ><i class="fas fa-server"></i>Pacakage</a>
                    </li>
                    <li>
                        <a href="#offermenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-gifts"></i> Offers</a>
                        <ul class="collapse list-unstyled" id="offermenu">
                            <li>
                                <a href="Slider.php"><i class="fas fa-angle-right"></i> Slider Offer</a>
                            </li>
                            <li>
                                <a href="popupOffer.php"><i class="fas fa-angle-right"></i> PopUp Offer</a>
                            </li>
                          
                           
                        </ul>
                    </li>
                   
                <li>
                    <a href="iptv.php"><i class="fas fa-tv"></i> IPTV</a>
                </li>
                <li>
                    <a href="#ticketmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-ticket-alt"></i> Tickets</a>
                    <ul class="collapse list-unstyled" id="ticketmenu">
                        <li>
                            <a href="customer-msg.php"><i class="fas fa-angle-right"></i> Customer Ticket</a>
                        </li>
                        <li>
                            <a href="newconn_req.php"><i class="fas fa-angle-right"></i> New Booking Ticket</a>
                        </li>
                        
                       
                    </ul>
                </li>
                <li>
                    <a href="branch_office.php">   <i class="fas fa-map-marker-alt"></i> Branches</a>
                </li>
                <li>
                    <a href="#uielementsmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i> Others</a>
                    <ul class="collapse list-unstyled" id="uielementsmenu">
                        <li>
                            <a href="privacy-policy.php"><i class="fas fa-angle-right"></i> Privacy policy</a>
                        </li>
                        <li>
                            <a href="terms-n-condition.php"><i class="fas fa-angle-right"></i> Terms & Condition</a>
                        </li>
                        <li>
                            <a href="carrier.php"><i class="fas fa-angle-right"></i> Carrier</a>
                        </li>
                        <li>
                            <a href="blog.php"><i class="fas fa-angle-right"></i> Blogs</a>
                        </li>
                        <li>
                            <a href="faq.php"><i class="fas fa-angle-right"></i> FAQs</a>
                        </li>
                       
                    </ul>
                </li>
               
            </ul>
        </nav>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <?php
                                    $sql = "SELECT `name` FROM `users_pds` WHERE `id`= '$id' ;";
                                        $result = $conn->query($sql); 
                                        if ($result->num_rows > 0) { 
                                            while ($row = $result->fetch_assoc()) { ?>
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span><?php echo $row['name']; ?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="change_password.php" class="dropdown-item"><i class="fas fa-fingerprint"></i> Change Password</a></li>
                                        
                                        <div class="dropdown-divider"></div>
                                        <li><a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                                <?php }
                                } else { 
                                    echo "No Record Found!"; 
                                } 
                                $conn->close();
                                ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="teal fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">New Orders</p>
                                                <span class="number">6,267</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-calendar"></i> For this Week
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="violet fas fa-eye"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">Page views</p>
                                                <span class="number">28,210</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-stopwatch"></i> For this Month
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            

                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="orange fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <p class="detail-subtitle">Support Request</p>
                                                <span class="number">75</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-envelope-open-text"></i> For this week
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="content">
                                            <div class="head">
                                                <h5 class="mb-0">Traffic Overview</h5>
                                                <p class="text-muted">Current year website visitor data</p>
                                            </div>
                                            <div class="canvas-wrapper">
                                                <canvas class="chart" id="trafficflow"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-6">
                                    <div class="card">
                                        <div class="content">
                                            <div class="head">
                                                <h5 class="mb-0">Sales Overview</h5>
                                                <p class="text-muted">Current year sales data</p>
                                            </div>
                                            <div class="canvas-wrapper">
                                                <canvas class="chart" id="sales"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div>
                        </div>
                        
                      
                    </div> -->
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="blue large-icon mb-2 fas fa-thumbs-up"></i>
                                            <h4 class="mb-0">+21,900</h4>
                                            <p class="text-muted">FACEBOOK PAGE LIKES</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="orange large-icon mb-2 fas fa-reply-all"></i>
                                            <h4 class="mb-0">+22,566</h4>
                                            <p class="text-muted">INSTAGRAM FOLLOWERS</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="grey large-icon mb-2 fas fa-envelope"></i>
                                            <h4 class="mb-0">+15,566</h4>
                                            <p class="text-muted">E-MAIL SUBSCRIBERS</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="olive large-icon mb-2 fas fa-dollar-sign"></i>
                                            <h4 class="mb-0">+98,601</h4>
                                            <p class="text-muted">TOTAL SALES</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="assets/js/dashboard-charts.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
