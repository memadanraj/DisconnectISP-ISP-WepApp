<?php
// Start output buffering and session
ob_start();
session_start();
require_once 'backend/db/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PDS- PDS Server Network</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/faviconfinal.svg" rel="icon">






    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <link href="lib/animate/animate.min.css" type="text/css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" type="text/css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" type="text/css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" type="text/css" rel="stylesheet">








    <style>
    .newsletter {
        background-color: #007bff;
        padding: 50px 0;
        color: white;
    }

    .newsletter .form-control {
        border: 2px solid #fff;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .newsletter .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }


    .newsletter .position-relative {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .newsletter input::placeholder {
        color: #bbb;
    }

    @media (min-width: 768px) {
        .newsletter .position-relative {
            flex-direction: row;
        }

        .newsletter .form-control,
        .newsletter .btn {
            margin-right: 10px;
            margin-bottom: 0;
        }

        .newsletter .form-control:last-child,
        .newsletter .btn:last-child {
            margin-right: 0;
        }
    }

    .custom-button {
        width: 171px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        background-color: rgb(69, 165, 85);
        border-radius: 30px;
        color: rgb(246, 244, 249);
        font-weight: 600;
        border: none;
        position: relative;
        cursor: pointer;
        transition-duration: .2s;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.116);
        padding-left: 8px;
        transition-duration: .5s;
    }

    .svgIcon {
        height: 25px;
        transition-duration: 1.5s;
        fill: rgb(246, 244, 249);
    }

    .bell path {
        fill: #45A555;
    }

    .custom-button:hover {
        background-color: rgb(251, 165, 4);
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 25px 0 rgba(0, 0, 0, 0.19);
        transition-duration: .5s;
    }

    .contact-custom:hover{
        background-color: rgb(251, 165, 4);
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 25px 0 rgba(0, 0, 0, 0.19);
        transition-duration: .5s;

    }

    .custom-button:active {
        transform: scale(0.97);
        transition-duration: .2s;
    }

    .custom-button:hover .svgIcon {
        transform: rotate(250deg);
        transition-duration: 1.5s;
    }

    .custom-button:hover .rsvgIcon {
        transform: rotate(360deg);
        transition-duration: 1.5s;
    }


    .radio-inputs {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        border-radius: 0.5rem;
        background-color: #fff;
        box-sizing: border-box;
        box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.06);
        padding: 0.25rem;
        width: 300px;
        font-size: 16px;
    }

    .radio-inputs:hover {
        box-shadow: 0 0 0px 0px rgba(0, 0, 0, 0.06);

    }

    .radio-inputs .radio {
        flex: 1 1 auto;
        text-align: center;
    }

    .radio-inputs .radio input {
        display: none;
    }

    .radio-inputs .radio .name {
        display: flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: none;
        padding: .5rem 0;
        color: #04000B;
        transition: all .15s ease-in-out;
    }

    .radio-inputs .radio input:checked+.name {
        background-color: #FBA504;
        font-weight: 550;
    }

    .fixed-size {
        width: 100%;
        height: 250px;
        object-fit: cover;
        /* This property makes sure the images cover the entire area while maintaining aspect ratio */
    }


    


    </style>

</head>

<body>



    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img class="m-0" src="img/PDS-LOGO-White.png" alt="Logo">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-expanded="false"><span class="fa fa-bars"></span></button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <div class="nav-item dropdown">
                            <a href="#packages" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Package</a>
                            <div class="dropdown-menu m-0">
                                <a href="#packages" class="dropdown-item">Internt</a>
                                <a href="#packages" class="dropdown-item">Internet & IPTV </a>
                                <!-- <a href="404.html" class="dropdown-item">404 Page</a> -->
                            </div>
                        </div>
                        <a href="#iptv" class="nav-item nav-link">IPTV</a>
                        <a href="" class="nav-item nav-link">Service & Support</a>
                        <a href="#outlets" class="nav-item nav-link">Outlets</a>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#contact" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="backend\login.php" class=" btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block"> <i
                            class="bi bi-lock"></i>
                        Login</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header" id="about">
                <div class="container px-lg-5">
                    <div class="row align-items-between">
                        <div class="col-lg-6 text-center text-lg-start pb-5">
                            <h1 class="text-white mb-4 animated slideInDown">A PDS Server Network Is Your ISP</h1>
                            <p class="text-white pb-3 animated slideInDown     text-align: justify">PDS Server Network is a Newly established
                                licensed Internet Service Provider (ISP) to
                                provide cheap and reliable internet for home , business entertainment etc. We are proud
                                of our creativity which attracts people to purchase our packages stuff. Let your soul
                                sparkle
                                with
                                PDS Server Network Pvt. Ltd.</p>
                            <a href="#connectnow"
                                class="btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Connect
                                Now</a>

                        </div>

                        <!-- slider start here  -->
                        <div class="col-lg-6 text-center text-lg-start mb-4">
                            <div id="carouselExampleIndicators" class="carousel slide rounded" data-bs-ride="carousel"
                                style="border: 4px solid #fff; background-color: #fff;">

                                <div class="carousel-indicators">
                                    <?php
                                      

                                        $sql = "SELECT * FROM `slider_pds`";
                                        $result = $conn->query($sql); 

                                        if ($result->num_rows > 0) {
                                            $i = 0;
                                            while ($row = $result->fetch_assoc()) { ?>
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="<?php echo $i; ?>"
                                        <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?>
                                        aria-label="Slide <?php echo $i + 1; ?>"></button>
                                    <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    echo "No Record Found!";
                                                }
                                                ?>
                                </div>

                                <div class="carousel-inner">
                                    <?php
                                        if ($result->num_rows > 0) {
                                            $i = 0;
                                            // Reset result pointer and fetch data again
                                            $result->data_seek(0);
                                            while ($row = $result->fetch_assoc()) { ?>
                                    <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                        <img src="backend/<?php echo $row['s_img']; ?>" class="img-fluid w-100 lazy"
                                            alt="...">
                                    </div>
                                    <?php
                                                        $i++;
                                                    }
                                                }
                                               
                                                ?>
                                </div>

                                <section>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar & Hero End -->




        <!-- popup offer modal start here  -->

            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content" >
                        <?php
                                $sql = "SELECT `popup_img`, `popup_name` FROM `popup_pds`";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel"><?php echo $row['popup_name'] ?></h5>
                            <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-0" >
                        
                                        <img src="backend/<?php echo $row['popup_img']; ?>" class="img-fluid w-100 lazy" alt="Responsive image">
                                    <?php
                                    }
                                } else {
                                    echo "No Record Found!";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>



        <!-- popup offer modal END here  -->


        <!-- pacakge start  here  -->


        <div class="container-xxl py-5" id="packages">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-secondary justify-content-center"><span></span>Packages<span></span>
                    </p>
                    <h1 class="text-center mb-5">What Suits You Most ?</h1>
                </div>
                <div class="container mt-5 text-center">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                        <div class="radio-inputs">
                            <label class="radio">
                                <input type="radio" name="options" id="residential" autocomplete="off" checked>
                                <span class="name">Internet</span>
                            </label>
                            <label class="radio">
                                <input type="radio" name="options" id="business" autocomplete="off">
                                <span class="name">Internet & IPTV</span>
                            </label>


                        </div>

                    </div>
                </div>

                <!-- Residential Plans -->
                <div id="residentialContent">
                    <div class="container mt-4 mb-3 text-center">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">


                            <div class="radio-inputs">
                                <label class="radio">
                                    <input type="radio" name="residentialOptions" id="oneYear" autocomplete="off"
                                        checked>
                                    <span class="name">Yearly</span>
                                </label>
                                <label class="radio">
                                    <input type="radio" name="residentialOptions" id="threeMonths" autocomplete="off">
                                    <span class="name">3 Month</span>
                                </label>

                                <label class="radio">
                                    <input type="radio" name="residentialOptions" id="Months" autocomplete="off">
                                    <span class="name">Monthly</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="oneYearContent">
                        <div class="row g-4">


                                            <?php
                                    

                                    $sql= "SELECT * FROM `package_pds` WHERE `p_period`='year'  AND `p_type`='internet'  ";
                                    $result = $conn->query($sql); 

                                    if ($result->num_rows > 0)  
                                    { 
                                        // OUTPUT DATA OF EACH ROW 
                                        while($row = $result->fetch_assoc()) 
                                        { 
                                            ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="service-item d-flex flex-column rounded">
                                    <div class="service-icon flex-shrink-0">
                                        <img class="card-img-top " src="backend\<?php echo $row["p_img"] ?>"
                                            alt="100mbps Package">
                                    </div>
                                    <h4 class="card-title mb-3"><?php echo $row["p_name"] ?></h4>
                                    <h5 class="card-text mb-3">Package:<?php echo $row["p_mbps"] ?></h5>
                                    <h5 class="card-text mb-3">Price: &#8360; <?php echo $row["p_price"] ?></h5>
                                    <h5 class="card-period mb-3">Period: 1 Year</h5>
                                    <p class="card-text">Benefits: <?php echo $row["p_info"] ?></p>
                                    <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                                            <?php
                                            } 
                                        }  
                                        else { 
                                            echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                                            <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                                            </center>'; 
                                        } 
                                       

                                    ?>


                            <!-- Add more cards for 1 Year plans here -->
                        </div>
                    </div>

                    <div id="threeMonthsContent" style="display:none;">
                        <div class="row g-4">
                            <?php
                                    

                                    $sql= "SELECT * FROM `package_pds` WHERE `p_period`='3month' AND `p_type`='internet'  ";
                                    $result = $conn->query($sql); 

                                    if ($result->num_rows > 0)  
                                    { 
                                        // OUTPUT DATA OF EACH ROW 
                                        while($row = $result->fetch_assoc()) 
                                        { 
                                            ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="service-item d-flex flex-column rounded">
                                    <div class="service-icon flex-shrink-0">
                                        <img class="card-img-top " src="backend\<?php echo $row["p_img"] ?>"
                                            alt="100mbps Package">
                                    </div>
                                    <h4 class="card-title mb-3"><?php echo $row["p_name"] ?></h4>
                                    <h5 class="card-text mb-3">Package:<?php echo $row["p_mbps"] ?></h5>
                                    <h5 class="card-text mb-3">Price: &#8360; <?php echo $row["p_price"] ?></h5>
                                    <h5 class="card-period mb-3">Period: 3 Month</h5>
                                    <p class="card-text">Benefits: <?php echo $row["p_info"] ?></p>
                                    <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                                         <?php
                                                } 
                                            }  
                                            else { 
                                                echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                                                <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                                                </center>'; 
                                            } 
                                           

                                        ?>


                            <!-- Add more cards for 3 Months plans here -->
                        </div>
                    </div>

                    <div id="MonthsContent" style="display:none;">
                        <div class="row g-4">
                                                <?php
                                        

                                        $sql= "SELECT * FROM `package_pds` WHERE `p_period`='1month' AND `p_type`='internet' ";
                                        $result = $conn->query($sql); 

                                        if ($result->num_rows > 0)  
                                        { 
                                            // OUTPUT DATA OF EACH ROW 
                                            while($row = $result->fetch_assoc()) 
                                            { 
                                                ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="service-item d-flex flex-column rounded">
                                    <div class="service-icon flex-shrink-0">
                                        <img class="card-img-top " src="backend\<?php echo $row["p_img"] ?>"
                                            alt="100mbps Package">
                                    </div>
                                    <h4 class="card-title mb-3"><?php echo $row["p_name"] ?></h4>
                                    <h5 class="card-text mb-3">Package:<?php echo $row["p_mbps"] ?></h5>
                                    <h5 class="card-text mb-3">Price: &#8360;  <?php echo $row["p_price"] ?></h5>
                                    <h5 class="card-period mb-3">Period: Monthly</h5>
                                    <p class="card-text">Benefits: <?php echo $row["p_info"] ?></p>
                                    <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                                            <?php
                                            } 
                                        }  
                                        else { 
                                            echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                                            <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                                            </center>'; 
                                        } 
                                       

                                    ?>



                            <!-- Add more cards for 3 Months plans here -->
                        </div>
                    </div>
                </div>

                <!-- Business Plans -->
                <div id="businessContent" style="display:none;">
                    <div class="container mt-4 mb-3 text-center">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <div class="radio-inputs">
                                <label class="radio">
                                    <input type="radio" name="businessOptions" id="oneYearIPTV" autocomplete="off"
                                        checked>
                                    <span class="name">Yearly</span>
                                </label>
                                <label class="radio">
                                    <input type="radio" name="businessOptions" id="threeMonthsIPTV" autocomplete="off">
                                    <span class="name">3 Months</span>
                                </label>
                                <label class="radio">
                                    <input type="radio" name="businessOptions" id="monthlyIPTV" autocomplete="off">
                                    <span class="name">Monthly</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="container mt-4 ">

                        <div id="oneYearIPTVContent">
                            <div class="row g-4">
                                <?php
                                    

                                    $sql= "SELECT * FROM `package_pds` WHERE `p_period`='Year' AND `p_type`='internetTv'  ";
                                    $result = $conn->query($sql); 

                                    if ($result->num_rows > 0)  
                                    { 
                                        // OUTPUT DATA OF EACH ROW 
                                        while($row = $result->fetch_assoc()) 
                                        { 
                                            ?>
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="service-item d-flex flex-column rounded">
                                        <div class="service-icon flex-shrink-0">
                                            <img class="card-img-top " src="backend\<?php echo $row["p_img"] ?>"
                                                alt="100mbps Package">
                                        </div>
                                        <h4 class="card-title mb-3"><?php echo $row["p_name"] ?></h4>
                                        <h5 class="card-text mb-3">Package:<?php echo $row["p_mbps"] ?></h5>
                                        <h5 class="card-text mb-3">Price: &#8360; <?php echo $row["p_price"] ?></h5>
                                        <h5 class="card-period mb-3">Period: 1 Year</h5>
                                        <p class="card-text">Benefits: <?php echo $row["p_info"] ?></p>
                                        <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>

                                <?php
                                                } 
                                            }  
                                            else { 
                                                echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                                                <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                                                </center>'; 
                                            } 
                                           

                                        ?>
                            </div>

                        </div>

                        <div id="threeMonthsIPTVContent" style="display:none;">
                            <div class="row g-4">
                                <?php
                                    

                                    $sql= "SELECT * FROM `package_pds` WHERE `p_period`='3month' AND `p_type`='internetTv'  ";
                                    $result = $conn->query($sql); 

                                    if ($result->num_rows > 0)  
                                    { 
                                        // OUTPUT DATA OF EACH ROW 
                                        while($row = $result->fetch_assoc()) 
                                        { 
                                            ?>
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="service-item d-flex flex-column rounded">
                                        <div class="service-icon flex-shrink-0">
                                            <img class="card-img-top " src="backend\<?php echo $row["p_img"] ?>"
                                                alt="100mbps Package">
                                        </div>
                                        <h4 class="card-title mb-3"><?php echo $row["p_name"] ?></h4>
                                        <h5 class="card-text mb-3">Package:<?php echo $row["p_mbps"] ?></h5>
                                        <h5 class="card-text mb-3">Price: &#8360; <?php echo $row["p_price"] ?></h5>
                                        <h5 class="card-period mb-3">Period: 3 Month</h5>
                                        <p class="card-text">Benefits: <?php echo $row["p_info"] ?></p>
                                        <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>

                                <?php
                                                } 
                                            }  
                                            else { 
                                                echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                                                <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                                                </center>'; 
                                            } 
                                           

                                        ?>
                                <!-- Business 3 Months Plans Here -->
                            </div>
                        </div>
                        <div id="monthlyIPTVContent" style="display:none;">
                            <div class="row g-4">
                                <?php
                                    

                                    $sql= "SELECT * FROM `package_pds` WHERE `p_period`='1month' AND `p_type`='internetTv'  ";
                                    $result = $conn->query($sql); 

                                    if ($result->num_rows > 0)  
                                    { 
                                        // OUTPUT DATA OF EACH ROW 
                                        while($row = $result->fetch_assoc()) 
                                        { 
                                            ?>
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="service-item d-flex flex-column rounded">
                                        <div class="service-icon flex-shrink-0">
                                            <img class="card-img-top " src="backend\<?php echo $row["p_img"] ?>"
                                                alt="100mbps Package">
                                        </div>
                                        <h4 class="card-title mb-3"><?php echo $row["p_name"] ?></h4>
                                        <h5 class="card-text mb-3">Package:<?php echo $row["p_mbps"] ?></h5>
                                        <h5 class="card-text mb-3">Price: &#8360; <?php echo $row["p_price"] ?></h5>
                                        <h5 class="card-period mb-3">Period: Monthly</h5>
                                        <p class="card-text">Benefits: <?php echo $row["p_info"] ?></p>
                                        <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>

                                <?php
                                                } 
                                            }  
                                            else { 
                                                echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                                                <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                                                </center>'; 
                                            } 
                                           

                                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- package ends here -->





        <!-- iptv Start -->
        <div class="container-xxl  py-5" id="iptv">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-secondary justify-content-center"><span></span>IPTV<span></span></p>
                    <h1 class="text-center mb-5">Enjoy With IPTV & Internet </h1>
                </div>

                <div class="row g-4">
                     <div class="col-lg-4 col-md-6 wow   fadeInUp" data-wow-delay="0.1s">


                        <div class="service-item d-flex iptv flex-column text-center rounded">

                            <div class="service-icon flex-shrink-0">
                               
                                <img src="img/tvfinal.svg" alt="" srcset="" width="76%">
                            </div>
                            <h4 class="mb-3">Live TV</h4>
                            <h5 class="mb-3">Over 200+ Hd Channels</h5>




                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>

                    </div>
                    <?php
                        
                        $sql= "SELECT * FROM `tv_pds` ";
                        $result = $conn->query($sql); 

                                if ($result->num_rows > 0)  
                                { 
                                // OUTPUT DATA OF EACH ROW 
                                while($row = $result->fetch_assoc()) 
                                { 

                                    ?>
                    <div class="col-lg-4 col-md-6 wow   fadeInUp" data-wow-delay="0.1s">


                        <div class="service-item d-flex  flex-column text-center rounded">

                            <div class="service-icon flex-shrink-0">
                                <!-- <i class="fa fa-search fa-2x"></i> -->
                                <img src="backend\<?php echo $row['tv_img']?>" alt="" srcset="" width="60%">

                            </div>
                            <h4 class="mb-3"><?php echo $row['tv_name']?></h4>
                            <h5 class="mb-3"><?php echo $row['tv_info']?></h5>




                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>

                    </div>

                    <?php
                              } 
                          }  
                          else { 
                            echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                            <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                            </center>'; 
                          } 
                         

                      ?>

                </div>
            </div>
        </div>
        <!-- iptv End -->


                            <?php
                    
                    $sql = "SELECT * FROM `fact_pds`";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $f_exp=$row['f_exp'];
                    $f_team=$row['f_team'];
                    $f_sclient=$row['f_tclient'];

                    $f_cclient=$row['f_cclient'];
                    
                    

                    ?>
        <!-- Facts Start -->


        <div class="container-xxl bg-primary fact py-5 wow fadeInUp" data-wow-delay="0.1s">

            <div class="container py-5 px-lg-5">

                <div class="row g-4">


                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                        <i class="fa fa-certificate fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up"><?php  echo $f_exp?></h1>
                        <p class="text-white mb-0">Years Experience</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                        <i class="fa fa-users-cog fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up"><?php  echo $f_team?> </h1>
                        <p class="text-white mb-0">Team Members</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up"><?php  echo $f_sclient?> </h1>
                        <p class="text-white mb-0">Satisfied Clients</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">

                        <i class="fa fa-building fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up"><?php  echo $f_cclient?> </h1>
                        <p class="text-white mb-0">Corporate Clients</p>
                    </div>

                </div>

            </div>
        </div>
        <!-- Facts End -->



        <!-- Outlets  Start -->

        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" id="outlets">
            <div class="container py-5 px-lg-5">
                <p class="section-title text-secondary justify-content-center"><span></span>Outlates<span></span></p>
                <h1 class="text-center mb-5">From Where we support !</h1>
                <div class="owl-carousel testimonial-carousel">


                    <?php
                        
                        $sql= "SELECT * FROM `branch_pds` ";
                        $result = $conn->query($sql); 

                                if ($result->num_rows > 0)  
                                { 
                                // OUTPUT DATA OF EACH ROW 
                                while($row = $result->fetch_assoc()) 
                                { 

                                    ?>
                    <div class="testimonial-item bg-light rounded my-4">
                        <h4><i class="fa fa-wifi fa-4x text-primary mt-n4 me-3"></i><?php echo $row['branch_name']; ?>
                        </h4>

                        <p class="fs-5 " style="font-family: 'Jost', sans-seri;"> <i
                                class="fa fa-map-marker-alt text-primary mt-n4 me-3"> </i>
                            <?php echo $row['branch_location']; ?> </p>
                        <p class="fs-5" style="font-family: 'Jost', sans-seri;"> <i
                                class="fa fa-phone-square-alt text-primary mt-n4 me-3"> </i>Contact :
                            <?php echo $row['branch_contact']; ?></p>
                        <p class="fs-5" style="font-family: 'Jost', sans-seri;"><i
                                class="fa fa-envelope text-primary mt-n4 me-3"> </i>Email :
                            <?php echo $row['branch_email']; ?></p>

                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="img/location img.webp"
                                style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h4 class="mb-3">PDS Server Network </h4>
                                <a href="<?php echo $row['branch_direction']; ?>" target="_blank">

                                    <button class="custom-button">
                                        <svg class="svgIcon" viewBox="0 0 512 512" height="1em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm50.7-186.9L162.4 380.6c-19.4 7.5-38.5-11.6-31-31l55.5-144.3c3.3-8.5 9.9-15.1 18.4-18.4l144.3-55.5c19.4-7.5 38.5 11.6 31 31L325.1 306.7c-3.2 8.5-9.9 15.1-18.4 18.4zM288 256a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z">
                                            </path>
                                        </svg>
                                        Get Directions
                                    </button></a>

                            </div>
                        </div>
                    </div>

                    <?php
                              } 
                          }  
                          else { 
                            echo '<center><h4 class="card-title mb-3"> Availabe Soon!</h4> 
                            <img src="img/package unavilabe.png" alt="pds network package not found" width="30%">
                            </center>'; 
                          } 
                         

                      ?>

                </div>
            </div>
        </div>


        <!-- Outlets  End -->



      <!-- Booking Form Start from Here / connect now  -->
        <div class="container-xxl bg-primary newsletter py-5 wow fadeInUp" id="connectnow" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center">
                        <p class="section-title text-white justify-content-center"><span></span>Connect Now<span></span></p>
                        <h1 class="text-center text-white mb-4">New Connection Book Now!</h1>
                        <form id="bookingForm" action="process_booking.php" method="POST">
                            <div class="position-relative w-100 mt-3">
                                <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" id="full_name" name="full_name" placeholder="Full Name">
                                <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" id="phone_number" name="phone_number" placeholder="Phone Number">
                                <input class="form-control border-0 ps-4 pe-5 mb-3" type="email" id="email" name="email" placeholder="Email">
                                <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" id="address" name="address" placeholder="Address">
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <button class="custom-button" type="submit" style="width: 125px;">
                                <svg class="rsvgIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-router-fill" viewBox="0 0 16 16">
                                    <path d="M5.525 3.025a3.5 3.5 0 0 1 4.95 0 .5.5 0 1 0 .707-.707 4.5 4.5 0 0 0-6.364 0 .5.5 0 0 0 .707.707" />
                                    <path d="M6.94 4.44a1.5 1.5 0 0 1 2.12 0 .5.5 0 0 0 .708-.708 2.5 2.5 0 0 0-3.536 0 .5.5 0 0 0 .707.707Z" />
                                    <path d="M2.974 2.342a.5.5 0 1 0-.948.316L3.806 8H1.5A1.5 1.5 0 0 0 0 9.5v2A1.5 1.5 0 0 0 1.5 13H2a.5.5 0 0 0 .5.5h2A.5.5 0 0 0 5 13h6a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5h.5a1.5 1.5 0 0 0 1.5-1.5v-2A1.5 1.5 0 0 0 14.5 8h-2.306l1.78-5.342a.5.5 0 1 0-.948-.316L11.14 8H4.86zM2.5 11a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m4.5-.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0m2.5.5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m1.5-.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0m2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0" />
                                    <path d="M8.5 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                </svg>
                                    Book Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking Form END from Here / connect now  -->







        <!-- Contact Start -->
    <div class="container-xxl py-5 bg-white" id="contact">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <p class="section-title text-secondary justify-content-center"><span></span>Contact Us<span></span></p>
                <h1 class="text-center mb-5">Contact For Any Query</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="wow fadeInUp" data-wow-delay="0.3s">
                        <p class="text-center mb-4">Text Anything if you want</p>
                        <form id="contactForm" action="process_form.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
                                        <label for="name"> Name</label>
                                        <div class="error" id="nameError">Name should contain only letters and spaces.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="Eemail" name="email" placeholder="Email">
                                        <label for="email">Email</label>
                                        <div class="error" id="emailError">Invalid email format.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" >
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" id="message" name="message" style="height: 150px"></textarea>
                                        <label for="message">Message</label>
                                        <div class="error" id="messageError">Message should be at least 10 characters long.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft" type="submit" style="color: #fff;">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!-- Contact End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Address<span></span></p>
                        <p><i class="fa fa-map-marker-alt me-3"></i>Sauraha Chowk ,Tandi ,Chitwan</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+977-9888888888</p>
                        <p><i class="fa fa-envelope me-3"></i>info@pdsnp.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social"
                                href="https://www.facebook.com/pdsservernetwork"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Quick Link<span></span></p>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="blogs.php">Blogs</a>
                        <a class="btn btn-link" href="privacy&policy.php">Privacy Policy</a>
                        <a class="btn btn-link" href="terms-condition.php">Terms & Condition</a>
                        <a class="btn btn-link" href="career.php">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Download App<span></span></p>
                       
                      
                        <div class="row g-2">
                            <div class="col-4">
                            <a class="btn btn-outline-light btn-social" href=""><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-google-play" viewBox="0 0 16 16">
  <path d="M14.222 9.374c1.037-.61 1.037-2.137 0-2.748L11.528 5.04 8.32 8l3.207 2.96zm-3.595 2.116L7.583 8.68 1.03 14.73c.201 1.029 1.36 1.61 2.303 1.055zM1 13.396V2.603L6.846 8zM1.03 1.27l6.553 6.05 3.044-2.81L3.333.215C2.39-.341 1.231.24 1.03 1.27"/>
</svg></i></a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <p class="section-title text-white h5 mb-4">Newsletter<span></span></p>
                        <p>Sign Up to our newsletter for our offers and blogs notify !</p>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">PDS Server Network</a>, All Right Reserved.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a class="border-bottom" href="https://madankharel.com.np">Disconnect</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Blogs</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    </div>










    <!-- JavaScript Libraries -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>




 <!-- contact form script start here  -->

 <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Booking Form
        document.getElementById("bookingForm").addEventListener("submit", function(event) {
            event.preventDefault();
            
            var fullName = document.getElementById("full_name").value.trim();
            var phoneNumber = document.getElementById("phone_number").value.trim();
            var email = document.getElementById("email").value.trim();
            var address = document.getElementById("address").value.trim();

            if (!/^[a-zA-Z ]+$/.test(fullName)) {
                swal({
                    title: "Error",
                    text: "Invalid name. Only letters and spaces are allowed.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }
            if (!/^[0-9]+$/.test(phoneNumber)) {
                swal({
                    title: "Error",
                    text: "Invalid phone number. Only numbers are allowed.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                swal({
                    title: "Error",
                    text: "Invalid email format.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }
            if (address === "") {
                swal({
                    title: "Error",
                    text: "Address cannot be empty.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }

            var formData = new FormData(this);

            fetch("backend/process_booking.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes("Your booking has been submitted successfully!")) {
                    swal({
                        title: "Thank you!",
                        text: "Your booking has been submitted successfully!",
                        type: "success",
                        confirmButtonColor: "#45A555"
                    });
                    this.reset();
                } else {
                    swal({
                        title: "Error",
                        text: data,
                        type: "warning",
                        confirmButtonColor: "#FAA505"
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                swal({
                    title: "Error",
                    text: "There was an error submitting your booking.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
            });
        });

        // Contact Form
        document.getElementById("contactForm").addEventListener("submit", function(event) {
            event.preventDefault();

            var name = document.getElementById("name").value.trim();
            var email = document.getElementById("Eemail").value.trim();
            var subject = document.getElementById("subject").value.trim();
            var message = document.getElementById("message").value.trim();

            if (!/^[a-zA-Z ]+$/.test(name)) {
                swal({
                    title: "Error",
                    text: "Invalid name. Only letters and spaces are allowed.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }
            var emailRegex = /^\S+@\S+\.\S+$/;
            if (!emailRegex.test(email)) {
                swal({
                    title: "Error",
                    text: "Invalid email format.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }
            if (subject === "") {
                swal({
                    title: "Error",
                    text: "Subject cannot be empty.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }
            if (message.length < 10) {
                swal({
                    title: "Error",
                    text: "Message should be at least 10 characters long.",
                    type: "warning",
                    confirmButtonColor: "#FAA505"
                });
                return;
            }

            var formData = new FormData(this);

            fetch("backend/process_form.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes("Your message has been sent successfully!")) {
                    swal({
                        title: "Thank you!",
                        text: "Your message has been sent successfully!",
                        type: "success",
                        confirmButtonColor: "#45A555"
                    });
                    this.reset();
                } else {
                    swal({
                        title: "Error",
                        text: data,
                        type: "error",
                        confirmButtonColor: "#FAA505"
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                swal({
                    title: "Error",
                    text: "There was an error submitting your form.",
                    type: "error",
                    confirmButtonColor: "#FAA505"
                });
            });
        });
    });
</script>



     <!-- contact form script end here  -->


    
    <!-- popup offer script start -->

    <script>
    // Ensure modal closes on button click
    $(document).ready(function() {
        $("#imageModal").modal('show');

        // Attach event listener to close button
        $(".btn-close").click(function() {
            $("#imageModal").modal('hide');
        });
    });
    </script>

    <!-- popup offer script end  -->
    
    <!-- package script here  -->

    <script>
    $(document).ready(function() {
        $('input[type=radio][name=options]').change(function() {
            if (this.id == 'residential') {
                $('#residentialContent').show();
                $('#businessContent').hide();

                // Apply blue background to residential options
                $('input[name=residentialOptions] + .name').removeClass('active-bg-green').addClass(
                    'active-bg-blue');

                // Remove any active state from business options
                $('input[name=businessOptions] + .name').removeClass('active-bg-green active-bg-blue');
            } else if (this.id == 'business') {
                $('#residentialContent').hide();
                $('#businessContent').show();

                // Apply green background to business options
                $('input[name=businessOptions] + .name').removeClass('active-bg-blue').addClass(
                    'active-bg-green');

                // Remove any active state from residential options
                $('input[name=residentialOptions] + .name').removeClass(
                    'active-bg-green active-bg-blue');
            }
        });

        $('input[type=radio][name=residentialOptions]').change(function() {
            if (this.id == 'oneYear') {
                $('#oneYearContent').show();
                $('#threeMonthsContent').hide();
                $('#MonthsContent').hide();
            } else if (this.id == 'threeMonths') {
                $('#oneYearContent').hide();
                $('#threeMonthsContent').show();
                $('#MonthsContent').hide();
            } else if (this.id == 'Months') {
                $('#oneYearContent').hide();
                $('#threeMonthsContent').hide();
                $('#MonthsContent').show();
            }
        });

        $('input[type=radio][name=businessOptions]').change(function() {
            if (this.id == 'oneYearIPTV') {
                $('#oneYearIPTVContent').show();
                $('#threeMonthsIPTVContent').hide();
                $('#monthlyIPTVContent').hide();
            } else if (this.id == 'threeMonthsIPTV') {
                $('#oneYearIPTVContent').hide();
                $('#threeMonthsIPTVContent').show();
                $('#monthlyIPTVContent').hide();
            } else if (this.id == 'monthlyIPTV') {
                $('#oneYearIPTVContent').hide();
                $('#threeMonthsIPTVContent').hide();
                $('#monthlyIPTVContent').show();
            }
        });
    });


    // Initialize the wow.js library
    new WOW().init();
    </script>

    <!-- package script end here  -->




 <!-- slider script strat  here  -->

    <script>
    const myCarouselElement = document.querySelector('#myCarousel')

    const carousel = new bootstrap.Carousel(myCarouselElement, {
        interval: 2000,
        touch: false
    })
    </script>
    <!-- slider script END  here  -->

    
   

    <!-- main Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php
$conn->close();

ob_end_flush(); 
?>