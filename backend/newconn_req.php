<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDS | New Connection Request</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
</head>
<style>.status-open {
            background-color: #d4edda; /* Green for open */
            color: #155724;
        }
        .status-hold {
            background-color: #fff3cd; /* Yellow for hold */
            color: #856404;
        }
        .status-closed {
            background-color: #f8d7da; /* Red for closed */
            color: #721c24;
        }</style>


<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="assets/img/pdslogo2.png" alt="bootraper logo" class="app-logo w-50 p-1 "  >
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.html"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="package.html" ><i class="fas fa-file-alt"></i>Pacakage</a>
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
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of nav here  -->
            <div class="col-md-12 col-lg-12">
                <div class="card">


                    <div class="card-header">New Connection Request Ticket</div> <br>
                    
                    <div class="card-body">
                    <div id="alert-container"></div> 
                        <p class="card-title"></p>
                        <table class="table table-hover" id="newcustomer-table" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Contact No.</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'db/connect.php';
                                $sql = "SELECT * FROM `newconn_pds`";
                                $result = $conn->query($sql); 
                                if ($result->num_rows > 0) { 
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row["nc_id"] ?></td>
                                            <td><?php echo $row["nc_update"] ?></td>
                                            <td><?php echo $row["nc_name"] ?></td>
                                            <td><?php echo $row["nc_phone"] ?></td>
                                            <td><?php echo $row["nc_email"] ?></td>
                                            <td><?php echo $row["nc_address"] ?></td>
                                            <td>
                                            <select name="status" class="form-select status-select <?php echo 'status-' . $row['nc_status']; ?>" data-id="<?php echo $row['nc_id'] ?>">
                                                    <option value="open" <?php if($row["nc_status"] == "open") echo 'selected'; ?>>Open</option>
                                                    <option value="hold" <?php if($row["nc_status"] == "hold") echo 'selected'; ?>>Hold</option>
                                                    <option value="closed" <?php if($row["nc_status"] == "closed") echo 'selected'; ?>>Closed</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { 
                                    echo "No Record Found!"; 
                                } 
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- Modal -->
     <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="modal-id"></span></p>
                    <p><strong>Date:</strong> <span id="modal-date"></span></p>
                    <p><strong>Name:</strong> <span id="modal-name"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
                    <p><strong>Message:</strong> <span id="modal-message"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>

     <!-- pagination -->
     <script> 
  
  /* Initialization of datatable */ 
  $(document).ready(function() { 
      $('#newcustomer-table').DataTable({  "order": [[0, 'desc']]  }); 
  }); 
</script>

<!-- script for msg view and status change -->
<script>
        $(document).ready(function() {
            var table = $('#newcustomer-table').DataTable();

            function handleStatusChange() {
                $('.status-select').off('change').on('change', function() {
                    const id = $(this).data('id');
                    const status = $(this).val();
                    const selectElement = $(this);

                    // Update status in the database
                    $.ajax({
                        url: 'update_newconn_status.php',
                        type: 'POST',
                        data: { id, status },
                        success: function(response) {
                            showAlert('success', 'Status updated successfully!');
                            updateStatusClass(selectElement, status);
                        },
                        error: function() {
                            showAlert('danger', 'Error updating status. Please try again.');
                        }
                    });
                });
            }

            function showAlert(type, message) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('#alert-container').html(alertHtml);
            }

            function updateStatusClass(selectElement, status) {
                selectElement.removeClass('status-open status-hold status-closed');
                if (status === 'open') {
                    selectElement.addClass('status-open');
                } else if (status === 'hold') {
                    selectElement.addClass('status-hold');
                } else if (status === 'closed') {
                    selectElement.addClass('status-closed');
                }
            }

            // Apply the correct class to all status select elements on page load
            $('.status-select').each(function() {
                const status = $(this).val();
                updateStatusClass($(this), status);
            });

            // Reapply the event listeners after each table draw event
            table.on('draw', function() {
                handleStatusChange();
                $('.status-select').each(function() {
                    const status = $(this).val();
                    updateStatusClass($(this), status);
                });
            });

            // Initial call to set up event listeners
            handleStatusChange();
        });
    </script>
</body>

</html>