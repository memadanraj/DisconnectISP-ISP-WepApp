<?php
session_start();
error_reporting(0);

?>

<!-- add branch -->
<?php

if (isset($_POST['addbranch'])) {
    include 'db/connect.php';
    $br_name = $_POST['brname'];
    $br_location = $_POST['brlocation'];
    $br_contact = $_POST['brcontact'];
    $br_email = $_POST['bremail'];
    $br_map = $_POST['brmap'];

   
            $stmt = $conn->prepare("INSERT INTO `branch_pds`( `branch_name`, `branch_location`, `branch_contact`, `branch_email`, `branch_direction`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $br_name, $br_location, $br_contact, $br_email, $br_map);

            if ($stmt->execute()) {
                $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                                      Data successfully saved!
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>';
            } else {
                $_SESSION['msg'] = "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        

        // Close the database connection
        $conn->close();
         

    // Redirect to the same page to display the message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
            }
?>
<!-- add branch end -->

<!-- update branch  -->

<?php
if (isset($_POST['updatebranch'])) {
  include 'db/connect.php';

  $br_id = $_POST['br_id'];
  $br_name = $_POST['brname'];
    $br_location = $_POST['brlocation'];
    $br_contact = $_POST['brcontact'];
    $br_email = $_POST['bremail'];
    $br_map = $_POST['brmap'];
  
    $stmt = $conn->prepare("UPDATE branch_pds SET branch_name = ?, branch_location = ?, branch_contact = ?, branch_email = ?, branch_direction = ? WHERE branch_id = ?");
    $stmt->bind_param("sssssi", $br_name, $br_location, $br_contact, $br_email, $br_map, $br_id);
  

  if ($stmt->execute()) {
    $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                            Data Updated successfully !
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
  } else {
    $_SESSION['msg'] = "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();

  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>


<!-- update branch end -->

<!-- delete branch end -->

<?php
if (isset($_POST['rsliderd'])) {
  include 'db/connect.php';

  $rbr_idd = $_POST['br_id'];


  // Prepare and execute the delete query
  $stmt = $conn->prepare("DELETE FROM `branch_pds` WHERE `branch_id` = ?");
  $stmt->bind_param("i", $rbr_idd);

  if ($stmt->execute()) {
      $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                              Data deleted successfully !
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>';
  } else {
      $_SESSION['msg'] = "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();

  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>

<!-- delete branch end -->


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDS | Branch Offices</title>
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
                    <a href="Customer-msg.php">   <i class="fas fa-ticket-alt"></i> Tickets</a>
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
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <!-- <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div> -->
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>John Doe</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="change_password.php" class="dropdown-item"><i class="fas fa-fingerprint"></i> Change Password</a></li>
                                        
                                        <div class="dropdown-divider"></div>
                                        <li><a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- modal for Branch add  strat -->

            <div class="modal fade" id="addslider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Branch Info</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true"></span>
                             </button>
                            
                        </div>
                        <div class="modal-body">
                            <div class="container">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <h5 class="card-title"></h5>
                                                <form class="" method="POST" action="" enctype="multipart/form-data">
                                                    <div class="mb-3 row">
                                                        <!-- Branch Name -->
                                                        <label class="col-sm-2">Branch Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brname" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                     <!-- Location -->
                                                     <div class="mb-3 row">
                                                        <label class="col-sm-2">Location </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brlocation" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />

                                                    <!-- Contact Info -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Contact Info </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brcontact" id="brcontact" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- Email -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Email </label>
                                                        <div class="col-sm-10">
                                                            <input type="email" name="bremail" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />


                                                    <!-- Map Link -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Map Link </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brmap" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />


                                                    <!-- submit -->

                                                    <div class="line"></div>
                                                    <br />
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-4 offset-sm-2">
                                                            <button type="submit" class="btn btn-secondary mb-2">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </button>
                                                            <button type="submit" name="addbranch"
                                                                class="btn btn-primary mb-2">
                                                                <i class="fas fa-save"></i> Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- modal for slider add END -->



            <!-- modal for slider update  START -->
            <div class="modal fade" id="editbranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Branch Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>
                        <div class="modal-body">
                            <div class="container">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <h5 class="card-title"></h5>
                                                <form class="" method="POST" action="" enctype="multipart/form-data">
                                                <input type="hidden" id="br_id" name="br_id">
                                                    <div class="mb-3 row">
                                                        <!-- Branch Name -->
                                                        <label class="col-sm-2">Branch Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brname" id="br_name" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                     <!-- Location -->
                                                     <div class="mb-3 row">
                                                        <label class="col-sm-2">Location </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brlocation" id="br_location" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />

                                                    <!-- Contact Info -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Contact Info </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brcontact" id="br_contact" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- Email -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Email </label>
                                                        <div class="col-sm-10">
                                                            <input type="email" name="bremail" id="br_email" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />


                                                    <!-- Map Link -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Map Link </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="brmap" id="br_map" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />


                                                    <!-- submit -->

                                                    <div class="line"></div>
                                                    <br />
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-4 offset-sm-2">
                                                            <button type="submit" class="btn btn-secondary mb-2">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary mb-2"
                                                                name="updatebranch">
                                                                <i class="fas fa-save"></i> Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        


        <!-- modal for slider update  END -->


        <!-- Modal for slider delete -->
        <div class="modal fade" id="deletebranch" tabindex="-1" role="dialog" aria-labelledby="deletemodal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletemodal">Remove Slider Image Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"></h5>
                                            <form method="post">
                                                <input type="hidden" id="rbr_id" name="br_id">
                                                <div class="mb-3 row">
                                                    <!-- Slider Offer Name -->
                                                    <h5> Are You Sure ?</h5>

                                                </div>
                                                <div class="line"></div>
                                                <br />
                                                <div class="mb-3 row">
                                                    <div class="col-sm-4 offset-sm-2">
                                                        <button type="button" class="btn btn-secondary mb-2"
                                                            data-bs-dismiss="modal">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-danger mb-2"
                                                            name="rsliderd">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-12 col-lg-12">

            <!-- display message  -->
            <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']); 
        }
        ?>
        </div>
        <div class="card">


            <div class="card-header">Branch Info</div> <br>
            <div class="card-body">
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#addslider"> Add
                    New Branch Office
                </button>
            </div>
            <div class="card-body">
                <p class="card-title"></p>
                <table class="table table-hover" id="branch-tablee" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <?php
                      include 'db/connect.php';

                      $sql= "SELECT * FROM `branch_pds` ";
                      $result = $conn->query($sql); 

                    if ($result->num_rows > 0)  
                    { 
                        // OUTPUT DATA OF EACH ROW 
                        while($row = $result->fetch_assoc()) 
                        { 

                          ?>
                            <td><?php echo $row["branch_id"] ?></td>
                            <td><?php echo $row["branch_name"] ?></td>
                            <td><?php echo $row["branch_location"] ?></td>
                            <td><?php echo $row["branch_contact"] ?></td>
                            <td><?php echo $row["branch_email"] ?></td>
                            <td>
                                <?php echo "<button class='btn btn-success mb-2' onclick='edittbranch(" . $row['branch_id'] . ", \"" . addslashes($row['branch_name']) . "\", \"" . addslashes($row['branch_location']) . "\", \"" . addslashes($row['branch_contact']) . "\", \"" . addslashes($row['branch_email']) . "\", \"" . addslashes($row['branch_direction']) . "\")'>Edit</button> ";?>
                                <a href="javascript:void(0)" class="btn btn-danger mb-2"
                                    onclick="removebranch(<?php echo $row['branch_id']; ?>)"><i class="fas fa-trash"></i>
                                    Delete</a>

                            </td>
                        </tr>
                        <?php
                              } 
                          }  
                          else { 
                              echo "No Record Found !"; 
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

    <!-- scripts -->



    <script>
    function edittbranch(branch_id, branch_name, branch_location ,branch_contact, branch_email, branch_direction) {
        document.getElementById('br_id').value = branch_id;
        document.getElementById('br_name').value = branch_name;
        document.getElementById('br_location').value = branch_location;
        document.getElementById('br_contact').value = branch_contact;
        document.getElementById('br_email').value = branch_email;
        document.getElementById('br_map').value = branch_direction;


        console.log(branch_id, branch_name, branch_location);

        $('#editbranch').modal('show');
    }


    function removebranch(id) {
        document.getElementById('rbr_id').value = id;
        console.log(id);

        $('#deletebranch').modal('show');
    }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
     <!-- pagination -->
     <script> 
  
  /* Initialization of datatable */ 
  $(document).ready(function() { 
      $('#branch-tablee').DataTable({ }); 
  }); 
</script>
</body>

</html>