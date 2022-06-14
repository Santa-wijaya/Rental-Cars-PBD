<?php 

require 'functions.php';
$message = 0;
$data_tidak_lengkap = 0;
$data_kosong = 0;
if (isset($_POST["submit"])) {
  if (ctype_space($_POST["NIK"]) || ctype_space($_POST["nama"]) || ctype_space($_POST["alamat"]) || ctype_space($_POST["nomor_telepon"] || ctype_space($_POST["username"])) || ctype_space($_POST["password_akun_login"])) {
    $data_kosong = 1;
  } elseif ($_POST['asal_kabupaten'] === "Pilih satu") {
    $data_tidak_lengkap = 1;
  } else {
      $message = register_new_user($_POST);
  }
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="icon" href="Images/Logo/logo_square.png" type="image/x-icon" />
    <title>Sewa Mobil</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="index.php" class="navbar-brand ms-3"><img src="Images/Logo/logo_square.png" style="max-height:60px;" class="img-fluid"></a>
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-3" id="navbarTogglerDemo01">
            <ul class = "navbar-nav mx-auto">
              <li class="nav-item me-5"><a class = "nav-link" href="index.php#teratas">Pickup dan Truck</a></li>
              <li class="nav-item"><a class = "nav-link" href="index.php#hubungi" >Hubungi Kami</a></li>
            </ul>
            <a class="btn btn-primary btn-dark me-3" href="form_registrasi.php" role="button">Signup</a>
            <a class="btn btn-primary btn-dark me-3" href="form_login.php" role="button">Login</a>
        </div>
    </nav>

    <h1 class="text-center mb-4 mt-4">Registration</h1>
    <?php if($data_kosong == 1): ?>
      <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
            Lengkapi seluruh field dengan benar!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <?php if($data_tidak_lengkap == 1): ?>
      <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
            Data asal kabupaten belum lengkap! lengkapi seluruh field!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <?php if($message == 1): ?>
      <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
            Password konfirmasi tidak sama!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif($message == 2): ?>
      <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
            NIK sudah digunakan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif($message == 3): ?>
      <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
            Username sudah digunakan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif($message == 4): ?>
      <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-success alert-dismissible fade show" role="alert">
            Akun berhasil diregistrasikan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="container-fluid-md mx-auto" style="max-width:40%; margin-top:30px; margin-bottom:30px;">
      <form class="ms-3 me-3 shadow " style="padding:30px; border-radius:20px;" action="#" method="post">
        <div class="mb-3">
            <label for="inputNIK" class="form-label">NIK</label>
            <input type="text" class="form-control" name="NIK" id="inputNIK" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="inputNama" class="form-label">Nama</label>
          <input type="text" class="form-control" id="inputNama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="inputAlamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="inputAlamat" name="alamat" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="inputKabupaten">Kabupaten/Kota</label>
            <select class="form-select" id="inputKabupaten" name="asal_kabupaten" required>
              <option selected>Pilih satu</option>
              <option value="Badung">Badung</option>
              <option value="Bangli">Bangli</option>
              <option value="Buleleng">Buleleng</option>
              <option value="Gianyar">Gianyar</option>
              <option value="Jembrana">Jembrana</option>
              <option value="Karangasem">Karangasem</option>
              <option value="Klungkung">Klungkung</option>
              <option value="Tabanan">Tabanan</option>
              <option value="Denpasar">Denpasar</option>
            </select>
          </div>
        <div class="mb-3">
            <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
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
        <div class="mb-3">
            <label for="inputNomorTelepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" name="nomor_telepon" id="inputNomorTelepon" required>
        </div>
        <div class="mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="inputUsername" required>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password_akun_login" id="inputPassword" required>
        </div>
        <div class="mb-3">
            <label for="inputPassword2" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" name="password_akun_konfirmasi" id="inputPassword2" required>
        </div>
        <div class="text-center mb-3">
            <button type="submit" name = "submit" class="btn btn-outline-dark col-sm-3">Register</button>
        </div>
      </form>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>