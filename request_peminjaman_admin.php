<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
  $jumlah_data_per_page = 10;
  $jumlah_data = read("SELECT COUNT(*) AS jumlah_data FROM request_peminjaman WHERE status_peminjaman = 'not accepted yet' ORDER BY ID_peminjaman");
  $jumlah_page = ceil($jumlah_data[0]["jumlah_data"]/$jumlah_data_per_page);
  if(isset($_GET["page_request_peminjaman_admin"])) {
    $page_saat_ini = $_GET["page_request_peminjaman_admin"];
  } else {
    $page_saat_ini = 1;
  }
  $batas_bawah = $jumlah_data_per_page*$page_saat_ini-$jumlah_data_per_page;
  $tuples = read("SELECT * FROM request_peminjaman WHERE status_peminjaman = 'not accepted yet' ORDER BY ID_peminjaman LIMIT $batas_bawah, $jumlah_data_per_page;");

  if (isset($_POST["submit-acc-request"])) {
    $accept_status = accept_peminjaman($_POST);
    if (isset($accept_status)) {
      if ($accept_status == 1) {
        $_SESSION["bool_status_accept"] = 1;
      } elseif ($accept_status == 2) {
        $_SESSION["bool_status_accept"] = 2;
      } else {
        $_SESSION["bool_status_accept"] = 0;
      }
      header("location: request_peminjaman_admin.php");
      exit;
    }
  }

  if(isset($_POST["submit-reject-request"])) {
    $reject_status = reject_peminjaman($_POST);
    if (isset($reject_status)){
      if ($reject_status) {
        $_SESSION["bool_status_reject"] = true;
      } else {
        $_SESSION["bool_status_accept"] = false;
      }
      header("location: request_peminjaman_admin.php");
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
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
        <?php if(isset($_SESSION["bool_status_reject"]) && $_SESSION["bool_status_reject"] === true): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Permintaan peminjaman telah ditolak!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_reject"]); ?>
        <?php elseif(isset($_SESSION["bool_status_reject"]) && $_SESSION["bool_status_reject"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_reject"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["bool_status_accept"]) && $_SESSION["bool_status_accept"] == 1): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Request berhasil diterima!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_accept"]); ?>
        <?php elseif(isset($_SESSION["bool_status_accept"]) && $_SESSION["bool_status_accept"] == 0):?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Lengkapi data unit kendaraan, driver, ataupun helper!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_accept"]); ?>
        <?php elseif(isset($_SESSION["bool_status_accept"]) && $_SESSION["bool_status_accept"] == 2): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_accept"]); ?>
        <?php endif; ?>
        <div class="table-responsive mt-5 col-xxl-8 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 table-tuples shadow">
            <table class="table shadow">
                <thead class = "text-center" style="color:dark;">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th style="width: 16.66%">Alamat</th>
                    <th>Model Kendaraan</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Opsi Driver</th>
                    
                    <th>Aksi</th>
                </thead>
                <tbody class="text-center">
                    <?php $counter = 0?>
                    <?php foreach ($tuples as $tuple): ?>
                    <?php $counter += 1?>
                    <?php 
                      $id_model = $tuple["ID_model"];
                      $unit_kendaraan = read("SELECT * FROM unit_kendaraan WHERE id_model = '$id_model';");
                    ?>
                    <tr>
                        <td><?= $counter ?></td>
                        <td><?= $tuple["nama"] ?></td>
                        <td><?= $tuple["username"] ?></td>
                        <td><?= $tuple["alamat"] ?></td>
                        <td><?= $tuple["model"] ?></td>
                        <td><?= $tuple["tanggal_peminjaman"] ?></td>
                        <td><?= $tuple["tanggal_pengembalian"] ?></td>
                        <?php if($tuple["opsi_driver"]==0): ?>
                          <td>Tidak</td>
                        <?php else: ?>
                          <td>Ya</td>
                        <?php endif?>
                        
                        <td><a class="btn btn-success mx-1 mt-1 mb-1" href="#" role="button" onclick='terimaRequest(<?php echo ($tuple["opsi_driver"]); ?>, <?php echo ($tuple["jumlah_helper"]); ?>, <?php echo ($tuple["ID_peminjaman"]); ?>, <?php echo json_encode($unit_kendaraan); ?>)'>Terima</a>
                        <a class="btn btn-danger mt-1 mb-1" href="#" role="button" onclick="tolakRequest(<?= $tuple['ID_peminjaman'] ?>)">Tolak</a></td>
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
                  <a class="page-link" href="request_peminjaman_admin.php?page_request_peminjaman_admin=<?= $page_saat_ini-1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
              <?php endif;?>
              <?php for($i=1; $i<=$jumlah_page; $i++):?>
                <li class="page-item"><a class="page-link" href="request_peminjaman_admin.php?page_request_peminjaman_admin=<?= $i; ?>"><?= $i ?></a></li>
              <?php endfor;?>
              <?php if($page_saat_ini == $jumlah_page): ?>
                <li class="page-item disabled">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php else: ?>
                <li class="page-item">
                  <a class="page-link" href="request_peminjaman_admin.php?page_request_peminjaman_admin=<?= $page_saat_ini+1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php endif;?>
            </ul>
          </nav>
        </div>
    </div>

    
    <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Terima Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="acceptRequestForm">
              <div class="form-group">
                    <label for="ID-peminjaman-accept" class="col-form-label">ID peminjaman</label>
                    <input type="text" class="form-control" id="ID-peminjaman-accept" name="ID-peminjaman-accept" readonly>
              </div>
              
              <div class="form-group">
                    <label for="butuh-driver-accept" class="col-form-label">Butuh Driver</label>
                    <input type="number" class="form-control" id="butuh-driver-accept" name="butuh-driver-accept" readonly>
              </div>
              <div class="form-group">
                <label for="unit-kendaraan" class="col-form-label">Unit Kendaraan</label>
                <select class="form-select" id="unit-kendaraan" name="unit-kendaraan" required>
                </select>
              </div>
              <div class="form-group">
                <label for="driver" class="col-form-label" id="label-driver">Driver</label>
                <?php $driver = read("SELECT * FROM driver;"); ?>
                <select class="form-select" id="driver-selection" name="driver-selection" required>
                  <option selected>Pilih Driver</option>
                  <?php foreach ($driver as $driver_personel): ?>
                    <option value = "<?= $driver_personel["ID_driver"] ?>"><?= $driver_personel["nama"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="helper-1" class="col-form-label" id="label-helper-1">Helper</label>
                <?php $helper = read("SELECT * FROM helper;"); ?>
                <select class="form-select" id="helper-1" name="helper-1" required>
                  <option selected>Pilih Helper</option>
                  <?php foreach ($helper as $helper_personel): ?>
                    <option value = "<?= $helper_personel["ID_helper"] ?>"><?= $helper_personel["nama"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="helper-2" class="col-form-label" id="label-helper-2">Helper</label>
                <?php $helper = read("SELECT * FROM helper;"); ?>
                <select class="form-select" id="helper-2" name="helper-2" required>
                  <option selected>Pilih Helper</option>
                  <?php foreach ($helper as $helper_personel): ?>
                    <option value = "<?= $helper_personel["ID_helper"] ?>"><?= $helper_personel["nama"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3 form-check mt-3">
                    <input type="checkbox" class="form-check-input" id="konfirmasi-accept" required>
                    <label class="form-check-label" for="konfirmasi-accept">Konfirmasi Penerimaan Permintaan Peminjaman</label>
                </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-acc-request">Accept</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tolak Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="acceptRequestForm">
            <p>Apakah anda yakin akan menolak permintaan ini?</p>
              <div class="form-group">
                    <label for="ID-peminjaman-reject" class="col-form-label d-none">ID peminjaman</label>
                    <input type="text" class="form-control d-none" id="ID-peminjaman-reject" name="ID-peminjaman-reject" readonly>
              </div>
              <div class="form-group">
                    <label for="keterangan-reject-peminjaman" class="col-form-label">Keterangan Penolakan</label>
                    <textarea id="keterangan-reject-peminjaman" name="keterangan-reject-peminjaman" rows = "5" class="form-control"></textarea>
              </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-success" name="submit-reject-request">Ya</button>
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
      function terimaRequest(opsi_driver, jumlah_helper, id_peminjaman, unit_kendaraan) {
        document.getElementById("butuh-driver-accept").value = opsi_driver;
        document.getElementById("jumlah-helper-accept").value = jumlah_helper;
        var select_dropdown = document.getElementById("unit-kendaraan");
        select_dropdown.options.length = 0;
        var dummy = document.createElement("option");
        dummy.text = "Pilih Unit";
        dummy.value = -1;
        select_dropdown.add(dummy);
        for (var i = 0; i < unit_kendaraan.length; i++) {
          var option = document.createElement("option");
          option.text = unit_kendaraan[i]["plat_nomor"];
          option.value = unit_kendaraan[i]["ID_kendaraan"];
          select_dropdown.add(option);
        }
        var myModal = new bootstrap.Modal(document.getElementById('acceptModal'));
        var id = document.getElementById("ID-peminjaman-accept");
        id.value = id_peminjaman;

        if (jumlah_helper == 0) {
          var helper1 = document.getElementById("helper-1");
          var labelhelper1 = document.getElementById("label-helper-1");
          var helper2 = document.getElementById("helper-2");
          var labelhelper2 = document.getElementById("label-helper-2");
          helper1.style.display = "none";
          helper2.style.display = "none";
          labelhelper1.style.display = "none";
          labelhelper2.style.display = "none";
        } else if (jumlah_helper == 1) {
          var helper1 = document.getElementById("helper-1");
          var labelhelper1 = document.getElementById("label-helper-1");
          var helper2 = document.getElementById("helper-2");
          var labelhelper2 = document.getElementById("label-helper-2");
          helper1.style.display = "none";
          labelhelper1.style.display = "none";
          helper2.style.display = "block";
          labelhelper2.style.display = "block";
        } else {
          var helper1 = document.getElementById("helper-1");
          var labelhelper1 = document.getElementById("label-helper-1");
          var helper2 = document.getElementById("helper-2");
          var labelhelper2 = document.getElementById("label-helper-2");
          helper1.style.display = "block";
          labelhelper1.style.display = "block";
          helper2.style.display = "block";
          labelhelper2.style.display = "block";
        }

        if (opsi_driver == 0) {
          var driver_input = document.getElementById("driver-selection");
          var driver_label = document.getElementById("label-driver");
          driver_input.style.display = "none";
          driver_label.style.display = "none";
        } else {
          var driver_input = document.getElementById("driver-selection");
          var driver_label = document.getElementById("label-driver");
          driver_input.style.display = "block";
          driver_label.style.display = "block";
        }

        myModal.show();
      }

      function tolakRequest(ID_peminjaman) {
        var myModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        document.getElementById("ID-peminjaman-reject").value = ID_peminjaman;
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