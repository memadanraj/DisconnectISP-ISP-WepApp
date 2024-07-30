<?php
session_start();
// error_reporting(0);

?>
<!--  Strat Add Bloog php -->
<?php

if (isset($_POST['badd'])) {
    include 'db/connect.php';
    $b_title = $_POST['btitle'];
    $b_content = $_POST['bcontent'];

    // File information
    $file_name = $_FILES['bimg']['name'];
    $file_tmp = $_FILES['bimg']['tmp_name'];

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
            $stmt = $conn->prepare("INSERT INTO `blog` ( `b_title`, `b_img`, `b_content`) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $b_title,  $folder, $b_content);

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
<!--  End Add Blog php -->


<!--  Start Delete Blog php -->
<?php
if (isset($_POST['deleteblog'])) {
  include 'db/connect.php';

  $b_idd = $_POST['b_id'];

  // Get the old image file name
  $stmt = $conn->prepare("SELECT `b_img` FROM `blog` WHERE `b_id` = ?");
  $stmt->bind_param("i", $b_idd);
  $stmt->execute();
  $stmt->bind_result($oldd_image);
  $stmt->fetch();
  $stmt->close();

  // Delete the old image file if it exists
  if (file_exists($oldd_image)) {
      unlink($oldd_image);
  }

  // Prepare and execute the delete query
  $stmt = $conn->prepare("DELETE FROM `blog` WHERE `b_id` = ?");
  $stmt->bind_param("i", $b_idd);

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

<!--  End Delete Blog php -->

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PDS | Blog</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet" />
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet" />
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/master.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>


<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="/img/pdslogo2.png" alt="bootraper logo" class="app-logo w-50 p-1 ">
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
                    <a href="#uielementsmenu" data-bs-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i> Others</a>
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
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;"
                                        class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back
                                                ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i>
                                                Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i>
                                                Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>John Doe</span> <i style="font-size: .8em;"
                                        class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i>
                                                Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i>
                                                Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>
                                                Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->

            <!-- Strat Delete modal -->
            <div class="modal fade" id="deleteblogm" tabindex="-1" role="dialog" aria-labelledby="deletemodal"
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
                                                    <input type="hidden" id="dblog_id" name="b_id">
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
                                                                name="deleteblog">
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

            <div class="content">


                <div class="container">
                    <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']); 
                        }
                        ?>
                    <div class="page-title">
                        <h3>Blog</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">Add Blog</div>
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <form class="" method="POST" action="" enctype="multipart/form-data">
                                        <div class="mb-3 row">


                                            <!-- Blog Title  -->
                                            <label class="col-sm-2">Blog Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="btitle" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <br />

                                        <div class="mb-3 row">
                                            <!-- Blog Image Thumbnails  -->
                                            <label class="col-sm-2">Blog Inamge</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="bimg" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <br />

                                        <!-- blog edit here  -->
                                        <div class="mb-3 row">
                                            <label class="col-sm-2">Content</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="bcontent" id="summernote" cols="30" rows="10"></textarea>
                                            </div>
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
                                        <button type="submit" class="btn btn-primary mb-2" name="badd">
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

            <div class="col-md-12 col-lg-12">
                <div class="container mt-2">
                    <!-- Display the message -->
                </div>
                <div class="card">
                    <div class="card-header">Blog Info</div> <br>
                    <div class="card-body">
                        <p class="card-title"></p>
                        <table class="table table-hover" id="dataTables-example" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Date </th>
                                    <th>Blog Title</th>
                                    <th>Thumbnail </th>
                                    <th>Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                      include 'db/connect.php';

                      $sql= "SELECT * FROM `blog` ";
                      $result = $conn->query($sql); 

                    if ($result->num_rows > 0)  
                    { 
                        // OUTPUT DATA OF EACH ROW 
                        while($row = $result->fetch_assoc()) 
                        { 
                        

                          ?>

                                    <td><?php echo $row["b_id"] ?></td>

                                    <td><?php echo $row["b_pdate"] ?></td>
                                    <td><?php echo $row["b_title"] ?></td>
                                    <td><img src="<?php echo $row["b_img"] ?>" alt="" srcset="" width="100px"
                                            style="border: 2px solid rgb(92, 138, 92); background-color: green;"></td>
                                    <td>



                                        <button type="button" class="btn btn-success mb-2"><a
                                                href="updateblog.php? uid=<?php echo $row['b_id']; ?>">Update</a></button>
                                        <button type="button" class="btn btn-success mb-2"
                                            onclick=" deleteblogmodal('<?php echo $row['b_id']?>')">Delete </button>

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
    </div>
    </div>
    </div>

    <script>
    function deleteblogmodal(b_id) {
        document.getElementById('dblog_id').value = b_id;



        $('#deleteblogm').modal('show');
    }
</script>

    
<script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/form-validator.js"></script>
    <script src="assets/js/script.js"></script>

    <!-- ckeditor strat here  -->

    <!--
            The "superbuild" of CKEditor&nbsp;5 served via CDN contains a large set of plugins and multiple editor types.
            See https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/quick-start.html#running-a-full-featured-editor-from-cdn
        -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
        <!--
            Uncomment to load the Spanish translation
            <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/translations/es.js"></script>
        -->
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("summernote"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                ckfinder: {
      uploadUrl: 'uptest.php'
    },

                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Hey PDS Write Your Cool Blog Here !',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: false
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "superbuild" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'MultiLevelList',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            });
        </script>
<!-- ckeditor end here  -->
   


</body>

</html>