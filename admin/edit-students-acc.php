<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();

    // Check if form is submitted for updating student information
    if(isset($_POST['update'])) {
        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $course = $_POST['course'];
        $contactNo = $_POST['contactNo'];
        $email = $_POST['email'];

        // Update the student's information in the database
        $update_query = "UPDATE userregistration SET firstName=?, middleName=?, lastName=?, gender=?, course=?, contactNo=?, email=? WHERE id=?";
        $stmt = $mysqli->prepare($update_query);
        $stmt->bind_param('sssssssi', $firstName, $middleName, $lastName, $gender, $course, $contactNo, $email, $id);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Student information updated successfully');
        window.location.href='view-students-acc.php';
        </script>";
        // Redirect back to view page
    }

    
    
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <!-- Head content here -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
</head>
<body>
<div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <header class="topbar" data-navbarbg="skin6">
            <?php include 'includes/navigation.php'?>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include 'includes/sidebar.php'?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>

<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Student Details</h4>
                        <div class="d-flex align-items-center">
                            <!-- <nav aria-label="breadcrumb">
                                
                            </nav> -->
                        </div>
                    </div>
                    
                </div>
            </div>
    <!-- Form to edit student information -->
    <div class="container-fluid">
       <form method="post">
       <div class="row">

      <!-- // Retrieve student information based on ID from URL parameter -->
                  <?php
                  if(isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $fetch_query = "SELECT * FROM userregistration WHERE id=?";
                    $stmt = $mysqli->prepare($fetch_query);
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $student = $result->fetch_assoc();
                    $stmt->close();
                  ?>
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">First Name</h4>
                                        <div class="form-group">
                                        <input type="text" name="firstName" value="<?php echo $student['firstName']; ?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">Middle Name</h4>
                                        <div class="form-group">
                                        <input type="text" name="middleName" value="<?php echo $student['middleName']; ?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">Last Name</h4>
                                        <div class="form-group">
                                        <input type="text" name="lastName" value="<?php echo $student['lastName']; ?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">Gender</h4>
                                        <div class="form-group">
                                        <input type="text" name="gender" value="<?php echo $student['gender']; ?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">Course</h4>
                                        <div class="form-group">
                                            <select class="custom-select mr-sm-2" id="course" name="course">
                                                <option selected>Please Select...</option>
                                                <?php $query ="SELECT * FROM courses";
                                                    $stmt2 = $mysqli->prepare($query);
                                                    $stmt2->execute();
                                                    $res=$stmt2->get_result();
                                                    while($row=$res->fetch_object())
                                                    {
                                                ?>
                                                <option value="<?php echo $row->course_fn;?>"><?php echo $row->course_fn;?>&nbsp;&nbsp;(<?php echo $row->course_sn;?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">Contact</h4>
                                        <div class="form-group">
                                        <input type="text" name="contactNo" value="<?php echo $student['contactNo']; ?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">    
                                    <h4 class="card-title">Email</h4>
                                        <div class="form-group">
                                        <input type="text" name="email" value="<?php echo $student['email']; ?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>
                
                 <?php } ?>
        </div>
                 <div class="form-actions">
                            <div class="text-center">
                            <button type="submit" name="update" class="btn btn-success">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>  
        
         </form>
    </div>

  </div>

</div>
<!-- <button input type="submit" name="update" value="Update">Update</button> -->
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>

</body>
</html>
