<?php
session_start();
error_reporting(0);

?>



<?php
include 'db/connect.php';

if (isset($_POST['updatepopup'])) {
    $p_id = $_POST['p_id'];
    $p_name = $_POST['pname'];
    $p_info = $_POST['pinfo'];
    $file_name = $_FILES['pimg']['name'];
    $file_tmp = $_FILES['pimg']['tmp_name'];
    
    // Check if a new image has been uploaded
    if ($file_name) {
        // Alternative method to get file extension with debugging
        $file_parts = pathinfo($file_name);
        $file_ext = strtolower($file_parts['extension']);

        // Allowed file extensions
        $allowed_extensions = array("jpg", "jpeg", "png", "svg","webp");

        // Check if file extension is allowed
        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                                Please choose only JPG, JPEG, PNG, Webp, or SVG file !!
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
                // Retrieve the old image path
                $stmt = $conn->prepare("SELECT popup_img FROM popup_pds WHERE popup_id = ?");
                $stmt->bind_param("i", $p_id);
                $stmt->execute();
                $stmt->bind_result($old_image_path);
                $stmt->fetch();
                $stmt->close();

                // Prepare and execute the SQL query to update the data including the image
                $stmt = $conn->prepare("UPDATE popup_pds SET popup_img = ?, popup_name = ?, popup_info = ? WHERE popup_id = ?");
                $stmt->bind_param("sssi", $folder, $p_name, $p_info, $p_id);

                if ($stmt->execute()) {
                    // Remove the old image file if the database update is successful
                    if ($old_image_path && file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }

                    $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                                        Data successfully saved!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                } else {
                    $_SESSION['msg'] = "Error: " . $stmt->error;
                }
            } else {
                $_SESSION['msg'] = "Failed to upload file.";
            }
        }
    } else {
        // Prepare and execute the SQL query to update the data without changing the image
        $stmt = $conn->prepare("UPDATE popup_pds SET popup_name = ?, popup_info = ? WHERE popup_id = ?");
        $stmt->bind_param("ssi", $p_name, $p_info, $p_id);

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






<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDS | PopUP offer</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
</head>


<body>


    <style>


.imgcontainer {
  padding: 16px 16px;
}
    </style>
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
            <div class="content">
            <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']); 
        }
        ?>
                <div class="container">
                  <div class="page-title">
                    <h3>Popup Offers</h3>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-header">Update Image</div>
                        <div class="card-body">
                          <h5 class="card-title"></h5>
                          <form class="" method="POST" action="" enctype="multipart/form-data">

                          

                          <?php
                      include 'db/connect.php';

                      $sql= "SELECT * FROM `popup_pds` ";
                      $result = $conn->query($sql); 

                    if ($result->num_rows > 0)  
                    { 
                        // OUTPUT DATA OF EACH ROW 
                        while($row = $result->fetch_assoc()) 
                        { 

                          ?>
                          <input type="hidden" name="p_id" class="form-control" value="<?php echo $row['popup_id'] ?>">


                          
                            <div class="mb-3 row">
                              <!-- PopUp Offer Name -->
                              <label class="col-sm-2">PopUp Offer Name</label>
                              <div class="col-sm-10">
                                <input type="text" name="pname" class="form-control"  value="<?php  echo $row['popup_name']?>"/>
                              </div>
                            </div>
                            <div class="line"></div>
                            <br />
                            <!-- PopUp Offer Info -->
                            <div class="mb-3 row">
                              <label class="col-sm-2">PopUp Offer Info</label>
                              <div class="col-sm-10">
                                <input type="text" name="pinfo" class="form-control" value="<?php  echo $row['popup_info']?>" />
                              </div>
                            </div>
                            <div class="line"></div>
                            <br />
      
                            <!-- PopUp Offer Image -->
                            <div class="mb-3 row">
                              <label class="col-sm-2">Upload Image</label>
                              <div class="col-sm-10">
                                <input type="file" name="pimg" class="form-control" />
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
                                <button type="submit" class="btn btn-secondary mb-2" name="updatepopup">
                                  <i class="fas fa-save"></i> Update
                                </button>
                              </div>
                            </div>
                          </form>
                    
                    
                          <!-- image display -->

                          <div class="card">
                            <img src="<?php  echo $row['popup_img']?>" alt="Avatar" style="width:50%">
                            <div class="imgcontainer">
                              <h4><b><?php  echo $row['popup_name']?></b></h4>
                              <p><?php  echo $row['popup_info']?></p>
                            </div>
                          </div>
                          <?php
                              } 
                          }  
                          else { 
                              echo "No Record Found !"; 
                          } 
                          $conn->close();

                      ?>
                        </div>
                      </div>
                    </div>
                  </div>
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
</body>

</html>