<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
  
  $jumlah_data_per_page = 10; 
  $jumlah_data = read("SELECT COUNT(*) AS jumlah_data FROM data_pelanggan_baru;");
  $jumlah_page = ceil($jumlah_data[0]["jumlah_data"]/$jumlah_data_per_page);
  if(isset($_GET["page_validasi_user"])) {
    $page_saat_ini = $_GET["page_validasi_user"];
  } else {
    $page_saat_ini = 1;
  }
  $batas_bawah = $jumlah_data_per_page*$page_saat_ini-$jumlah_data_per_page;
  $tuples = read("SELECT * FROM data_pelanggan_baru LIMIT $batas_bawah, $jumlah_data_per_page;");

    if(isset($_POST["submit-valid"])){
        $validation_status = null;
        $validation_status = user_validation($_POST["ID-akun-valid"], 'valid');
        if (isset($validation_status)) {
            if ($validation_status === true) {
              $_SESSION["bool_status_validation"] = true;
            } else {
              $_SESSION["bool_status_validation"] = false;
            }
            header("location: validasi_user_admin.php");
            exit;
        }
    }

    if(isset($_POST["submit-not-valid"])){
        $not_valid_status = null;
        $not_valid_status = user_validation($_POST["ID-akun-not-valid"], 'not valid');
        if (isset($not_valid_status)) {
            if ($not_valid_status === true) {
              $_SESSION["bool_status_not_valid"] = true;
            } else {
              $_SESSION["bool_status_not_valid"] = false;
            }
            header("location: validasi_user_admin.php");
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
        <?php if(isset($_SESSION["bool_status_validation"]) && $_SESSION["bool_status_validation"] === true ||isset($_SESSION["bool_status_not_valid"]) && $_SESSION["bool_status_not_valid"] === true): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Validasi pelanggan berhasil dilakukan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_not_valid"]); ?>
          <?php unset($_SESSION["bool_status_validation"]); ?>
        <?php elseif(isset($_SESSION["bool_status_validation"]) && $_SESSION["bool_status_validation"] === false || isset($_SESSION["bool_status_not_valid"]) && $_SESSION["bool_status_not_valid"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Validasi pelanggan tidak berhasil dilakukan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_not_valid"]); ?>
          <?php unset($_SESSION["bool_status_validation"]); ?>
        <?php endif; ?>
        <div class="table-responsive mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow table-tuples">
            <table class="table shadow">
                <thead class = "text-center" style="background-color: #000033; color: white;">
                    <th>NIK</th>
                    <th>Nama</th>
                    <th style="width: 16.66%">Alamat</th>
                    <th>Kabupaten</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($tuples as $tuple): ?>
                    <tr>
                        <td><?= $tuple["NIK"] ?></td>
                        <td><?= $tuple["nama"] ?></td>
                        <td><?= $tuple["alamat"] ?></td>
                        <td><?= $tuple["kabupaten"] ?></td>
                        <td><?= $tuple["jenis_kelamin"] ?></td>
                        <td><a class="btn btn-success mx-1 mt-1 mb-1" href="#" role="button" onclick="valid_user('<?= $tuple['ID_akun'] ?>', '<?= $tuple['NIK'] ?>')">Valid</a>
                        <a class="btn btn-danger mt-1 mb-1" href="#" role="button" onclick="not_valid_user('<?= $tuple['ID_akun'] ?>', '<?= $tuple['NIK'] ?>')">Tidak Valid</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="row mx-auto ms-5 ps-5">
        <nav aria-label="Page navigation example" class="pagination-button" style="background-color: white;">
          <ul class="pagination pagination-sm offset-xxl-4" style="background-color: white;">
            <?php if($page_saat_ini == 1): ?>
              <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
            <?php else: ?>
              <li class="page-item">
                <a class="page-link" href="validasi_user_admin.php?page_validasi_user=<?= $page_saat_ini-1; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
            <?php endif;?>
            <?php for($i=1; $i<=$jumlah_page; $i++):?>
              <li class="page-item"><a class="page-link" href="validasi_user_admin.php?page_validasi_user=<?= $i; ?>"><?= $i ?></a></li>
            <?php endfor;?>
            <?php if($page_saat_ini == $jumlah_page): ?>
              <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            <?php else: ?>
              <li class="page-item">
                <a class="page-link" href="validasi_user_admin.php?page_validasi_user=<?= $page_saat_ini+1; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            <?php endif;?>
          </ul>
        </nav>
      </div>
    </div>
    

    <div class="modal fade" id="validModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Validasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin data pelanggan ini valid?
              </p>
              <div class="form-group">
                <label for="ID-akun-valid" class="col-form-label d-none">ID Akun</label>
                <input type="text" class="form-control d-none" id="ID-akun-valid" name="ID-akun-valid" readonly>
              </div>
              <div class="form-group">
                <label for="NIK-valid" class="col-form-label">NIK</label>
                <input type="text" class="form-control" id="NIK-valid" name="NIK-valid" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-valid">Ya</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="notValidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Validasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin data pelanggan ini tidak valid?
              </p>
              <div class="form-group">
                <label for="ID-akun-not-valid" class="col-form-label d-none">ID Akun</label>
                <input type="text" class="form-control d-none" id="ID-akun-not-valid" name="ID-akun-not-valid" readonly>
              </div>
              <div class="form-group">
                <label for="NIK-hapus" class="col-form-label">NIK</label>
                <input type="text" class="form-control" id="NIK-not-valid" name="NIK-not-valid" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-not-valid">Ya</button>
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

function valid_user(ID_akun, NIK){
  var myModal = new bootstrap.Modal(document.getElementById('validModal'));
  document.getElementById("NIK-valid").value = NIK;
  document.getElementById("ID-akun-valid").value = ID_akun;
  myModal.show();
}

function not_valid_user(ID_akun, NIK){
  var myModal = new bootstrap.Modal(document.getElementById('notValidModal'));
  document.getElementById("NIK-not-valid").value = NIK;
  document.getElementById("ID-akun-not-valid").value = ID_akun;
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