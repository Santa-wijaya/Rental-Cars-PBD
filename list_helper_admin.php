<?php 
	session_start();
	require 'functions.php';
  if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
  $tuples = read("SELECT * FROM helper");

  if(isset($_POST["submit"])) {
    $insert_status = null;
    $insert_status = insert_helper($_POST, $_FILES);
    if (isset($insert_status)) {
      if ($insert_status === true) {
        $_SESSION["bool_status_input"] = true;
      } else {
        $_SESSION["bool_status_input"] = false;
      }
      header("location: list_helper_admin.php");
      exit;
    }
  }

  if(isset($_POST["search-helper"])) {
    $keyword = $_POST["keyword-search-helper"];
    $tuples = read("SELECT * FROM helper WHERE nama LIKE '%$keyword%'");
  }

  if(isset($_POST["submit-update"])) {
    $update_status = null;
    $update_status = update_helper($_POST, $_FILES);
    if (isset($update_status)) {
      if ($update_status === true) {
        $_SESSION["bool_status_update"] = true;
      } else {
        $_SESSION["bool_status_update"] = false;
      }
      header("location: list_helper_admin.php");
      exit;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styling.css">
    <link rel="icon" href="Images/Logo/logo_square.png" type="image/x-icon" />
    <title>Sewa Mobil</title>
  </head>
  <body>
  	<input type="checkbox" id="hamburger-menu">
  	<nav>
  		<a href="index.php" class="logo"><img src="Images/Logo/logo_square.png" style="max-height:60px;" class="img-fluid"></a>
  		<button type="button" id = "logout-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLogout">
        Logout
      </button>
  		<label for="hamburger-menu" class="hamburger"><i class="fa fa-bars"></i></label>
  	</nav>

  	<div class="sidebar">
  		<h2> Admin </h2>	
  		<a href="beranda_admin.php"><i class="fa fa-home"></i><span>Beranda</span></a>
      <a href="list_model_kendaraan_admin.php"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
  		<a href="list_driver_admin.php"><i class = "fa fa-address-book"></i><span>List Driver</span></a>
  		<a href="list_helper_admin.php" style="background-color: #b34509;"><i class = "fa fa-address-book-o"></i><span>List Helper</span></a>
      <a href="list_pelanggan_admin.php"><i class = "fa fa-user"></i><span>List Pelanggan</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_admin.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
      <form action="" method="post" autocomplete="off" class="search-form">
        <div class="utility-bar">
            <div></div>
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Cari berdasarkan nama" name="keyword-search-helper">
                <label for="floatingInput">Cari Berdasarkan Nama</label>
              </div>
              <button type="submit" class="fa fa-search btn btn-dark searchbtn" name="search-helper"></button>
            </div>
        </div>
      </form>
      <?php if(isset($_SESSION["bool_status_input"]) && $_SESSION["bool_status_input"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Data helper berhasil ditambahkan!
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
            Data helper berhasil diperbaharui!
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
            Data helper berhasil dihapuskan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["delete_bool"]); ?>
      <?php elseif(isset($_SESSION["delete_bool"]) && $_SESSION["delete_bool"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Data helper tidak berhasil dihapuskan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["delete_bool"]); ?>
      <?php endif; ?>

      <div class="row card-container">
        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto btn shadow" style="width: 18rem; height: 397px; margin-bottom:20px;">
              <i class = "fa fa-plus-circle" style="line-height: 300px; font-size: 7rem; color: green;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
              <p>Tambah Helper</p>
            </div>
        </div>
        <?php foreach ($tuples as $tuple): ?>
          <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto shadow" style="width: 18rem; margin-bottom:20px;">
              <img class="card-img-top" src="Images/Helper/<?= $tuple["nama_foto"]; ?>" alt="Gambar <?= $tuple["nama"] ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $tuple["nama"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Jenis Kelamin: <?= $tuple["jenis_kelamin"] ?></li>
                <li class="list-group-item">Harga: <?= $tuple["tarif"] ?>/hari</li>
              </ul>
              <div class="card-body text-center">
                <a class="btn btn-primary" role="button" onclick="updateData('<?= $tuple['ID_helper'] ?>', '<?= $tuple['nama'] ?>', '<?= $tuple['jenis_kelamin'] ?>', '<?= $tuple['tarif'] ?>', '<?= $tuple['nama_foto'] ?>')">Ubah Data</a>
                <a class="btn btn-danger" href="deletelogic.php?p_k=<?= $tuple["ID_helper"]; ?>&type=Helper" role="button" onclick="return confirm('Apakah anda yakin akan menghapus data helper <?= $tuple["nama"] ?>?')">Hapus</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <script type="text/javascript">
      function updateData(id, nama, jenis_kelamin, tarif, nama_foto){
        var myModal = new bootstrap.Modal(document.getElementById('updateForm'));
        document.getElementById("id-helper").value = id;
        document.getElementById("nama-helper-update").value = nama;
        document.getElementById("harga-helper-update").value = tarif;
        document.getElementById("harga-helper-update").value = tarif;
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
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Helper</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="nama-helper" class="col-form-label">Nama Helper</label>
                <input type="text" class="form-control" id="nama-helper" name="nama-helper" required>
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
                  <label for="harga-helper" class="col-form-label">Harga/hari (Rp):</label>
                  <input type="text" class="form-control" id="harga-helper" name="harga" required>
              </div>
              <div class="form-group">
                  <label for="gambar-helper" class="col-form-label">Foto helper:</label>
                  <input type="file" class="form-control" id="gambar-helper" name="foto-helper" accept = "image/jpeg, image/jpg, image/png" required>
              </div>
              <div class="form-group text-center mt-2">
                  <input type="checkbox" name="konfirmasi-input" id="konfirmasi-input" value="agree" required>
                  <label for="konfirmasi-input" class="col-form-label">Konfirmasi Penambahan helper</label>
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
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data helper</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <div class="form-group">
                <label for="id-helper" class="col-form-label d-none">ID helper</label>
                <input type="text" class="form-control d-none" id="id-helper" name="id-helper" readonly>
              </div>
              <div class="form-group">
                <label for="nama-helper-update" class="col-form-label">Nama helper</label>
                <input type="text" class="form-control" id="nama-helper-update" name="nama-helper-update" required>
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
                  <label for="harga-helper-update" class="col-form-label">Harga/hari (Rp)</label>
                  <input type="text" class="form-control" id="harga-helper-update" name="harga-helper-update" required>
              </div>
              <div class="form-group">
                  <label for="gambar-helper-update" class="col-form-label">Unggah Foto Baru</label>
                  <input type="file" class="form-control" id="gambar-helper-update" name="foto-helper-update" accept = "image/jpeg, image/jpg, image/png">
              </div>
              <div class="form-group text-center mt-2">
                  <input type="checkbox" name="konfirmasi-input" id="konfirmasi-input" value="agree" required>
                  <label for="konfirmasi-input" class="col-form-label">Konfirmasi Perubahan Data Helper</label>
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
  </body>
</html>