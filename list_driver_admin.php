<?php 
	session_start();
	require 'functions.php';

	$tuples = read("SELECT * FROM driver");
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}

  if(isset($_POST["submit"])) {
    $insert_status = null;
    $insert_status = insert_driver($_POST, $_FILES);
    if (isset($insert_status)) {
      if ($insert_status === true) {
        $_SESSION["bool_status_input"] = true;
      } else {
        $_SESSION["bool_status_input"] = false;
      }
      header("location: list_driver_admin.php");
      exit;
    }
  }

  if(isset($_POST["search-driver"])) {
    $keyword = $_POST["keyword-search-driver"];
    $tuples = read("SELECT * FROM driver WHERE nama LIKE '%$keyword%'");
  }

  if(isset($_POST["submit-update"])) {
    $update_status = null;
    $update_status = update_driver($_POST, $_FILES);
    if (isset($update_status)) {
      if ($update_status === true) {
        $_SESSION["bool_status_update"] = true;
      } else {
        $_SESSION["bool_status_update"] = false;
      }
      header("location: list_driver_admin.php");
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    
                </div>
                <div class="sidebar-brand-text mx-3">Rental Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
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
      <!-- <form action="" method="post" autocomplete="off" class="search-form">
        <div class="utility-bar">
            <div></div>
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Cari berdasarkan nama" name="keyword-search-driver">
                <label for="floatingInput">Cari Berdasarkan Nama</label>
              </div>
              <button type="submit" class="fa fa-search btn btn-dark searchbtn" name="search-driver"></button>
            </div>
        </div>
      </form> -->

      <?php if(isset($_SESSION["bool_status_input"]) && $_SESSION["bool_status_input"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Data driver berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_input"]); ?>
      <?php elseif(isset($_SESSION["bool_status_input"]) && $_SESSION["bool_status_input"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              File yang diunggah bukan .jpg/.jpeg/.png atau melebihi 500KB! Data tidak berhasl ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_input"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Data driver berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              File yang diunggah bukan .jpg/.jpeg/.png atau melebihi 500KB! Data tidak berhasil diperbaharui!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["delete_bool"]) && $_SESSION["delete_bool"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Data driver berhasil dihapuskan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["delete_bool"]); ?>
      <?php elseif(isset($_SESSION["delete_bool"]) && $_SESSION["delete_bool"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Data driver tidak berhasil dihapuskan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["delete_bool"]); ?>
      <?php endif; ?>

      <div class="row card-container">
        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto btn shadow" style="width: 18rem; height: 397px; margin-bottom:20px;">
              <i class = "fa fa-plus-circle" style="line-height: 300px; font-size: 7rem; color: green;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
              <p>Tambah Driver</p>
            </div>
          </div>
        <?php foreach ($tuples as $tuple): ?>
          <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto shadow" style="width: 18rem; margin-bottom:20px;">
              <img class="card-img-top" src="Images/Driver/<?= $tuple["nama_foto"]; ?>" alt="Gambar <?= $tuple["nama"] ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $tuple["nama"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Jenis Kelamin: <?= $tuple["jenis_kelamin"] ?></li>
                <li class="list-group-item">Harga: <?= $tuple["tarif"] ?>/hari</li>
              </ul>
              <div class="card-body text-center">
                <a class="btn btn-primary" role="button" onclick="updateData('<?= $tuple['ID_driver'] ?>', '<?= $tuple['nama'] ?>', '<?= $tuple['jenis_kelamin'] ?>', '<?= $tuple['tarif'] ?>', '<?= $tuple['nama_foto'] ?>')">Ubah Data</a>
                <a class="btn btn-danger" href="deletelogic.php?p_k=<?= $tuple["ID_driver"]; ?>&type=Driver" role="button" onclick="return confirm('Apakah anda yakin akan menghapus data driver <?= $tuple["nama"] ?>?')">Hapus</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <script type="text/javascript">
      function updateData(id, nama, jenis_kelamin, tarif, nama_foto){
        var myModal = new bootstrap.Modal(document.getElementById('updateForm'));
        document.getElementById("id-driver").value = id;
        document.getElementById("nama-driver-update").value = nama;
        document.getElementById("harga-driver-update").value = tarif;
        document.getElementById("harga-driver-update").value = tarif;
        radiobtn_1 = document.getElementById("gridRadios1-update");
        radiobtn_2 = document.getElementById("gridRadios2-update");

        if (jenis_kelamin == "Pria") {
          radiobtn_1.checked = true;
        } else {
          radiobtn_2.checked = true;
        }

        myModal.show();
      }
    </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    <!-- Modal -->
    <div class="modal fade" id="ModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Driver</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="nama-driver" class="col-form-label">Nama Driver</label>
                <input type="text" class="form-control" id="nama-driver" name="nama-driver" required>
              </div>
              <div class="form-group">
                <label for="jenisKelamin" class="form-label mt-2">Jenis Kelamin</label>
                <div class="form-check ">
                    <input class="form-check-input" type="radio" name="jenisKelamin" id="gridRadios1" value="Pria" checked required>
                    <label class="form-check-label" for="gridRadios1">
                      Pria
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenisKelamin" id="gridRadios2" value="Wanita" required>
                    <label class="form-check-label" for="gridRadios2">
                      Wanita
                    </label>
                  </div>
              </div>
              <div class="form-group">
                  <label for="harga-driver" class="col-form-label">Harga/hari (Rp)</label>
                  <input type="text" class="form-control" id="harga-driver" name="harga" required>
              </div>
              <div class="form-group">
                  <label for="gambar-driver" class="col-form-label">Foto Driver</label>
                  <input type="file" class="form-control" id="gambar-driver" name="foto-driver" accept = "image/jpeg, image/jpg, image/png" required>
              </div>
              <div class="form-group text-center mt-2">
                  <input type="checkbox" name="konfirmasi-input" id="konfirmasi-input" value="agree" required>
                  <label for="konfirmasi-input" class="col-form-label">Konfirmasi Penambahan Driver</label>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button id="submit" type="submit" class="btn btn-success" name="submit">Tambahkan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="updateForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Driver</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updateDriverForm">
              <div class="form-group">
                <label for="id-driver" class="col-form-label d-none">ID Driver</label>
                <input type="text" class="form-control d-none" id="id-driver" name="id-driver" readonly>
              </div>
              <div class="form-group">
                <label for="nama-driver-update" class="col-form-label">Nama Driver</label>
                <input type="text" class="form-control" id="nama-driver-update" name="nama-driver-update" required>
              </div>
              <div class="form-group">
                <label for="jenisKelamin-update" class="form-label mt-2">Jenis Kelamin</label>
                <div class="form-check ">
                    <input class="form-check-input" type="radio" name="jenisKelamin-update" id="gridRadios1-update" value="Pria" checked required>
                    <label class="form-check-label" for="gridRadios1-update">
                      Pria
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenisKelamin-update" id="gridRadios2-update" value="Wanita" required>
                    <label class="form-check-label" for="gridRadios2-update">
                      Wanita
                    </label>
                  </div>
              </div>
              <div class="form-group">
                  <label for="harga-driver-update" class="col-form-label">Harga/hari (Rp):</label>
                  <input type="text" class="form-control" id="harga-driver-update" name="harga-driver-update" required>
              </div>
              <div class="form-group">
                  <label for="gambar-driver-update" class="col-form-label">Unggah Foto Baru</label>
                  <input type="file" class="form-control" id="gambar-driver-update" name="foto-driver-update" accept = "image/jpeg, image/jpg, image/png">
              </div>
              <div class="form-group text-center mt-2">
                  <input type="checkbox" name="konfirmasi-input" id="konfirmasi-input" value="agree" required>
                  <label for="konfirmasi-input" class="col-form-label">Konfirmasi Perubahan Data Driver</label>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-update" type="submit" class="btn btn-success" name="submit-update">Perbaharui</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

      <div class="modal" id="modalLogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                  Apakah anda yakin akan logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="logoutlogic.php" class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" id="modalKonfirmasiPenghapusan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Penghapusan Data Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                  Apakah anda yakin akan menghapus data driver ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="deletelogic.php?p_k=<?= $tuple["ID_driver"]; ?>" class="btn btn-danger">Hapus</a>
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