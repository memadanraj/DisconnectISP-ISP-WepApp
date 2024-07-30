<?php
if (isset($_POST['factsadd'])) {
  include 'db/connect.php';
  $f_idd=$_POST['fid'];
  echo $f_idd;
  $f_tm = $_POST['tm'];
  $f_exp = $_POST['exp'];
  $f_sc = $_POST['sc'];
  $f_cc = $_POST['cc'];




  

    // Move the uploaded file
      // Prepare and execute the SQL query to insert the data
      $stmt = $conn->prepare("UPDATE `fact_pds` SET `f_exp` = ?, `f_team` = ?, `f_tclient` = ?, `f_cclient` = ? WHERE `f_id` = ?");
      $stmt->bind_param("ssssi", $f_exp, $f_tm, $f_sc, $f_cc, $f_idd);
      

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

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PDS | Facts</title>
    <link
      href="assets/vendor/fontawesome/css/fontawesome.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet" />
    <link
      href="assets/vendor/fontawesome/css/brands.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="assets/css/master.css" rel="stylesheet" />
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
        <!-- end of navbar navigation -->
        <div class="content">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']); // Clear the message after displaying
        }
        ?>
          <div class="container">
            <div class="page-title">
              <h3>Update Facts</h3>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">Facts</div>
                  <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="post" enctype="multipart/form-data">

                    <?php
                      include 'db/connect.php';

                      $sql= "SELECT * FROM `fact_pds` ";
                      $result = $conn->query($sql); 

                    if ($result->num_rows > 0)  
                    { 
                        // OUTPUT DATA OF EACH ROW 
                        while($row = $result->fetch_assoc()) 
                        { 

                          ?>
                          <input type="hidden"   name="fid" class="form-control" value="<?php echo $row['f_id']?>" />
                      <div class="mb-3 row">
                        <!-- package name  -->
                        <label class="col-sm-2">Experience</label>
                        <div class="col-sm-10">
                          <input type="number"  min="0" name="exp" class="form-control" value="<?php echo $row['f_exp']?>" />
                        </div>
                      </div>
                      <div class="line"></div>
                      <br />
                      <!-- package mbps -->
                      <div class="mb-3 row">
                        <label class="col-sm-2">Team Member</label>
                        <div class="col-sm-10">
                          <input type="number" min="0" name="tm" class="form-control"  value="<?php echo $row['f_team']?>"/>
                        </div>
                      </div>
                      <div class="line"></div>
                      <br />

                      <!-- price  -->
                      <div class="mb-3 row">
                        <label class="col-sm-2">Satisfied Clients</label>
                        <div class="col-sm-10">
                          <input type="number" min="0" name="sc" class="form-control" value="<?php echo $row['f_tclient']?>" />
                        </div>
                      </div>
                      <div class="line"></div>
                      <br />

                      <!-- package period  -->
                      <div class="mb-3 row">
                        <label class="col-sm-2">Corporate Clients</label>
                        <div class="col-sm-10">
                          <input type="number" min="0" name="cc" class="form-control" value="<?php echo $row['f_cclient']?>" />
                          
                        </div>
                      </div>
                      <div class="line"></div>
                      <br />
                      <?php
                              } 
                          }  
                          else { 
                              echo "No Record Found !"; 
                          } 
                          $conn->close();

                      ?>

                      <!-- submit -->

                      <div class="line"></div>
                      <br />
                      <div class="mb-3 row">
                        <div class="col-sm-4 offset-sm-2">
                          <button type="submit" class="btn btn-secondary mb-2">
                            <i class="fas fa-times"></i> Cancel
                          </button>
                          <button type="submit" class="btn btn-primary mb-2" name="factsadd">
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
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/form-validator.js"></script>
    <script src="assets/js/script.js"></script>
  </body>
</html>
