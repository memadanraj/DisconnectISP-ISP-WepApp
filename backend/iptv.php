<?php
session_start();
error_reporting(0);

?>


<!--########### Handle the Add operation ################3-->

<?php
if (isset($_POST['Addiptv']) ) {
  include 'db/connect.php';
  $iptv_name = $_POST['tvname'];
  $iptv_info = $_POST['tvinfo'];

  // File information
  $file_name = $_FILES['svgi']['name'];
  $file_tmp = $_FILES['svgi']['tmp_name'];

  // Alternative method to get file extension with debugging
  $file_parts = pathinfo($file_name);
  $file_ext = strtolower($file_parts['extension']);

  $allowed_extensions = array( "png", "svg","webp");

        // Check if file extension is allowed
        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                                Please choose only JPG, JPEG, PNG, Webp, or SVG file !!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }  else {
    // Generate a new file name to avoid conflicts
    $new_image_name = uniqid() . '.' . $file_ext;
    $folder = "img/" . $new_image_name;

    // Move the uploaded file
    if (move_uploaded_file($file_tmp, $folder)) {
      // Prepare and execute the SQL query to insert the data
      $stmt = $conn->prepare("INSERT INTO `tv_pds` (`tv_img`, `tv_name`, `tv_info`) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $folder, $iptv_name, $iptv_info);

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
<!--########### Handle the delete operation ################3-->
<?php
 if (isset($_POST['Deleteiptv'])) {
    include 'db/connect.php';
    $iptv_id = $_POST['tv_id'];
    // Prepare and execute the SQL query to delete the data
    $stmt = $conn->prepare("DELETE FROM `tv_pds` WHERE `tv_id` = ?");
    $stmt->bind_param("i", $iptv_id);
    if ($stmt->execute()) {
      $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                            Data successfully deleted!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
    } else {
      $_SESSION['msg'] = "Error: " . $stmt->error;
    }
  
    // Close the statement and connection
    $stmt->close();
    $conn->close();
  
    // Redirect to the same page to display the message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
?>



<!-- ################## update operation php ################# -->

<?php
if (isset($_POST['updateIptv'])) {
  include 'db/connect.php';

  $iptv_id = $_POST['tv_id'];
  $iptv_name = $_POST['uiptvname'];
  $iptv_info = $_POST['uiptvinfo'];
  $file_name = $_FILES['uiptvsvg']['name'];
  $file_tmp = $_FILES['uiptvsvg']['tmp_name'];
  if (!empty($file_name)) {
    $file_parts = pathinfo($file_name);
    $file_ext = strtolower($file_parts['extension']);

    if ($file_ext != "svg") {
      $_SESSION['msg'] = 'Please choose only .SVG file !!';
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    } else {
      $new_image_name = rand() . '.' . $file_ext;
      $folder = "img/" . $new_image_name;

      if (move_uploaded_file($file_tmp, $folder)) {
        $stmt = $conn->prepare("SELECT `tv_img` FROM `tv_pds` WHERE `tv_id` = ?");
        $stmt->bind_param("i", $iptv_id);
        $stmt->execute();
        $stmt->bind_result($old_image);
        $stmt->fetch();
        $stmt->close();

        if (file_exists($old_image)) {
          unlink($old_image);
        }

        $stmt = $conn->prepare("UPDATE `tv_pds` SET `tv_img` = ?, `tv_name` = ?, `tv_info` = ? WHERE `tv_id` = ?");
        $stmt->bind_param("sssi", $folder, $iptv_name, $iptv_info, $iptv_id);
      } else {
        $_SESSION['msg'] = "Failed to upload file.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
      }
    }
  } else {
    $stmt = $conn->prepare("UPDATE tv_pds SET tv_name = ?, tv_info = ? WHERE tv_id = ?");
    $stmt->bind_param("ssi", $iptv_name, $iptv_info, $iptv_id);
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





<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IPTV Info </title>
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


      <!-- Modal  add iptv-->
      <div class="modal fade" id="Addiptv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add IPTV</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container">

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">Add Iptv here</div>
                      <div class="card-body">
                        <h5 class="card-title"></h5>
                        <form class="" method="POST" action="" enctype="multipart/form-data">
                          <div class="mb-3 row">
                            <!-- package name  -->
                            <label class="col-sm-2">Iptv Name</label>
                            <div class="col-sm-10">
                              <input type="text" name="tvname" class="form-control" />
                            </div>
                          </div>
                          <div class="line"></div>
                          <br />
                          <!-- package mbps -->
                          <div class="mb-3 row">
                            <label class="col-sm-2">Info</label>
                            <div class="col-sm-10">
                              <input type="text" name="tvinfo" class="form-control" />
                            </div>
                          </div>
                          <div class="line"></div>
                          <br />

                          <!-- svg image  -->
                          <div class="mb-3 row">
                            <label class="col-sm-2">SVG</label>
                            <div class="col-sm-10">
                              <input type="file" name="svgi" class="form-control" />
                            </div>
                          </div>
                          <div class="line"></div>
                          <br />
                          <!-- submit -->

                          <div class="line"></div>
                          <br />
                          <div class="mb-3 row">
                            <div class="col-sm-4 offset-sm-2">
                              <button type="submit" class="btn btn-secondary mb-2" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                              </button>
                              <button type="submit" class="btn btn-primary mb-2" name="Addiptv">
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

      <!-- Modal  add iptv end here -->



      <!-- Modal  Update IPTV Start-->
    <div class="modal fade" id="editIptvModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit IPTV</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
              <input type="hidden" id="edit_tv_id" name="tv_id">
              <div class="mb-3">
                <label for="uiptvname" class="form-label">Update IPTV Name</label>
                <input type="text" class="form-control" id="uiptvname" name="uiptvname" required>
              </div>
              <div class="mb-3">
                <label for="uiptvinfo" class="form-label">Update IPTV Info</label>
                <textarea class="form-control" id="uiptvinfo" name="uiptvinfo" required></textarea>
              </div>
              <div class="mb-3">
                <label for="uiptvsvg" class="form-label">Update SVG Image</label>
                <input type="file" class="form-control" id="uiptvsvg" name="uiptvsvg" accept=".svg">
              </div>
              <button type="submit" class="btn btn-primary" name="updateIptv">Update IPTV</button>
            </form>
          </div>
        </div>
      </div>
    </div>

<!-- Modal Update IPTV End -->


     



      <div class="col-md-12 col-lg-12">
      <div class="container mt-2">
        <!-- Display the message -->
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']); // Clear the message after displaying
        }
        ?></div>
        <div class="card">
          <div class="card-header">IPTV Info</div> <br>
          <div class="card-body">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#Addiptv"> Add IPTV List
            </button>
          </div>
          <div class="card-body">
            <p class="card-title"></p>
            <table class="table table-hover" id="iptv-table" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Iptv Name</th>
                  <th>Info</th>
                  <th>Image SVG </th>
                  <th>Operatio</th>


                </tr>
              </thead>
              <tbody>
                <tr>
                                      <?php
                      include 'db/connect.php';

                      $sql= "SELECT * FROM `tv_pds` ";
                      $result = $conn->query($sql); 

                    if ($result->num_rows > 0)  
                    { 
                        // OUTPUT DATA OF EACH ROW 
                        while($row = $result->fetch_assoc()) 
                        { 

                          ?>
          
                  <td><?php echo $row["tv_id"] ?></td>
                  
                  <td><?php echo $row["tv_name"] ?></td>

                  <td><?php echo $row["tv_info"] ?></td>
                  <td><img src="<?php echo $row["tv_img"] ?>" alt="" srcset="" width="100px" style="border: 2px solid rgb(92, 138, 92); background-color: green;"></td>
                  <td>
                
                    <?php echo "<button class='btn btn-success mb-2' onclick='editIptv(" . $row['tv_id'] . ", \"" . addslashes($row['tv_name']) . "\", \"" . addslashes($row['tv_info']) . "\")'>Edit</button> ";?>
                    
                
                    <form method='POST' style='display:inline-block'>
                    <input type="hidden" name="tv_id" value="<?php echo $row["tv_id"]?>">
                                    <button  type="submit" class="btn btn-danger  mb-2" name ="Deleteiptv"> Delete </button>
                                </form>
                    
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


  <!-- scripts -->]

<script>
  function editIptv(tv_id, tv_name, tv_info) {
  document.getElementById('edit_tv_id').value = tv_id;
  document.getElementById('uiptvname').value = tv_name;
  document.getElementById('uiptvinfo').value = tv_info;
  $('#editIptvModal').modal('show');
}

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/datatables/datatables.min.js"></script>
  <script src="assets/js/initiate-datatables.js"></script>
  <script src="assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
  <!-- pagination -->
  <script> 
  
  /* Initialization of datatable */ 
  $(document).ready(function() { 
      $('#iptv-table').DataTable({ }); 
  }); 
</script>
</body>

</html>
