<?php 
	session_start();
	require 'functions.php';
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
    
    $tuples = read("SELECT detail_peminjaman.*, tanggal_pengembalian_sebenarnya FROM detail_peminjaman LEFT JOIN pengembalian ON pengembalian.ID_peminjaman = detail_peminjaman.ID_peminjaman ORDER BY ID_peminjaman DESC;");
    if(isset($_POST["submit-search-tanggal"])) {
        $tanggal_batas_awal = $_POST["search-tanggal-batas-awal"];
        $tanggal_batas_akhir = $_POST["search-tanggal-batas-akhir"];
        if($_POST["search-model"] != -1) {
            $id_model_kendaraan = $_POST["search-model"];
            $tuples = read("SELECT detail_peminjaman.*, tanggal_pengembalian_sebenarnya FROM detail_peminjaman LEFT JOIN pengembalian ON pengembalian.ID_peminjaman = detail_peminjaman.ID_peminjaman WHERE ((tanggal_peminjaman BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir') OR (tanggal_pengembalian BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir')) AND (ID_model_kendaraan = $id_model_kendaraan) ORDER BY ID_peminjaman DESC;");
        } else {
            $tuples = read("SELECT detail_peminjaman.*, tanggal_pengembalian_sebenarnya FROM detail_peminjaman LEFT JOIN pengembalian ON pengembalian.ID_peminjaman = detail_peminjaman.ID_peminjaman WHERE ((tanggal_peminjaman BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir') OR (tanggal_pengembalian BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir')) ORDER BY ID_peminjaman DESC;");
        }
    }
    
    if(isset($_POST["submit-pengembalian"])) {
        $status_pengembalian = pengembalian($_POST["ID-peminjaman-pengembalian"], $_POST["denda-pengembalian"], $_POST["tanggal-pengembalian-seharusnya"]);
        if (isset($status_pengembalian)) {
            if ($status_pengembalian == true) {
              $_SESSION["bool_status_pengembalian"] = true;
            } else {
              $_SESSION["bool_status_pengembalian"] = false;
            }
            header("location: list_peminjaman_admin.php");
            exit;
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

    <title>Rental Admin</title>

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
                <div class="sidebar-brand-text mx-3">Rental Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
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
                    <span>Kendaraan User</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Main Features:</h6>
                        <a class="collapse-item" href="list_model_kendaraan_admin.php">List kendaraan</a>
                        <a class="collapse-item" href="list_driver_admin.php">List Driver</a>
                        <a class="collapse-item" href="list_pelanggan_admin.php">List Pelanggan</a>
                        <a class="collapse-item" href="request_peminjaman_admin.php">Request Peminjaman</a>
                        <a class="collapse-item" href="list_pengembalian_admin.php">List Pengembalian</a>
                    </div>
                </div>
                
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Validasi Users</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Main Features:</h6>
                        <a class="collapse-item" href="list_peminjaman_admin.php">List Peminjaman Mobil</a>
                        <a class="collapse-item" href="validasi_user_admin.php">validasi Users</a>
                        <a class="collapse-item" href="validasi_pembayaran_admin.php">validasi Payment</a>
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

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2" name="keyword-search-driver">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" name="search-driver">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

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
        
        <?php if(isset($_SESSION["bool_status_pengembalian"]) && $_SESSION["bool_status_pengembalian"] === true): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Pengembalian telah dikonfirmasi!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_pengembalian"]); ?>
        <?php elseif(isset($_SESSION["bool_status_pengembalian"]) && $_SESSION["bool_status_pengembalian"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_pengembalian"]); ?>
        <?php endif; ?>
        <div class="row card-container">
            <?php foreach ($tuples as $tuple): ?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" class="img-fluid"  alt="..." style=" max-width: 100%;">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <p class="card-text">Nama Peminjam: <?= $tuple["nama"] ?></p>
                                    <?php if($tuple["model"] != NULL): ?>
                                      <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <?php else: ?>
                                      <p class="card-text">Model Kendaraan: NULL</p>
                                    <?php endif;?>
                                    <?php if($tuple["plat_nomor"] != NULL): ?>
                                        <p class="card-text">Plat Nomor Kendaraan: <?= $tuple["plat_nomor"] ?></p>
                                    <?php else: ?>
                                        <p class="card-text">Plat Nomor Kendaraan: NULL</p>
                                    <?php endif;?>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <?php if ($tuple["opsi_driver"] != 0): ?>
                                        <?php if ($tuple["nama_driver"] != NULL): ?>
                                            <p class="card-text">Nama Driver: <?= $tuple["nama_driver"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Driver: NULL</p>
                                        <?php endif;?>
                                    <?php endif; ?>
                                    <?php if($tuple["jumlah_helper"] == 2): ?>
                                        <?php if ($tuple["ID_helper_1"] != NULL): ?>
                                            <p class="card-text">Nama Helper: <?= $tuple["nama_helper_1"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Helper: NULL</p>
                                        <?php endif;?>
                                        <?php if ($tuple["ID_helper_2"] != NULL): ?>
                                            <p class="card-text">Nama Helper: <?= $tuple["nama_helper_2"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Helper: NULL</p>
                                        <?php endif;?>
                                    <?php elseif($tuple["jumlah_helper"] == 1): ?>
                                        <?php if ($tuple["ID_helper_1"] != NULL): ?>
                                            <p class="card-text">Nama Helper: <?= $tuple["nama_helper_1"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Helper: NULL</p>
                                        <?php endif;?>
                                    <?php endif;?>
                                    <p class="card-text">Total Harga: Rp<?= $tuple["harga_peminjaman"] ?></p>
                                </div>
                            </div>
                            <?php if($tuple["tanggal_pengembalian_sebenarnya"] == NULL): ?>
                                <div class="col-md-2 mt-3">
                                    <a class="btn btn-outline-dark btn-lg offset-3" href="#" role="button"  onclick="pengembalian('<?= $tuple['ID_peminjaman']; ?>', '<?= $tuple['tanggal_pengembalian']; ?>')">Konfirmasi Pengembalian</a>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="modal fade" id="modalPengembalian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pengembalian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="formPengembalian">
              <div class="form-group">
                    <label for="ID-peminjaman-pengembalian" class="col-form-label d-none">ID peminjaman</label>
                    <input type="text" class="form-control d-none" id="ID-peminjaman-pengembalian" name="ID-peminjaman-pengembalian" readonly>
              </div>
              <div class="form-group">
                  <label for="tanggal-pengembalian-seharusnya" class="col-form-label d-none">Tanggal Pengembalian Seharusnya</label>
                  <input type="text" class="form-control d-none" id="tanggal-pengembalian-seharusnya" name="tanggal-pengembalian-seharusnya" required readonly>
              </div>
              <div class="form-group">
                  <label for="denda-pengembalian" class="col-form-label">Denda Per Hari (Rp)</label>
                  <input type="number" class="form-control" id="denda-pengembalian" name="denda-pengembalian" required min="0">
              </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-pengembalian">Submit</button>
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
        function pengembalian(ID_peminjaman, tanggal_pengembalian) {
            var myModal = new bootstrap.Modal(document.getElementById('modalPengembalian'));
            document.getElementById("ID-peminjaman-pengembalian").value = ID_peminjaman;
            document.getElementById("tanggal-pengembalian-seharusnya").value = tanggal_pengembalian;
            myModal.show();
        }
    </script>

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