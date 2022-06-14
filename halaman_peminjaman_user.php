<?php 
	session_start();
	require 'functions.php';
  $id_model = $_GET['p_k_model'];
  $model_data = read("SELECT * FROM tipe_kendaraan WHERE ID_model = $id_model");
  // $harga_helper = read("SELECT tarif FROM helper LIMIT 1;");
  $harga_driver = read("SELECT tarif FROM driver LIMIT 1;");
  $harga_driver = $harga_driver[0]['tarif'];
  // $harga_helper = $harga_helper[0]['tarif'];

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
  		<a href="beranda_user.php" class="logo"><img src="Images/Logo/logo_square.png" style="max-height:60px;" class="img-fluid"></a>
      <button type="button" id = "logout-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Logout
      </button>

  		<label for="hamburger-menu" class="hamburger"><i class="fa fa-bars"></i></label>
  	</nav>

  	<div class="sidebar">
  		<h2>
  			<?= $_SESSION["username"]?>
  		</h2>
  		<a href="profil_user.php"><i class="fa fa-user"></i><span>Profil</span></a>
  		<a href="beranda_user.php" style="background-color: #b34509;"><i class="fa fa-home"></i><span>Beranda</span></a>
  		<a href="request_peminjaman_user.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="list_peminjaman_user.php"><i class = "fa fa-credit-card-alt"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_user.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#exampleModal"><span>Logout</span></a>
  	</div>
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
                  <li>Harga peminjaman seorang driver adalah Rp<?= $harga_driver ?>/Hari.</li>
                </ol>
                
            </div>
            <div class="col-xxl-4 form-s shadow-sm">
            
            <form method="POST" onsubmit="reserveConfirmation(<?= $harga_driver ?>, <?= $model_data[0]["harga_sewa"] ?>)">
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
                <!-- <div class="mb-3">
                    <label for="helper" class="#"></label>
                    <input type="number" value="0" class="#" id="helper" min="0" max="2">
                </div> -->
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

    <!-- JAVASCRIPT --> 
    <script type="text/javascript">
      function reserveConfirmation(harga_driver, harga_kendaraan){
        event.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('reservationConfirm'));
        var tanggal_peminjaman = document.getElementById("tanggalPeminjaman").value;
        var tanggal_pengembalian = document.getElementById("tanggalPengembalian").value;
        // var jumlah_helper = document.getElementById("helper").value;
        var formatted_peminjaman = new Date(tanggal_peminjaman);
        var formatted_pengembalian = new Date(tanggal_pengembalian);
        var jumlah_hari = (formatted_pengembalian.getTime() - formatted_peminjaman.getTime())/(1000 * 60 * 60 * 24) + 1;
        if(document.getElementById("ya").checked) {
            var driver = "Ya";
            var harga = jumlah_hari * ((harga_kendaraan) + (harga_driver));
        } else {
            var driver = "Tidak";
            var harga = jumlah_hari * ((harga_kendaraan));
        }
        document.getElementById("konfirmasi-tgl-peminjaman").value = tanggal_peminjaman;
        document.getElementById("konfirmasi-tgl-pengembalian").value = tanggal_pengembalian;
        document.getElementById("konfirmasi-driver").value = driver;
        // document.getElementById("konfirmasi-helper").value = jumlah_helper;
        document.getElementById("konfirmasi-biaya").value = harga;


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
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    
    <div class="modal" id="reservationConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Request Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <!-- <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
                <div class="form-group">
                    <label for="konfirmasi-tgl-peminjaman" class="col-form-label">Tanggal Peminjaman</label>
                    <input type="text" class="form-control" id="konfirmasi-tgl-peminjaman" name="konfirmasi-tgl-peminjaman" readonly>
                </div>
                <div class="form-group">
                    <label for="konfirmasi-tgl-pengembalian" class="col-form-label">Tanggal Pengembalian</label>
                    <input type="text" class="form-control" id="konfirmasi-tgl-pengembalian" name="konfirmasi-tgl-pengembalian" readonly>
                </div>
                <div class="form-group">
                    <label for="konfirmasi-driver" class="col-form-label">Membutuhkan Driver</label>
                    <input type="text" class="form-control" id="konfirmasi-driver" name="konfirmasi-driver" readonly>
                </div>
                <!-- <div class="#">
                    <label for="konfirmasi-helper" class="#"></label>
                    <input type="#" class="#" id="konfirmasi-helper" name="konfirmasi-helper" readonly>
                </div> -->
                <div class="form-group">
                    <label for="konfirmasi-biaya" class="col-form-label">Biaya Peminjaman (Rp)</label>
                    <input type="text" class="form-control" id="konfirmasi-biaya" name="konfirmasi-biaya" readonly>
                </div>
                <div class="text-center mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button id="submit-request" type="submit" class="btn btn-success" name="submit-request">Request</button>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    

  </body>
</html>