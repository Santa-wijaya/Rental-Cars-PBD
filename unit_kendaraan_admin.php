<?php 
	session_start();
	require 'functions.php';
  $id_model = $_GET['p_k_model'];
  $query = "SELECT * FROM tipe_kendaraan WHERE ID_model = $id_model;";
  $model_data = read($query);
  $jumlah_data_per_page = 5;
  $jumlah_data = read("SELECT COUNT(*) AS jumlah_data FROM (unit_kendaraan INNER JOIN tipe_kendaraan ON unit_kendaraan.ID_model = tipe_kendaraan.ID_model) WHERE unit_kendaraan.ID_model = $id_model;");
  $jumlah_page = ceil($jumlah_data[0]["jumlah_data"]/$jumlah_data_per_page);
  if(isset($_GET["page_unit_kendaraan"])) {
    $page_saat_ini = $_GET["page_unit_kendaraan"];
  } else {
    $page_saat_ini = 1;
  }
  $batas_bawah = $jumlah_data_per_page*$page_saat_ini-$jumlah_data_per_page;
  $query = "SELECT * FROM (unit_kendaraan INNER JOIN tipe_kendaraan ON unit_kendaraan.ID_model = tipe_kendaraan.ID_model) WHERE unit_kendaraan.ID_model = $id_model LIMIT $batas_bawah, $jumlah_data_per_page;";
	$tuples = read($query);
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}

  if(isset($_POST["submit-add"])) {
      $insert_status = insert_unit($_POST);
      if (isset($insert_status)) {
        if ($insert_status === true) {
          $_SESSION["bool_status_insert"] = true;
        } else {
          $_SESSION["bool_status_insert"] = false;
        }
        header("location: unit_kendaraan_admin.php?p_k_model=$id_model&;");
        exit;
      }
  }

  if(isset($_POST["submit-update"])) {
    $update_status = update_unit($_POST);
      if (isset($update_status)) {
        if ($update_status === true) {
          $_SESSION["bool_status_update"] = true;
        } else {
          $_SESSION["bool_status_update"] = false;
        }
        header("location: unit_kendaraan_admin.php?p_k_model=$id_model&;");
        exit;
      }
  }

  if(isset($_POST["submit-delete"])) {
    $delete_status = delete_unit($_POST);
      if (isset($delete_status)) {
        if ($delete_status === true) {
          $_SESSION["bool_status_delete"] = true;
        } else {
          $_SESSION["bool_status_delete"] = false;
        }
        header("location: unit_kendaraan_admin.php?p_k_model=$id_model&;");
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
                        <a class="collapse-item" href="">List kendaraan</a>
                        <a class="collapse-item" href="">List Driver</a>
                        <a class="collapse-item" href="">List Pelanggan</a>
                        <a class="collapse-item" href="">List Peminjaman</a>
                        <a class="collapse-item" href="">List Pengembalian</a>
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
                        <a class="collapse-item" href="">Request Peminjaman</a>
                        <a class="collapse-item" href="">validasi Users</a>
                        <a class="collapse-item" href="">validasi Payment</a>
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
                                aria-label="Search" aria-describedby="basic-addon2" name="keyword-search-model-list-model-admin">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" name="search-model-list-model-admin>
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

      <?php if(isset($_SESSION["bool_status_insert"]) && $_SESSION["bool_status_insert"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Unit Plat berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_insert"]); ?>
      <?php elseif(isset($_SESSION["bool_status_insert"]) && $_SESSION["bool_status_insert"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Unit Kendaraan tidak berhasil ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_insert"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_delete"]) && $_SESSION["bool_status_delete"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Unit Kendaraan berhasil dihapuskan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_delete"]); ?>
      <?php elseif(isset($_SESSION["bool_status_delete"]) && $_SESSION["bool_status_delete"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Unit Kendaraan tidak berhasil dihapuskan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_delete"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Data unit Kendaraan berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Data unit Kendaraan tidak berhasil diperbaharui!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php endif; ?>

      <div class="table-responsive mt-5 form-floating c-container mx-auto table-tuples">
        <div class="wrapper mb-2">
          <a href = "list_model_kendaraan_admin.php" class="btn btn-secondary">kembali</a>
          <a href="#" class="btn btn-primary"  role="button" onclick="addUnitFunc('<?= $model_data[0]["model"] ?>', '<?= $id_model ?>')"><i class="fa fa-plus-circle"></i> Tambah Unit</a>
        </div>
        <div class="card mb-3 shadow-sm">
          <div class="row g-0">
            
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $model_data[0]["model"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Manufaktur: <?= $model_data[0]["manufaktur"] ?></li>
                <li class="list-group-item">Harga: <?= $model_data[0]["harga_sewa"] ?>/hari</li>
              </ul>
            </div>
          </div>
        </div>
        
        <table class="table shadow-sm">
          <thead class = "text-center" style="background-color: #000033; color: white;">
            <th>ID Kendaraan</th>
            <th>Plat Nomor</th>
            <th>Aksi</th>
          </thead>
          <tbody class="text-center">
            <?php foreach ($tuples as $tuple): ?>
              <tr>
                <td><?= $tuple["ID_kendaraan"] ?></td>
                <td><?= $tuple["plat_nomor"] ?></td>

                <td><a class="btn btn-warning mx-1" href="#" role="button" onclick="updateUnit('<?= $tuple['model'] ?>', '<?= $id_model ?>', '<?= $tuple['plat_nomor'] ?>', '<?= $tuple["ID_kendaraan"] ?>')">Ubah</a>
                  <a class="btn btn-danger" href="#" role="button" onclick="deleteUnit('<?= $tuple['plat_nomor'] ?>', '<?= $tuple["ID_kendaraan"] ?>')">Hapus</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="row mx-auto">
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
                  <a class="page-link" href="unit_kendaraan_admin.php?p_k_model=<?= $id_model; ?>&page_unit_kendaraan=<?= $page_saat_ini-1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
              <?php endif;?>
              <?php for($i=1; $i<=$jumlah_page; $i++):?>
                <li class="page-item"><a class="page-link" href="unit_kendaraan_admin.php?p_k_model=<?= $id_model; ?>&page_unit_kendaraan=<?= $i; ?>"><?= $i ?></a></li>
              <?php endfor;?>
              <?php if($page_saat_ini == $jumlah_page): ?>
                <li class="page-item disabled">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php else: ?>
                <li class="page-item">
                  <a class="page-link" href="unit_kendaraan_admin.php?p_k_model=<?= $id_model; ?>&page_unit_kendaraan=<?= $page_saat_ini+1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php endif;?>
            </ul>
          </nav>
        </div>
      </div>
      
    </div>

    <!-- JAVASCRIPT --> 
    <script type="text/javascript">
      function addUnitFunc(model, id){
        var myModal = new bootstrap.Modal(document.getElementById('addUnit'));
        document.getElementById("id-model-kendaraan").value = id;
        document.getElementById("model-kendaraan").value = model;
        myModal.show();
      }

      function updateUnit(model, id_model, platNomor, id_kendaraan){
        var myModal = new bootstrap.Modal(document.getElementById('updateForm'));
        document.getElementById("id-model-update").value = id_model;
        document.getElementById("id-kendaraan-update").value = id_kendaraan;
        document.getElementById("nama-model-update").value = model;
        document.getElementById("plat-nomor-update").value = platNomor;
        myModal.show();
      }

      function deleteUnit(platNomor, id_kendaraan){
        var myModal = new bootstrap.Modal(document.getElementById('deleteForm'));
        document.getElementById("id-kendaraan-hapus").value = id_kendaraan;
        document.getElementById("plat-nomor-hapus").value = platNomor;
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

      <div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Unit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="id-model-kendaraan" class="col-form-label d-none">ID Model</label>
                <input type="text" class="form-control d-none" id="id-model-kendaraan" name="id-model-kendaraan" readonly>
              </div>
              <div class="form-group">
                <label for="model-kendaraan" class="col-form-label">Model Mobil</label>
                <input type="text" class="form-control" id="model-kendaraan" name="model-kendaraan" readonly>
              </div>
              <div class="form-group">
                <label for="plat-nomor-kendaraan" class="col-form-label">Plat Nomor Kendaraan</label>
                <input type="text" class="form-control" id="plat-nomor-kendaraan" name="plat-nomor-kendaraan" required>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-add" type="submit" class="btn btn-primary" name="submit-add">Tambahkan</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Unit Kendaraan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <div class="form-group">
                <label for="id-model-update" class="col-form-label d-none">ID Model</label>
                <input type="text" class="form-control d-none" id="id-model-update" name="id-model-update" readonly>
              </div>
              <div class="form-group">
                <label for="id-kendaraan-update" class="col-form-label">ID Kendaraan</label>
                <input type="text" class="form-control" id="id-kendaraan-update" name="id-kendaraan-update" readonly>
              </div>
              <div class="form-group">
                <label for="nama-model-update" class="col-form-label">Model Mobil</label>
                <input type="text" class="form-control" id="nama-model-update" name="nama-model-update" readonly>
              </div>
              <div class="form-group">
                <label for="plat-nomor-update" class="col-form-label">Plat Nomor</label>
                <input type="text" class="form-control" id="plat-nomor-update" name="plat-nomor-update" required>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-update" type="submit" class="btn btn-warning" name="submit-update">Perbaharui</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="deleteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Unit Kendaraan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin untuk menghapus data kendaraan ini?
              </p>
              <div class="form-group">
                <label for="id-kendaraan-hapus" class="col-form-label">ID Kendaraan</label>
                <input type="text" class="form-control" id="id-kendaraan-hapus" name="id-kendaraan-hapus" readonly>
              </div>
              <div class="form-group">
                <label for="plat-nomor-hapus" class="col-form-label">Plat Nomor</label>
                <input type="text" class="form-control" id="plat-nomor-hapus" name="plat-nomor-hapus" readonly="">
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-delete" type="submit" class="btn btn-danger" name="submit-delete">Hapus</button>
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