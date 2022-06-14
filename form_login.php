<?php
session_start();
if(isset($_SESSION["login_admin"])) {
    header("location: beranda_admin.php");
    exit;
}

if(isset($_SESSION["login_pelanggan"])) {
    header("location: beranda_user.php");
    exit;
}

require 'functions.php';
if (isset($_POST["submit"])) {
  if (ctype_space($_POST["username_login"]) && ctype_space($_POST["password_akun_login"])) {
    echo "<script> alert('Tolong isi data anda dengan benar!'); </script>";
  } else {
    $wrong_pass = false;
    $wrong_pass = login($_POST);
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

    <!-- <link rel="icon" href="Images/Logo/logo_square.png" type="image/x-icon" /> -->
    <title>Sewa Mobil</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- <a href="index.php" class="navbar-brand ms-3"><img src="Images/Logo/logo_square.png" style="max-height:60px;" class="img-fluid"></a> -->
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-3" id="navbarTogglerDemo01">
            
         
        </div>
    </nav>

    <h1 class="text-center mb-4 mt-4">Login</h1>

    <?php if(isset($wrong_pass)): ?>
        <div class="mb-3 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 alert alert-danger alert-dismissible fade show" role="alert">
            Username atau password anda salah!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="container-fluid-md mx-auto" style="max-width:40%; margin-top:30px; margin-bottom:30px;">
      <form class="ms-3 me-3 shadow " style="padding:30px; border-radius:20px;" action="#" method="post">
        <div class="mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="username_login">
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password_akun_login">
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-outline-dark col-sm-3">Login</button>
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