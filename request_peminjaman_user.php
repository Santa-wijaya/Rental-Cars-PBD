<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_pelanggan"])) {
        header("location: form_login.php");
        exit;
    }
    $id = $_SESSION["id_akun"];
    $tuples = read("SELECT * FROM request_peminjaman WHERE ID_akun = '$id' ORDER BY ID_peminjaman DESC;");

    if(isset($_POST["submit-pembayaran"])) {
        $status_unggah = null;
        $status_unggah = uploadBuktiPembayaran($_POST, $_FILES);
        if (isset($status_unggah)) {
          if ($status_unggah === true) {
            $_SESSION["bool_status_unggah"] = true;
          } else {
            $_SESSION["bool_status_unggah"] = false;
          }
          header("location: request_peminjaman_user.php");
          exit;
        }
    }

    if(isset($_POST["submit-search-status-request"])) {
      $keyword = $_POST["search-status-request"];
      if($keyword == 0) {
        $tuples = read("SELECT * FROM request_peminjaman WHERE ID_akun = '$id' AND status_peminjaman = 'rejected' ORDER BY ID_peminjaman DESC;");
      } elseif ($keyword == 1) {
        $tuples = read("SELECT * FROM request_peminjaman WHERE ID_akun = '$id' AND status_peminjaman = 'accepted' ORDER BY ID_peminjaman DESC;");
      } elseif ($keyword == 2) {
        $tuples = read("SELECT * FROM request_peminjaman WHERE ID_akun = '$id' AND status_peminjaman = 'not accepted yet' ORDER BY ID_peminjaman DESC;");
      }
      
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rental User</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="beranda_user.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    
                </div>
                <div class="sidebar-brand-text mx-3">Rental User</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard User</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Main Features
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pelayanan User</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Main Features:</h6>
                        <a class="collapse-item" href="profil_user.php">Profile</a>
                        <a class="collapse-item" href="request_peminjaman_user.php">Request Peminjaman</a>
                        <a class="collapse-item" href="list_peminjaman_user.php">Layanan Peminjaman</a>
                        <a class="collapse-item" href="list_pengembalian_user.php">layanan Pengembalian</a>
                    </div>
                </div>
                
            </li>

            

            <!-- Divider -->
            <hr class="sidebar-divider">

            

            

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                   

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        
                        

                        
                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="logoutlogic.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class = "content">
    <form action="" method="post" autocomplete="off" class="search-form d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <div class="utility-bar">
            <div></div>
            <div class="input-group ">
              <div class="form-floating">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="search-status-request" required>
                  <option value=-1 selected>Pilih Status Reguest</option>
                  <option value="0">Ditolak</option>
                  <option value="1">Disetujui</option>
                  <option value="2">Tunggu Persetujuan</option>
                </select>
                
              </div>
              <button type="submit" class="btn btn-primary searchbtn d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100" name="submit-search-status-request"><i class="fas fa-search fa-sm"></i></button>
            </div>
            
        </div>
      </form>

        <div class="row card-container">
            <?php if(isset($_SESSION["bool_status_unggah"]) && $_SESSION["bool_status_unggah"] === true): ?>
              <div class="mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 alert alert-success alert-dismissible fade show mx-auto" role="alert">
                  Bukti pembayaran berhasil diunggah!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION["bool_status_unggah"]); ?>
            <?php elseif(isset($_SESSION["bool_status_unggah"]) && $_SESSION["bool_status_unggah"] === false): ?>
                <div class="mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
                    File yang diunggah bukan .jpg/.jpeg/.png atau melebihi 2MB! Bukti pembayaran tidak berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php unset($_SESSION["bool_status_unggah"]); ?>
            <?php endif; ?>
            <?php foreach ($tuples as $tuple): ?>
                <?php if($tuple["status_peminjaman"] === "not accepted yet"):?>
                    <?php $status = "Tunggu Persetujuan";?>
                <?php elseif($tuple["status_peminjaman"] === "accepted"):?>
                    <?php $status = "Disetujui! Lakukan pembayaran ke 88880888 (BNI) A.N. ronaldito teja, unggah bukti pembayaran anda!";?>
                <?php elseif($tuple["status_peminjaman"] === "rejected"):?>
                    <?php $status = "Ditolak!";?>
                    <?php elseif($tuple["status_peminjaman"] === "not valid payment"):?>
                    <?php $status = "Pembayaran tidak valid! Perbaharui unggahan pembayaran!";?>
                <?php endif;?>
                <?php if($tuple["status_peminjaman"] === "not accepted yet"):?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" class="img-fluid"  alt="..." style=" max-width: 100%;" >
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <p class="card-text">Driver: <?= $tuple["opsi_driver"] ?></p>
                                    <!-- <p class="card-text">Jumlah Helper: <?= $tuple["jumlah_helper"] ?></p> -->
                                    <p class="card-text">Status: <?= $status ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php elseif($tuple["status_peminjaman"] === "rejected"): ?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" class="img-fluid"  alt="..." style=" max-width: 100%;">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <p class="card-text">Driver: <?= $tuple["opsi_driver"] ?></p>
                                    <!-- <p class="card-text">Jumlah Helper: <?= $tuple["jumlah_helper"] ?></p> -->
                                    <p class="card-text">Status: <?= $status ?> </p>
                                    <p class="card-text">Keterangan penolakan: <?= $tuple["keterangan"] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif($tuple["status_peminjaman"] === "accepted" | $tuple["status_peminjaman"] === "not valid payment"): ?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" class="img-fluid"  alt="..." style=" max-width: 100%;">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <p class="card-text">Driver: <?= $tuple["opsi_driver"] ?></p>
                                    <!-- <p class="card-text">Jumlah Helper: <?= $tuple["jumlah_helper"] ?></p> -->
                                    <p class="card-text">Status: <?= $status ?> </p>
                                    <p class="card-text">Total Harga: Rp<?= $tuple["harga_peminjaman"] ?></p>
                                </div>
                            </div>
                            <?php if(is_null($tuple["gambar_bukti_pembayaran"])): ?>
                              <div class="col-md-3 mt-3 d-flex align-items-center">
                                  <a class="btn btn-outline-dark btn-lg offset-3" href="#" role="button"  onclick="uploadPayment(<?= $tuple['ID_peminjaman'] ?>)">Unggah Bukti Pembayaran</a>
                              </div>
                            <?php else: ?>
                                <div class="col-md-3 mt-3 d-flex align-items-center">
                                  <a class="btn btn-outline-dark btn-lg offset-3" href="#" role="button" onclick="uploadPayment(<?= $tuple['ID_peminjaman'] ?>)">Perbaharui Bukti Pembayaran</a>
                              </div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Unggah Bukti Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="acceptRequestForm">
              <div class="form-group">
                    <label for="ID-peminjaman-payment" class="col-form-label d-none">ID peminjaman</label>
                    <input type="text" class="form-control d-none" id="ID-peminjaman-payment" name="ID-peminjaman-payment" readonly>
              </div>
              <div class="form-group">
                  <label for="bukti-pembayaran" class="col-form-label">Bukti Pembayaran</label>
                  <input type="file" class="form-control" id="bukti-pembayaran" name="bukti-pembayaran" accept = "image/jpeg, image/jpg, image/png" required>
              </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-pembayaran">Unggah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Rental Cars PBD Kelas C</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logoutlogic.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    

     <!-- JAVASCRIPT --> 
    <script type="text/javascript">
        function uploadPayment(id_peminjaman){
            var myModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            document.getElementById("ID-peminjaman-payment").value = id_peminjaman;
            myModal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>