
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addslider'])) {
        // Handle Add Slider
        $sname = $_POST['sname'];
        $sinfo = $_POST['sinfo'];
        $visibility = $_POST['visibility'];
        $simg = $_FILES['simg'];

        // Save the image file and insert other data into the database
        // Example code for image upload:
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($simg["name"]);
        move_uploaded_file($simg["tmp_name"], $target_file);

        // Database insertion code here...

        echo "Slider added successfully!";
    } elseif (isset($_POST['updateslider'])) {
        // Handle Update Slider
        $sliderId = $_POST['update_slider_id'];
        $usname = $_POST['usname'];
        $usinfo = $_POST['usinfo'];
        $uvisibility = $_POST['uvisibility'];
        $usimg = $_FILES['usimg'];

        // Update the image file and other data in the database
        if ($usimg['size'] > 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($usimg["name"]);
            move_uploaded_file($usimg["tmp_name"], $target_file);

            // Update with new image...
        } else {
            // Update without image...
        }

        // Database update code here...

        echo "Slider updated successfully!";
    } elseif (isset($_POST['deleteslider'])) {
        // Handle Delete Slider
        $sliderId = $_POST['delete_slider_id'];

        // Database delete code here...

        echo "Slider deleted successfully!";
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDS | Slider</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="/img/pdslogo2.png" alt="bootraper logo" class="app-logo w-50 p-1">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.html"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="package.html"><i class="fas fa-file-alt"></i>Pacakage</a>
                </li>
                <li>
                    <a href="tables.html"><i class="fas fa-table"></i> Offers</a>
                </li>
                <li>
                    <a href="charts.html"><i class="fas fa-chart-bar"></i> IPTV</a>
                </li>
                <li>
                    <a href="icons.html"><i class="fas fa-icons"></i> Tickets</a>
                </li>
                <li>
                    <a href="#uielementsmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i> Others</a>
                    <ul class="collapse list-unstyled" id="uielementsmenu">
                        <li>
                            <a href="ui-buttons.html"><i class="fas fa-angle-right"></i> Privacy policy</a>
                        </li>
                        <li>
                            <a href="ui-badges.html"><i class="fas fa-angle-right"></i> Terms & Condition</a>
                        </li>
                        <li>
                            <a href="ui-cards.html"><i class="fas fa-angle-right"></i> Carrier</a>
                        </li>
                        <li>
                            <a href="ui-alerts.html"><i class="fas fa-angle-right"></i> Blogs</a>
                        </li>
                        <li>
                            <a href="ui-tabs.html"><i class="fas fa-angle-right"></i> FAQs</a>
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
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>John Doe</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav2">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->

            <!-- Table for displaying sliders -->
            <div class="content">
                <div class="container-fluid">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addslider">Add Slider</button>

                    <!-- Display Sliders in a Table -->
                    <table id="example" class="table table-striped data-table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Slider Name</th>
                                <th>Slider Info</th>
                                <th>Visibility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample data, replace with PHP code to fetch from database -->
                            <tr>
                                <td>Sample Name</td>
                                <td>Sample Info</td>
                                <td>Yes</td>
                                <td>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updateslider" data-id="1" data-name="Sample Name" data-info="Sample Info" data-visibility="Yes">Update</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteslider" data-id="1">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal for adding slider -->
            <div class="modal fade" id="addslider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Slider Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"></h5>
                                                <form method="POST" action="process_slider.php" enctype="multipart/form-data">
                                                    <div class="mb-3 row">
                                                        <!-- Slider Offer Name -->
                                                        <label class="col-sm-2">Slider Offer Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="sname" class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- Slider Offer Info -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Slider Offer Info</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="sinfo" class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- on off slider visibility -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Slider Offer Visibility</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" name="visibility" value="Yes">
                                                                    Active
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" name="visibility" value="No">
                                                                    Inactive
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- Slider Offer Image -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Upload Image</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="simg" class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- submit -->
                                                    <div class="line"></div>
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <button type="submit" name="addslider" class="btn btn-primary px-5">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal end -->

            <!-- Modal for slider delete start -->
            <div class="modal fade" id="deleteslider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Slider Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this slider image?
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="process_slider.php">
                                <input type="hidden" name="delete_slider_id" id="delete_slider_id" value="">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="deleteslider" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for slider delete end -->

            <!-- Modal for slider update start -->
            <div class="modal fade" id="updateslider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Slider Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"></h5>
                                                <form method="POST" action="process_slider.php" enctype="multipart/form-data">
                                                    <input type="hidden" name="update_slider_id" id="update_slider_id" value="">
                                                    <div class="mb-3 row">
                                                        <!-- Slider Offer Name -->
                                                        <label class="col-sm-2">Slider Offer Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="usname" id="usname" class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- Slider Offer Info -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Slider Offer Info</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="usinfo" id="usinfo" class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- on off slider visibility -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Slider Offer Visibility</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" name="uvisibility" id="uvisibility_active" value="Yes">
                                                                    Active
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" name="uvisibility" id="uvisibility_inactive" value="No">
                                                                    Inactive
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- Slider Offer Image -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Upload Image</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="usimg" id="usimg" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- submit -->
                                                    <div class="line"></div>
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <button type="submit" name="updateslider" class="btn btn-primary px-5">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for slider update end -->
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            $('#deleteslider').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var sliderId = button.data('id');
                var modal = $(this);
                modal.find('.modal-body #delete_slider_id').val(sliderId);
            });

            $('#updateslider').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var sliderId = button.data('id');
                var sliderName = button.data('name');
                var sliderInfo = button.data('info');
                var sliderVisibility = button.data('visibility');

                var modal = $(this);
                modal.find('.modal-body #update_slider_id').val(sliderId);
                modal.find('.modal-body #usname').val(sliderName);
                modal.find('.modal-body #usinfo').val(sliderInfo);
                if (sliderVisibility === 'Yes') {
                    modal.find('.modal-body #uvisibility_active').prop('checked', true);
                } else {
                    modal.find('.modal-body #uvisibility_inactive').prop('checked', true);
                }
            });
        });
    </script>
</body>

</html>
