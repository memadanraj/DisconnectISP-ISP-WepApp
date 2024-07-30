<?php
session_start();
// error_reporting(0);

?>
<!--  Strat update Bloog php -->


<?php
 include 'db/connect.php';

    
$uid = $_GET['uid'];
$sql = "SELECT * FROM `blog` WHERE `b_id`= '$uid'";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_assoc($result);
 $title=$row['b_title'];
 $content=$row['b_content'];

 if(isset($_POST['bupdate'])){
    $b_title = $_POST['btitle'];
    $b_content = $_POST['bcontent'];


    $file_name = $_FILES['ubimg']['name'];
    $file_tmp = $_FILES['ubimg']['tmp_name'];
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
          $stmt = $conn->prepare("SELECT `b_img` FROM `blog` WHERE `b_id` = ?");
          $stmt->bind_param("i", $uid);
          $stmt->execute();
          $stmt->bind_result($old_image);
          $stmt->fetch();
          $stmt->close();
  
          if (file_exists($old_image)) {
            unlink($old_image);
          }
  
          $stmt = $conn->prepare("UPDATE blog SET`b_img` = ?, b_title = ?, b_content = ? WHERE b_id = ?");
          $stmt->bind_param("sssi", $folder, $b_title, $b_content, $uid);
        } else {
          $_SESSION['msg'] = "Failed to upload file.";
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
        }
      }
    } else {
        $stmt = $conn->prepare("UPDATE blog SET b_title = ?, b_content = ? WHERE b_id = ?");
        $stmt->bind_param("ssi",  $b_title, $b_content, $uid);
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
  
    header('Location: blog.php');
    exit();
  }



?>

<!--  End update Blog php -->

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PDS | Blog</title>
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
<style>

.ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 200px;
            }
            .ck-content .image {
                /* Block images */
                max-width: 80%;
                margin: 20px auto;
            }
</style>
  <body>
    <div class="wrapper">
      <nav id="sidebar" class="active">
          <div class="sidebar-header">
              <img src="/img/pdslogo2.png" alt="bootraper logo" class="app-logo w-50 p-1 "  >
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
        <!-- end of navbar navigation -->

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
                  <div class="card-header">Update Blog</div>
                  <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form class="" method="POST" action="" enctype="multipart/form-data">
                      <div class="mb-3 row">
                        

                        <!-- Blog Title  -->
                        <label class="col-sm-2">Blog Title</label>
                        <div class="col-sm-10">
                          <input type="text" name="btitle" class="form-control"  value ="<?php echo $title;  ?>" required />
                        </div>
                      </div>
                      <div class="line"></div>
                      <br />

                      <div class="mb-3 row">
                       <!-- Blog Image Thumbnails  -->
                      <label class="col-sm-2">Blog Image</label>
                      <div class="col-sm-10">
                        <input type="file" name="ubimg" class="form-control"   />
                      </div>
                        </div>
                     <div class="line"></div>
                        <br />

                        <!-- blog edit here  -->
                        <label class="col-sm-2">Content</label>
                        <div class="col-sm-10">
                            <textarea  class="form-control "name="bcontent" id="editor" cols="30" rows="10"> <?php echo $content  ?></textarea>
                         
                        </div>
                      </div>
                      <div class="line"></div>
                      <br />
<?php
   $conn->close();
?>
                      <!-- submit -->

                      <div class="line"></div>
                      <br />
                      <div class="mb-3 row">
                        <div class="col-sm-4 offset-sm-2">
                          <button type="submit" class="btn btn-danger mb-2">
                            <i class="fas fa-times"></i> Cancel
                          </button>
                          <button type="submit" class="btn btn-primary mb-2" name="bupdate">
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
            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
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
      uploadUrl: 'ckeditor.php'
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
