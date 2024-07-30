<?php
// Start output buffering and session
ob_start();
session_start();
require_once '../backend/db/connect.php';
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
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link href="../lib/animate/animate.min.css" type="text/css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" type="text/css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" type="text/css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" type="text/css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<!-- Your existing content -->

<!-- Booking Form Start -->
<div class="container-xxl bg-primary newsletter py-5 wow fadeInUp" id="connectnow" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <p class="section-title text-white justify-content-center"><span></span>Connect Now<span></span></p>
                <h1 class="text-center text-white mb-4">New Connection Book Now!</h1>
                <form id="bookingForm" action="processform.php" method="POST">
                    <div class="position-relative w-100 mt-3">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" name="fullName" placeholder="Full Name">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" name="phoneNumber" placeholder="Phone Number">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="email" name="email" placeholder="Email">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" name="address" placeholder="Address">
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <button class="custom-button" type="submit" name="bookform" style="width: 125px;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Booking Form End -->

<!-- Contact Form Start -->
<div class="container-xxl bg-light newsletter py-5 wow fadeInUp" id="contact" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <p class="section-title text-dark justify-content-center"><span></span>Contact Us<span></span></p>
                <h1 class="text-center text-dark mb-4">Get in Touch</h1>
                <form id="contactForm" action="processform.php" method="POST">
                    <div class="position-relative w-100 mt-3">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" name="contactName" placeholder="Full Name">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="text" name="contactSubject" placeholder="Subject">
                        <input class="form-control border-0 ps-4 pe-5 mb-3" type="email" name="contactEmail" placeholder="Email">
                        <textarea class="form-control border-0 ps-4 pe-5 mb-3" name="contactMessage" placeholder="Message"></textarea>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <button class="custom-button" type="submit" name="contactform" style="width: 125px;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Contact Form End -->

<!-- Include SweetAlert for feedback -->
<?php if (isset($_SESSION['form_submission'])): ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['form_submission']['status']; ?>',
        title: '<?php echo $_SESSION['form_submission']['title']; ?>',
        text: '<?php echo $_SESSION['form_submission']['message']; ?>'
    }).then(() => {
        window.location.href = 'index.php';
    });
</script>
<?php unset($_SESSION['form_submission']); endif; ?>

<!-- Include necessary JS files -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>

<?php
$conn->close();
ob_end_flush();
?>
