<?php
session_start();
error_reporting(0);

?>

<!--  strat add package php -->
<?php

if (isset($_POST['addpac'])) {
    include 'db/connect.php';
    $pac_name = $_POST['pacname'];
    $pac_mbps = $_POST['pacmbps'];
    $pac_price = $_POST['pacprice'];
    $pac_info = $_POST['pacinfo'];
    $pac_type = $_POST['pactype'];
    $pac_period = $_POST['pacperiod'];

    // File information
    $file_name = $_FILES['pacimg']['name'];
    $file_tmp = $_FILES['pacimg']['tmp_name'];

    // Alternative method to get file extension with debugging
    $file_parts = pathinfo($file_name);
    $file_ext = strtolower($file_parts['extension']);

    // Allowed file extensions
    $allowed_extensions = array("jpg", "jpeg", "png", "svg");

    // Check if file extension is allowed
    if (!in_array($file_ext, $allowed_extensions)) {
        $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                              Please choose only JPG, JPEG, PNG, or SVG file !!
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>';
    } else {
        // Generate a new file name to avoid conflicts
        $new_image_name = uniqid() . '.' . $file_ext;
        $folder = "img/" . $new_image_name;

        // Move the uploaded file
        if (move_uploaded_file($file_tmp, $folder)) {
            // Prepare and execute the SQL query to insert the data
            $stmt = $conn->prepare("INSERT INTO `package_pds`( `p_img`, `p_name`, `p_mbps`, `p_price`, `p_info`, `p_type`, `p_period`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $folder, $pac_name, $pac_mbps, $pac_price, $pac_info, $pac_type, $pac_period);

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
        } else {
            $_SESSION['msg'] = "Failed to upload file.";
            }

        // Close the database connection
        $conn->close();
            }

    // Redirect to the same page to display the message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
            }
?>
<!--  Ends add package php -->

<!--  strat update package php -->
<?php
if (isset($_POST['updatepac'])) {
    include 'db/connect.php';
    $pac_id =$_POST['pacid'];
    $pac_name = $_POST['pacname'];
    $pac_mbps = $_POST['pacmbps'];
    $pac_price = $_POST['pacprice'];
    $pac_info = $_POST['pacinfo'];
    $pac_type = $_POST['pactype'];
    $pac_period = $_POST['pacperiod'];
    $file_name = $_FILES['pacimg']['name'];
    $file_tmp = $_FILES['pacimg']['tmp_name'];
    if (!empty($file_name)) {
      $file_parts = pathinfo($file_name);
      $file_ext = strtolower($file_parts['extension']);
      $allowed_extensions = array("jpg", "jpeg", "png", "svg");
  
      if (!in_array($file_ext, $allowed_extensions)) {
        $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                              Please choose only JPG, JPEG, PNG, or SVG file !!
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>';
    }  else {
        $new_image_name = rand() . '.' . $file_ext;
        $folder = "img/" . $new_image_name;
  
        if (move_uploaded_file($file_tmp, $folder)) {
          $stmt = $conn->prepare("SELECT `p_img` FROM `package_pds` WHERE `p_id` = ?");
          $stmt->bind_param("i", $pac_id);
          $stmt->execute();
          $stmt->bind_result($old_image);
          $stmt->fetch();
          $stmt->close();
  
          if (file_exists($old_image)) {
            unlink($old_image);
          }
  
          $stmt = $conn->prepare("UPDATE package_pds SET`p_img` = ?, p_name = ?, p_mbps = ? , p_price = ? , p_info = ? , p_type = ? , p_period = ? WHERE p_id = ?");
          $stmt->bind_param("sssssssi", $folder, $pac_name, $pac_mbps, $pac_price, $pac_info, $pac_type, $pac_period,$pac_id);
        } else {
          $_SESSION['msg'] = "Failed to upload file.";
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
        }
      }
    } else {
        $stmt = $conn->prepare("UPDATE package_pds SET`p_img` = ?, p_name = ?, p_mbps = ? , p_price = ? , p_info = ? , p_type = ? , p_period = ? WHERE p_id = ?");
        $stmt->bind_param("sssssssi", $folder, $pac_name, $pac_mbps, $pac_price, $pac_info, $pac_type, $pac_period,$pac_id);
    }
  
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

<!--  End add package php -->

<!--  Start Delete package php -->
<?php
if (isset($_POST['deletepac'])) {
  include 'db/connect.php';

  $p_idd = $_POST['pac_id'];

  // Get the old image file name
  $stmt = $conn->prepare("SELECT `p_img` FROM `package_pds` WHERE `p_id` = ?");
  $stmt->bind_param("i", $p_idd);
  $stmt->execute();
  $stmt->bind_result($oldd_image);
  $stmt->fetch();
  $stmt->close();

  // Delete the old image file if it exists
  if (file_exists($oldd_image)) {
      unlink($oldd_image);
  }

  // Prepare and execute the delete query
  $stmt = $conn->prepare("DELETE FROM `package_pds` WHERE `p_id` = ?");
  $stmt->bind_param("i", $p_idd);

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

<!--  End Delete package php -->




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDS| Package Info</title>
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
                <img src="../img/pdslogo2.png" alt="bootraper logo" class="app-logo w-50 p-1 "  >
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
            <!-- end of nav here  -->



            <!-- ADD  PACKAGE INFO Start -->

            <div class="modal fade" id="Addpackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">Add Package here</div>
                                            <div class="card-body">
                                                <h5 class="card-title"></h5>
                                                <form class="" method="POST" action="" enctype="multipart/form-data">

                                                    <div class="mb-3 row">
                                                        <!-- package name  -->
                                                        <label class="col-sm-2">Package Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="pacname" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- package mbps -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Package mbps</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="pacmbps" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />

                                                    <!-- price  -->
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Price</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="pacprice" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />


                                                    <!-- package type -->

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Package Type</label>
                                                        <div class="col-sm-10 select">
                                                            <select name="pactype" class="form-select">
                                                                <option value="internet">Internet</option>
                                                                <option value="internetTv">Internet With IPTV</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="line"></div>
                                                    <br />
                                                    <!-- package period  -->

                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Period Size</label>
                                                        <div class="col-sm-10 select">
                                                            <select name="pacperiod" class="form-select">
                                                            <option value="year">1 year</option>
                                                            <option value="3month">3 Month</option>
                                                            <option value="1month">Monthly</option> 
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- benifits -->
                                                    <div class="line"></div>
                                                    <br />
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Benifits</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="pacinfo" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-2">Upload Image</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="pacimg" 
                                                                class="form-control" />
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
                                                                name="addpac">
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

            <!-- ADD  PACKAGE INFO END -->


            <!-- Update  PACKAGE INFO Start -->
            <div class="modal fade" id="editpacmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit IPTV</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="" method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" id="pac_id" name="pacid">
                                <div class="mb-3 row">
                                    <!-- package name  -->
                                    <label class="col-sm-2">Package Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="pac_name" name="pacname" class="form-control" />
                                    </div>
                                </div>
                                <div class="line"></div>
                                <br />
                                <!-- package mbps -->
                                <div class="mb-3 row">
                                    <label class="col-sm-2">Package mbps</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="pac_mbps" name="pacmbps" class="form-control" />
                                    </div>
                                </div>
                                <div class="line"></div>
                                <br />

                                <!-- price  -->
                                <div class="mb-3 row">
                                    <label class="col-sm-2">Price</label>
                                    <div class="col-sm-10">
                                        <input type="text"  id="pac_price" name="pacprice" class="form-control" />
                                    </div>
                                </div>
                                <div class="line"></div>
                                <br />


                                <!-- package type -->

                                <div class="mb-3 row">
                                    <label class="col-sm-2">Package Type</label>
                                    <div class="col-sm-10 select">
                                        <select name="pactype" class="form-select" id="pac_type">
                                            <option value="internet">Internet</option>
                                            <option value="internetTv">Internet With IPTV</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="line"></div>
                                <br />
                                <!-- package period  -->

                                <div class="mb-3 row">
                                    <label class="col-sm-2">Period Size</label>
                                    <div class="col-sm-10 select">
                                        <select name="pacperiod" class="form-select" id="pac_period">
                                            <option value="year">1 year</option>
                                            <option value="3month">3 Month</option>
                                            <option value="1month">Monthly</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- benifits -->
                                <div class="line"></div>
                                <br />
                                <div class="mb-3 row">
                                    <label class="col-sm-2">Benifits</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="pac_info" name="pacinfo" class="form-control" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2">Upload Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="pacimg"  class="form-control" />
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
                                        <button type="submit" class="btn btn-primary mb-2" name="updatepac">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Update PACKAGE INFO END -->



            <!-- Strat Delete modal -->
         <div class="modal fade" id="deletepacm" tabindex="-1" role="dialog" aria-labelledby="deletemodal"
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
                                                <input type="hidden" id="dpac_id" name="pac_id">
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
                                                            name="deletepac">
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

            <!-- Strat Delete modal -->

            <div class="col-md-12 col-lg-12">

                <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']); // Clear the message after displaying
        }
        ?></div>
            <div class="card">


                <div class="card-header">Package Info</div> <br>
                <div class="card-body">
                    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#Addpackage">
                        Add Package List
                    </button>
                </div>
                <div class="card-body">
                    <p class="card-title"></p>
                    <table class="table table-hover" id="pac-table" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Mbps</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Period</th>
                                <th>Operation</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <?php
                      include 'db/connect.php';

                      $sql= "SELECT * FROM `package_pds` ";
                      $result = $conn->query($sql); 

                            if ($result->num_rows > 0)  
                            { 
                                // OUTPUT DATA OF EACH ROW 
                                while($row = $result->fetch_assoc()) 
                                { 
                                    ?>
                                <td><?php echo $row["p_id"] ?></td>
                                <td><?php echo $row["p_name"] ?></td>
                                <td><?php echo $row["p_mbps"] ?></td>
                                <td><?php echo $row["p_price"] ?></td>
                                <td><?php echo $row["p_type"] ?></td>
                                <td><?php echo $row["p_period"] ?></td>

                                <td>
                                <?php echo "<button class='btn btn-success mb-2' onclick='editpacmodal(" . $row['p_id'] . ", \"" . addslashes($row['p_name']) . "\", \"" . addslashes($row['p_mbps']) . "\",\"" . addslashes($row['p_price']) . "\",\"" . addslashes($row['p_info']) . "\",\"" . addslashes($row['p_type']) . "\",\"" . addslashes($row['p_period']) . "\")'>Edit</button> ";?>
                                    <button type="button" class="btn btn-success mb-2" onclick=" deletepacmodal('<?php echo $row['p_id']?>')">Delete  </button>
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

function editpacmodal(p_id, p_name, p_mbps, p_price,p_info, p_type, p_period ) {
    document.getElementById('pac_id').value = p_id;
    document.getElementById('pac_name').value = p_name;
    document.getElementById('pac_mbps').value = p_mbps;
    document.getElementById('pac_price').value = p_price;
    document.getElementById('pac_type').value = p_type; // Setting the dropdown value
    document.getElementById('pac_period').value = p_period;
    document.getElementById('pac_info').value = p_info;

    // console.log(p_id, p_name, p_mbps, p_price,p_info, p_type, p_period );

    $('#editpacmodal').modal('show');
}



function deletepacmodal(p_id) {
    document.getElementById('dpac_id').value = p_id;


    console.log(p_id);
        $('#deletepacm').modal('show');
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

<script> 
  
  /* Initialization of datatable */ 
  $(document).ready(function() { 
      $('#pac-table').DataTable({ }); 
  }); 
</script>
</body>

</html>