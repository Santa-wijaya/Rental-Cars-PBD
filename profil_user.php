<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_pelanggan"])) {
        header("location: form_login.php");
        exit;
    }
    $id = $_SESSION["id_akun"];
    $tuples = read("SELECT * FROM akun_pelanggan INNER JOIN pelanggan ON akun_pelanggan.ID_pelanggan = pelanggan.ID_pelanggan WHERE ID_akun = '$id';");
    if (isset($_POST["update-biodata-submit"])) {
      if (ctype_space($_POST["update-NIK"]) || ctype_space($_POST["update-nama"]) || ctype_space($_POST["update-alamat"]) || ctype_space($_POST["update-nomor-telepon"] || ctype_space($_POST["update-jenis-kelamin"]))) {
        echo "<script> alert('Tolong lengkapi data anda!'); </script>";
      } elseif ($_POST["update-NIK"] != $tuples[0]["NIK"] || $_POST["update-nama"] != $tuples[0]["nama"] || $_POST["update-alamat"] != $tuples[0]["alamat"] || $_POST["update-kabupaten"] != $tuples[0]["kabupaten"] || $_POST["update-jenis-kelamin"] != $tuples[0]["jenis_kelamin"]) {
        $update_biodata_status = update_biodata($_POST, $tuples[0]["ID_pelanggan"], $tuples[0]["NIK"], $tuples[0]["ID_akun"]);
      } else {
        $update_biodata_status = update_biodata($_POST,  $tuples[0]["ID_pelanggan"], $tuples[0]["NIK"], $tuples[0]["ID_akun"]);
      }
      if (isset($update_biodata_status)) {
        if ($update_biodata_status === true) {
          $_SESSION["bool_status_update_biodata"] = true;
        } else {
          $_SESSION["bool_status_update_biodata"] = false;
        }
        header("location: profil_user.php");
        exit;
      }
    }

    if (isset($_POST["update-username-submit"])) {
      if (ctype_space($_POST["update-username"]) || ctype_space($_POST["update-password-konfirmasi"])) {
        echo "<script> alert('Tolong lengkapi data anda!'); </script>";
      } elseif ($_POST["update-username"] != $tuples[0]["username"]) {
        $update_username_status = update_username($_POST, $tuples[0]["password_pelanggan"], $tuples[0]["ID_akun"]);
      }
      if (isset($update_username_status)) {
        $_SESSION["bool_status_update_username"] = $update_username_status;
        header("location: profil_user.php");
        exit;
      }
    }

    if (isset($_POST["update-password-submit"])) {
      if (ctype_space($_POST["update-password-sekarang"]) || ctype_space($_POST["update-password-baru"]) || ctype_space($_POST["update-konfirmasi-password-baru"])) {
        echo "<script> alert('Tolong lengkapi data anda!'); </script>";
      } elseif (isset($_POST["update-password-sekarang"]) || isset($_POST["update-password-baru"]) || isset($_POST["update-konfirmasi-password-baru"])) {
        $update_password_status = update_password($_POST, $tuples[0]["password_pelanggan"], $tuples[0]["ID_akun"]);
      }
      if (isset($update_password_status)) {
        $_SESSION["bool_status_update_password"] = $update_password_status;
        header("location: profil_user.php");
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
      <div class="text-center mt-4">
        <h1>Edit Profile</h1>
      </div>
      <?php if(isset($_SESSION["bool_status_update_biodata"]) && $_SESSION["bool_status_update_biodata"] === true): ?>
        <div class="col-xxl-8 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Biodata berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update_biodata"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_biodata"]) && $_SESSION["bool_status_update_biodata"] === false): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Biodata tidak berhasil diperbaharui! NIK sudah digunakan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_biodata"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 0): ?>
        <div class="col-xxl-8 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Username berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 3): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 2): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Password konfirmasi tidak sesuai!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 1): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Username telah digunakan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 4): ?>
        <div class="col-xxl-8 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Password berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 3): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 2): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Password konfirmasi tidak sesuai!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 1): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Password tidak sesuai!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php endif; ?>
      
      <fieldset class="scheduler-border col-md-8 offset-md-2 shadow" >
        <legend class="scheduler-border">Biodata</legend>
          <div class="row">
          <form class="form-horizontal" action="#" method="post">
              <div class="row mt-2">
                  <div class="col-md-6">
                      <label for="update-NIK" class="form-label">NIK</label>
                      <input type="text" class="form-control" id="update-NIK" name="update-NIK" value="<?= $tuples[0]["NIK"] ?>">
                  </div>
                  <div class="col-md-6">
                      <label for="update-nama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="update-nama" name="update-nama" value="<?= $tuples[0]["nama"] ?>">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-12">
                      <label for="update-alamat" class="form-label">Alamat</label>
                      <input type="text" class="form-control" id="update-alamat" name="update-alamat" value="<?= $tuples[0]["alamat"] ?>">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-6 ">
                      <label for="update-kabupaten" class="form-label">Kabupaten/Kota</label>
                      <select class="form-select" id="update-kabupaten" name="update-kabupaten" required>
                          <option value="Badung" <?=$tuples[0]['kabupaten'] == 'Badung' ? ' selected="selected"' : '';?>>Badung</option>
                          <option value="Bangli" <?=$tuples[0]['kabupaten'] == 'Bangli' ? ' selected="selected"' : '';?>>Bangli</option>
                          <option value="Buleleng" <?=$tuples[0]['kabupaten'] == 'Buleleng' ? ' selected="selected"' : '';?>>Buleleng</option>
                          <option value="Gianyar" <?=$tuples[0]['kabupaten'] == 'Gianyar' ? ' selected="selected"' : '';?>>Gianyar</option>
                          <option value="Jembrana" <?=$tuples[0]['kabupaten'] == 'Jembrana' ? ' selected="selected"' : '';?>>Jembrana</option>
                          <option value="Karangasem" <?=$tuples[0]['kabupaten'] == 'Karangasem' ? ' selected="selected"' : '';?>>Karangasem</option>
                          <option value="Klungkung" <?=$tuples[0]['kabupaten'] == 'Klungkung' ? ' selected="selected"' : '';?>>Klungkung</option>
                          <option value="Tabanan" <?=$tuples[0]['kabupaten'] == 'Tabanan' ? ' selected="selected"' : '';?>>Tabanan</option>
                          <option value="Denpasar" <?=$tuples[0]['kabupaten'] == 'Denpasar' ? ' selected="selected"' : '';?>>Denpasar</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label for="update-nomor-telepon" class="form-label">Nomor Telepon</label>
                      <input type="text" class="form-control" id="update-nomor-telepon" name="update-nomor-telepon" value="<?= $tuples[0]["nomor_telepon"] ?>">
                  </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6 ">
                <label for="update-jenis-kelamin" class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="update-jenis-kelamin" <?php echo ($tuples[0]["jenis_kelamin"] =='Pria')? 'checked':'' ?> id="gridRadios1" value="Pria" checked required>
                        <label class="form-check-label" for="gridRadios1">
                          Pria
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="update-jenis-kelamin" <?php echo ($tuples[0]["jenis_kelamin"] =='Wanita')? 'checked':'' ?> id="gridRadios2" value="Wanita" required>
                        <label class="form-check-label" for="gridRadios2">
                          Wanita
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Status</label>
                    <input type="text" class="form-control" id="" name="" disabled value="<?= $tuples[0]["status_akun"] ?>">
                </div>
              </div>
              <div class="mt-3 ">
                    <button type="submit" name = "update-biodata-submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
          </form>
          </div>
        </legend>
      </fieldset>
      
      <div class="row mt-4">
        <fieldset class="scheduler-border col-md-4 offset-md-2 shadow" >
          <legend class="scheduler-border">Username</legend>
            <div class="row">
              <form class="form-horizontal" action="#" method="post" >
                <div class="row mt-3">
                    <div class="">
                        <label for="update-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="update-username" name="update-username" value="<?= $tuples[0]["username"] ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="">
                        <label for="update-password-konfirmasi" class="form-label">Password Konfirmasi</label>
                        <input type="password" class="form-control" id="update-password-konfirmasi" name="update-password-konfirmasi">
                    </div>
                </div>
                <div class="mt-3 ">
                      <button type="submit" name = "update-username-submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </legend>
        </fieldset>

        <fieldset class="scheduler-border col-md-4 shadow" style="margin-left: 8px;">
          <legend class="scheduler-border" >Password</legend>
            <div class="row">
              <form class="" action="#" method="post" >
              <div class="row mt-3">
                  <div class="">
                      <label for="update-password-sekarang" class="form-label">Password Saat Ini</label>
                      <input type="password" class="form-control" id="update-password-sekarang" name="update-password-sekarang">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="">
                      <label for="update-password-baru" class="form-label">Password Baru</label>
                      <input type="password" class="form-control" id="update-password-baru" name="update-password-baru">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="">
                      <label for="update-konfirmasi-password-baru" class="form-label">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" id="update-konfirmasi-password-baru" name="update-konfirmasi-password-baru">
                  </div>
              </div>
              <div class="mt-3">
                    <button type="submit" name = "update-password-submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
              </form>
            </div>
          </legend>
        </fieldset>
      </div>
      <br>
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