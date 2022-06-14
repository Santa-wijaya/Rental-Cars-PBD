<?php 
	session_start();
	require 'functions.php';
  $id_model = $_GET['p_k_model'];
  $model_data = read("SELECT * FROM tipe_kendaraan WHERE ID_model = $id_model");
  $harga_helper = read("SELECT tarif FROM helper LIMIT 1;");
  $harga_driver = read("SELECT tarif FROM driver LIMIT 1;");
  $harga_driver = $harga_driver[0]['tarif'];
  $harga_helper = $harga_helper[0]['tarif'];

  if(isset($_POST["submit-request"])){
    $request_status = request_peminjaman($_POST, $id_model);
    if (isset($request_status)) {
      $_SESSION["request-status"] = $request_status;
      header("location: halaman_peminjaman_user.php?p_k_model=$id_model");
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
      <div class="mt-5 form-floating c-container mx-auto table-tuples">
        <div class="wrapper mb-2">
          <a href = "beranda_user.php" class="btn btn-secondary">kembali</a>
        </div>
        <div class="card mb-3 shadow-sm">
          <div class="row g-0">
            <div class="col-md-4 mx-auto d-block" style = "min-width: 286px;">
              <img class="mx-auto d-block" src="Images/TipeMobil/<?= $model_data[0]["gambar"]; ?>" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $model_data[0]["model"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Manufaktur: <?= $model_data[0]["manufaktur"] ?></li>
                <li class="list-group-item">Harga: Rp. <?= $model_data[0]["harga_sewa"] ?>/hari</li>
              </ul>
            </div>
          </div>
        </div>
        <?php if(isset($_SESSION["request-status"]) && $_SESSION["request-status"] === 1): ?>
        <div class="col-xxl-12 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Peminjaman berhasil dilakukan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
          <?php unset($_SESSION["request-status"]); ?>
        <?php elseif(isset($_SESSION["request-status"]) && $_SESSION["request-status"] === 0): ?>
            <div class="col-xxl-12 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
                Akun anda belum valid! Harap menunggu admin untuk memvalidasi akun anda!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php unset($_SESSION["request-status"]); ?>
        <?php elseif(isset($_SESSION["request-status"]) && $_SESSION["request-status"] === 2): ?>
            <div class="col-xxl-12 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
                Terjadi kesalahan pada query!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php unset($_SESSION["request-status"]); ?>
        <?php endif; ?>
          <div class="row">
            <div class="col-xxl-8">
                <h2>
                Aturan Peminjaman
                </h2>
                <ol type="1">
                  <li>Bagi peminjaman yang tidak menggunakan jasa driver dan helper, kendaraan dapat dipinjam dan dikembalikan di kantor Sewa Mobil mulai dari pukul 08.00 WITA hingga pukul 17.00 WITA.</li>
                  <li>Bagi peminjaman yang tidak menggunakan jasa driver dan helper, kendaraan akan dipinjamkan secara lepas kunci. Sehingga, pastikan bahwa anda membawa sim anda ke kantor Sewa Mobil saat akan mengambil kendaraan pinjaman anda.</li>
                  <li>Bagi peminjaman yang menggunakan jasa driver dan helper, kendaraan akan diantarkan ke alamat yang anda berikan pada proses registrasi. Sehingga pastikan alamat tersebut adalah alamat tempat kendaraan akan diantarkan. </li>
                  <li>Bagi peminjaman yang menggunakan jasa driver dan helper, kendaraan akan diantarkan ke lokasi anda pada pukul 08.00 WITA dan layanan dapat digunakan hingga pukul 17.00 WITA.</li>
                  <li>Harga peminjaman seorang driver adalah Rp<?= $harga_driver ?>/Hari. </li>
                </ol>
                
            </div>
            <div class="col-xxl-4 form-s shadow-sm">
            
            <form method="POST" onsubmit="reserveConfirmation(<?= $harga_driver ?>, <?= $harga_helper ?>, <?= $model_data[0]["harga_sewa"] ?>)">
                <div class="mb-3">
                    <label for="tanggalPeminjaman" class="form-label">Tanggal Mulai Peminjaman</label>
                    <input type="date" class="form-control" id="tanggalPeminjaman" required>
                </div>
                <div class="mb-3">
                    <label for="tanggalPengembalian" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" id="tanggalPengembalian" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Anda membutuhkan driver?</label>
                    <br>
                    <input type="radio" id="ya" name="driver-needs" value="ya">
                    <label for="ya">Ya</label><br>
                    <input type="radio" id="tidak" name="driver-needs" value="tidak" checked>
                    <label for="tidak">Tidak</label><br>
                </div>
                <div class="mb-3">
                    <label for="helper" class="form-label">Jumlah Helper</label>
                    <input type="number" value="0" class="form-control" id="helper" min="0" max="2" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="ketentuan" required>
                    <label class="form-check-label" for="ketentuan">Saya telah membaca aturan peminjaman</label>
                </div>
                <button href="#" type="submit" class="btn btn-primary mx-auto d-block">Request Peminjaman</button>
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
      function reserveConfirmation(harga_driver, harga_helper, harga_kendaraan){
        event.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('reservationConfirm'));
        var tanggal_peminjaman = document.getElementById("tanggalPeminjaman").value;
        var tanggal_pengembalian = document.getElementById("tanggalPengembalian").value;
        var jumlah_helper = document.getElementById("helper").value;
        var formatted_peminjaman = new Date(tanggal_peminjaman);
        var formatted_pengembalian = new Date(tanggal_pengembalian);
        var jumlah_hari = (formatted_pengembalian.getTime() - formatted_peminjaman.getTime())/(1000 * 60 * 60 * 24) + 1;
        if(document.getElementById("ya").checked) {
            var driver = "Ya";
            var harga = jumlah_hari * ((harga_kendaraan) + (harga_driver) + (jumlah_helper * harga_helper));
        } else {
            var driver = "Tidak";
            var harga = jumlah_hari * ((harga_kendaraan) + (jumlah_helper * harga_helper));
        }
        document.getElementById("konfirmasi-tgl-peminjaman").value = tanggal_peminjaman;
        document.getElementById("konfirmasi-tgl-pengembalian").value = tanggal_pengembalian;
        document.getElementById("konfirmasi-driver").value = driver;
        document.getElementById("konfirmasi-helper").value = jumlah_helper;
        document.getElementById("konfirmasi-biaya").value = harga;


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